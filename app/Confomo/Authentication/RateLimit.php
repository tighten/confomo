<?php  namespace Confomo\Authentication;

use Illuminate\Cache\CacheManager;

/**
 * Simple implementation of a rate-limit style throttler.
 * Explicitly available for cache systems with no `increment` method.
 *
 * Note: Each increment increases the expiration time of the throttling, so
 *       it's not "15 request in 15 minutes" but "15 requests in the time period
 *       extending to 15 minutes after the last request"
 *
 * @todo    Replace CacheManager dependency to use Illuminate Cache Contract once 4.3 is out
 * @package Confomo\Authentication
 */
class RateLimit
{
	/**
	 * Maximum number of requests allowed during the given period
	 *
	 * @var int
	 */
	protected $throttle_max_requests = 15;

	/**
	 * Duration of the given period in minutes
	 *
	 * @var int
	 */
	protected $throttle_duration = 15;

	/**
	 * Prefix for the cache key
	 *
	 * @var string
	 */
	protected $throttle_key_prefix = 'loginThrottle';

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
		$prefix ?: $this->throttle_key_prefix;
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
		return ($this->cache->get($this->getThrottleKey($ip, $prefix)) > $this->throttle_max_requests);
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
		$this->cache->put($this->getThrottleKey($ip, $prefix), $count, $this->throttle_duration);
	}

	/**
	 * Set number of requests to throttle to
	 *
	 * @param int $throttle_max_requests
	 */
	public function setThrottleMaxRequests($throttle_max_requests)
	{
		$this->throttle_max_requests = $throttle_max_requests;
	}

	/**
	 * Set length of time (in minutes) to limit throttle
	 *
	 * @param int $throttle_duration
	 */
	public function setThrottleDuration($throttle_duration)
	{
		$this->throttle_duration = $throttle_duration;
	}

	/**
	 * Set throttle key prefix
	 *
	 * @param string $throttle_key_prefix
	 */
	public function setThrottleKeyPrefix($throttle_key_prefix)
	{
		$this->throttle_key_prefix = $throttle_key_prefix;
	}
}
