<?php

namespace App\Jobs;

use App\Friend;
use App\Jobs\Job;
use App\TwitterProfile;
use App\Twitter\Images\Downloader;
use Config;
use Exception;
use Illuminate\Cache\CacheManager as Cache;
use Illuminate\Log\Writer as Logger;
use Thujohn\Twitter\Twitter as TwitterClient;

class PullTwitterUser extends Job
{
    /**
     * Local Twitter profile cache length in minutes
     */
    const PULL_CACHE_LENGTH = 10080;

    protected $client;
    protected $cache;
    protected $profile;
    protected $friend;
    private $logger;
    protected $job;
    private $downloader;

    public function __construct(TwitterClient $client, Cache $cache, Logger $logger, TwitterProfile $profile, Friend $friend, Downloader $downloader)
    {
        $this->client = $client;
        $this->cache = $cache;
        $this->logger = $logger;
        $this->profile = $profile;
        $this->friend = $friend;
        $this->downloader = $downloader;
    }

    public function fire($job, $data)
    {
        $this->job = $job;

        $this->guardAgainstInvalidJobData($data);

        $twitterHandle = $data['twitterHandle'];
        $friendId = $data['friendId'];

        // Ensure Person still exists
        try {
            $friend = $this->friend->findOrFail($friendId);
        } catch (Exception $e) {
            return $this->job->delete();
        }

        $profile = $this->updateOrCreateTwitterProfile($twitterHandle);

        $friend->twitter_id = $profile->id;
        $friend->save();

        $this->downloader->cacheProfilePic($profile);

        $this->job->delete();
    }

    /**
     * Guard against invalid job data
     *
     * @param $data
     * @throws Exception
     */
    private function guardAgainstInvalidJobData($data)
    {
        if (! array_key_exists('twitterHandle', $data) || ! array_key_exists('friendId', $data)) {
            $this->job->delete();
            throw new Exception('Invalid queue job.');
        }
    }

    /**
     * Update (or create) TwitterProfile for given Twitter screen name, and return TwitterProfile
     *
     * @param string $screenName
     * @return Friend|null
     * @throws Exception
     */
    protected function updateOrCreateTwitterProfile($screenName)
    {
        $this->logger->info('Pulling twitter profile by screen name for ' . $screenName);

        if (! $result = $this->getTwitterProfileByScreenName($screenName)) {
            throw new Exception('Failed Twitter result pulling for screen name ' . $screenName);
        }

        // @todo: Store when last pulled somewhere (is just on the put expiration date maybe?)

        $profile = $this->profile->firstOrCreate(['twitter_id' => $result->id]);

        $profile->name = $result->name;
        $profile->screen_name = $result->screen_name;
        $profile->location = $result->location;
        $profile->description = $result->description;
        $profile->url = $result->url;
        $profile->profile_image_url = $result->profile_image_url;
        $profile->profile_image_url_https = $result->profile_image_url_https;

        $profile->save();

        return $profile;
    }

    /**
     * Pull Twitter profile for a given twitter handle
     *
     * @todo Look up if we already have a TwitterProfile; if so, update if it's older than  cache time (?)
     * @param string $screenName
     * @throws Exception
     * @return stdClass
     */
    protected function getTwitterProfileByScreenName($screenName)
    {
        $twitterProfileResponse = $this->client->getUsersLookup(['screen_name' => $screenName]);

        $this->guardAgainstInvalidTwitterResponse($twitterProfileResponse, $screenName);

        return $twitterProfileResponse[0];
    }

    /**
     * Guard against myriad Twitter error responses
     *
     * @param $twitterProfileResponse
     * @param $screenName
     * @throws Exception
     */
    protected function guardAgainstInvalidTwitterResponse($twitterProfileResponse, $screenName)
    {
        if ($twitterProfileResponse === null || empty($twitterProfileResponse)) {
            throw new Exception('No result from Twitter');
        }

        $this->guardAgainstErrorResponse($twitterProfileResponse, $screenName);
    }

    /**
     * Checks for errored twitter response
     *
     * @param $twitterResponse
     * @param $twitterHandle
     * @return bool
     * @throws Exception
     */
    protected function guardAgainstErrorResponse($twitterResponse, $twitterHandle)
    {
        if (! is_array($twitterResponse) && isset($twitterResponse->errors)) {
            $error = $twitterResponse->errors[0];

            switch ($error->code) {
                case 88:
                    $this->logger->error('Twitter rate limit exceeded.');
                    throw new Exception('Twitter rate limit exceeded.');
                    break;
                case 34:
                    $this->logger->info('Deleted job to pull profile info for 404ed user ' . $twitterHandle);
                    $this->job->delete();
                    throw new TwitterUserDoesNotExistException('Deleted job to pull profile info because user 404\'ed.');
                    break;
                default:
                    $this->logger->error('Unexpected Twitter code ' . $error->code . ' received. Message is: ' . $error->message);
                    throw new Exception('Unexpected Twitter code ' . $error->code . ' received. Message is: ' . $error->message);
                    break;
            }
        }

        return false;
    }
}
