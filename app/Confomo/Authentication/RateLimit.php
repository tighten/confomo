<?php  namespace Confomo\Authentication;

use Illuminate\Cache\CacheManager;

/**
 * Simple implementation of a rate-limit style throttler. The purpose is to
 * limit the amount of times a particular IP address can have a failed login.
 *
 * Explicitly available for cache systems with no `increment` method.
 *
 * Note: Each increment increases the expiration time of the throttling, so
 *       it's not "15 request in 15 minutes" but "15 requests in the time period
 *       extending to 15 minutes after the last request"
 *
 * <code>
 * public function controllerPostLogin()
 * {
 *     $client_ip_address = $_SERVER['REMOTE_ADDR']; // Or something more capable
 *
 *     if ($this->rateLimit->rateLimitExceeded($client_ip_address)
 *     {
 *         exit('Quit hacking me son');
 *     }
 *
 *     // Check for actual login
 *
 *     if ($login_failed)
 *     {
 *         $this->rateLimit->incrementRateLimit($client_ip_address);
 *     }
 * }
 * </code>
 *
 * @todo    Replace CacheManager dependency to use Illuminate Cache Contract once 4.3 is out, and PSR cache when it's available
 * @package Confomo\Authentication
 */
class RateLimit
{
	/**
	 * Number of attempts after which to start sleeping each attempt
	 *
	 * After this many failed attempts, each attempt will get a sleep for
	 * (# attempts - $sleep_after) seconds (to avoid brute force attacks)
	 *
	 * Set to a negative number to disable
	 *
	 * @var int (?)
	 */
	protected $sleepAfter = 5;

	/**
	 * Maximum number of requests allowed during the given period
	 *
	 * @var int
	 */
	protected $maxRequests = 15;

	/**
	 * Duration of the given period in minutes
	 *
	 * @var int
	 */
	protected $duration = 15;

	/**
	 * Prefix for the cache key
	 *
	 * @var string
	 */
	protected $defaultKeyPrefix = 'loginThrottle';

	/**
	 * @var CacheManager
	 */
	private $cache;

	public function __construct(CacheManager $cache)
	{
		$this->cache = $cache;
	}

	/**
	 * Get the cache key for this throttle
	 *
	 * @param string $ip
	 * @return string
	 */
	public function getThrottleKey($ip, $prefix = null)
	{
		$prefix ?: $this->defaultKeyPrefix;
		return sprintf('%s:%s', $prefix, $ip);
	}

	/**
	 * Return whether or not this IP address has been rate limited
	 *
	 * @param string $ip     IP address
	 * @param string $prefix Optional manual cache key prefix
	 * @return bool
	 */
	public function rateLimitExceeded($ip, $prefix = null)
	{
		return ($this->cache->get($this->getThrottleKey($ip, $prefix)) > $this->maxRequests);
	}

	/**
	 * Increment throttle count
	 *
	 * @param string $ip     IP address
	 * @param string $prefix Optional manual cache key prefix
	 */
	public function incrementRateLimit($ip, $prefix = null)
	{
		// Manually increment (file can't auto-increment)
		$count = $this->cache->get($this->getThrottleKey($ip, $prefix), 0);
		$count++;

		// Add to count
		$this->cache->put($this->getThrottleKey($ip, $prefix), $count, $this->duration);

		$this->doSleep($count);
	}

	/**
	 * Sleep for ($this->sleepAfter - $count) seconds
	 *
	 * @param int $count
	 */
	protected function doSleep($count)
	{
		if ($this->sleepAfter > 0 && $count > $this->sleepAfter)
		{
			sleep($count - $this->sleepAfter);
		}
	}

	/**
	 * Set number of requests to throttle to
	 *
	 * @param int $maxRequests
	 */
	public function setMaxRequests($maxRequests)
	{
		$this->maxRequests = $maxRequests;
	}

	/**
	 * Set length of time (in minutes) to limit throttle
	 *
	 * @param int $duration
	 */
	public function setDuration($duration)
	{
		$this->duration = $duration;
	}

	/**
	 * Set default throttle key prefix
	 *
	 * @param string $defaultKeyPrefix
	 */
	public function setDefaultKeyPrefix($defaultKeyPrefix)
	{
		$this->defaultKeyPrefix = $defaultKeyPrefix;
	}

	/**
	 * Set the number of attempts after which to start sleeping each request
	 *
	 * @param int $sleepAfter
	 */
	public function setSleepAfter($sleepAfter)
	{
		$this->sleepAfter = $sleepAfter;
	}
}
