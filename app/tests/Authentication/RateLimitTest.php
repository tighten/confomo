<?php  namespace tests\Authentication;

use Confomo\Authentication\RateLimit;
use Mockery as M;

class RateLimitTest extends \TestCase
{
    protected $ip = '111.222.333.444';

    protected $prefix = 'tester';

    protected $defaultLength = 15;

    protected $throttleKey;

    protected $prefixedThrottleKey;

    public function setUp()
    {
        parent::setUp();

        $cache = M::mock('Illuminate\Cache\CacheManager');
        $rateLimit = new rateLimit($cache);

        $this->throttleKey = $rateLimit->getThrottleKey($this->ip);
        $this->prefixedThrottleKey = $rateLimit->getThrottleKey($this->ip, $this->prefix);
    }

    public function test_can_increment_cache()
    {
        $cache = M::mock('Illuminate\Cache\CacheManager');
        $cache->shouldReceive('get')
            ->with($this->throttleKey, 0)
            ->once()
            ->andReturn(0);

        $cache->shouldReceive('put')
            ->with($this->throttleKey, 1, $this->defaultLength)
            ->once();

        $rateLimit = new RateLimit($cache);
        $rateLimit->incrementRateLimit($this->ip);
    }

    public function test_can_fail_if_limit_exceeded()
    {
        $cache = M::mock('Illuminate\Cache\CacheManager');
        $cache->shouldReceive('get')
            ->with($this->throttleKey)
            ->once()
            ->andReturn(11);

        $rateLimit = new RateLimit($cache);
        $rateLimit->setMaxRequests(10);
        $this->assertTrue($rateLimit->rateLimitExceeded($this->ip));
    }

    public function test_wont_error_if_limit_not_exceeded()
    {
        $cache = M::mock('Illuminate\Cache\CacheManager');
        $cache->shouldReceive('get')
            ->with($this->throttleKey)
            ->once()
            ->andReturn(9);

        $rateLimit = new RateLimit($cache);
        $rateLimit->setMaxRequests(10);
        $this->assertFalse($rateLimit->rateLimitExceeded($this->ip));
    }

    public function test_methods_honor_prefix()
    {
        $cache = M::mock('Illuminate\Cache\CacheManager');
        $cache->shouldReceive('get')
            ->with($this->prefixedThrottleKey)
            ->once()
            ->andReturn(1);

        $rateLimit = new RateLimit($cache);
        $this->assertFalse($rateLimit->rateLimitExceeded($this->ip, $this->prefix));
    }

    public function test_prefix_affects_key()
    {
        $this->assertNotEquals($this->throttleKey, $this->prefixedThrottleKey);
    }
}
