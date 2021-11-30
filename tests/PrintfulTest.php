<?php
use PHPUnit\Framework\TestCase;

class PrintfulTest extends TestCase
{
    public function testSuccessCacheScalarAttribute()
    {
        $cache = new CacheService;
        $this->assertFalse(!$cache->set("attribute_1", "value", 300));
    }

    public function testSuccessCacheArrayAttribute()
    {
        $cache = new CacheService;
        $this->assertFalse(!$cache->set("attribute_2", [1,2,3,4,5], 300));
    }

    public function testSuccessCacheScalarAttributeNoDuration()
    {
        $cache = new CacheService;
        $this->assertFalse(!$cache->set("attribute_3", "value", 0));
    }

    public function testFailureCacheScalarAttribute()
    {
        $cache = new CacheService;
        $this->assertFalse($cache->set("attribute_1\\123", "value", 300));
    }

    public function testFailureCacheArrayAttribute()
    {
        $cache = new CacheService;
        $this->assertFalse($cache->set("attribute_2\\123", [1,2,3,4,5], 300));
    }

    public function testFailureReadScalarAttributeNoDuration()
    {
        $cache = new CacheService;
        $this->assertNull($cache->get("attribute_3"));
    }

    public function testSuccessCacheShippingOptions()
    {
        $printfulService = new PrintfulShippingRateService();
        $this->assertTrue($printfulService->cacheShippingOptions());
    }

    public function testSuccessReadShippingOptions()
    {
        $cache = new CacheService;
        $this->assertIsObject($cache->get("attribute_4"));
    }
}