<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Prophecy\PhpUnit\ProphecyTrait;
use Tests\TestCase;

class PropTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function it_normalize_a_string_for_the_cache_key()
    {

        $cache = $this->prophesize( RussianCache::class);
        $directive =  new BladeDirective($cache->reveal());

        $cache->has('cache-key')->shouldBeCalled();
        $directive->setUp('cache-key');

        //$response = $this->get('/');

//        $directive->foo('bar')->shouldBeCalled()->willReturn('foobar');
//
//        $response = $directive->reveal()->foo('bar');
//        $this->assertEquals('foobar', $response);

    }

    /**
     * @test
     */
    public function it_normalize_a_cacheablemodel_for_the_cache_key_1()
    {

        $cache = $this->prophesize( RussianCache::class);
        $directive =  new BladeDirective($cache->reveal());

        $cache->has('stub-cache-key')->shouldBeCalled();
        $directive->setUp(new ModelStub);



    }

    /**
     * @test
     */
    public function it_normalize_a_array_for_the_cache_key_1()
    {

        $cache = $this->prophesize( RussianCache::class);
        $directive =  new BladeDirective($cache->reveal());


        $item = ['foo', 'bar'];

        $cache->has(md5('foobar'))->shouldBeCalled();
        $directive->setUp($item);



    }
}


class ModelStub {
    public function getCacheKey()
    {
        return 'stub-cache-key';
    }
}

class RussianCache
{
    public function has() {

    }

}


class BladeDirective {
    /**
     * @var RussianCache
     */
    protected $cache;

    public function __construct(RussianCache $cache)
    {
        $this->cache = $cache;
    }

//    public function foo($string) {
//        return  'foobar';
//    }

    public function setUp( $key)
    {
        $this->cache->has(
           $this->normalizeKey( $key)
        );
    }

    protected function normalizeKey($item)
    {
        if (is_object($item) && method_exists($item, 'getCacheKey') )
        {
            return $item->getCacheKey();
        }

        if (is_array($item))
        {
            return  md5(implode($item));
        }

        return  $item;
    }
}
