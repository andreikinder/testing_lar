<?php

namespace Tests\Unit;

use App\Expression;
use PHPUnit\Framework\TestCase;

class ExpressionTest extends TestCase
{
    /**
     @test
     */
    public function it_finds_a_string()
    {
        $regex = Expression::make()->find('www');

        $this->assertTrue( $regex->test('www') );

        $regex = Expression::make()->then('www');

        $this->assertTrue( $regex->test('www'));
        //his->assertTrue(true);
    }

    /**
    @test
     */
    public function it_check_for_anything()
    {
        $regex = Expression::make()->anything();
        $this->assertTrue( $regex->test('foo') );
    }

    /**
    @test
     */
    public function it_maybe_has_a_value()
    {
        $regex = Expression::make()->maybe('http');
        $this->assertTrue( $regex->test('http') );
        $this->assertTrue( $regex->test('') );
    }

    /**
    @test
     */
    public function it_can_chain_methods_call()
    {
        $regex = Expression::make()->find('www')->maybe('.')->then('laracasts');
        $this->assertTrue( $regex->test('www.laracasts') );
        $this->assertFalse( $regex->test('wwwXlaracasts') );
    }

    /**
    @test
     */
    public function it_can_exclude_a_value()
    {
        $regex = Expression::make()
            ->find('foo')
            ->anythingBut('bar')
            ->then('biz');

        $this->assertTrue( $regex->test('foohttpbiz') );
        $this->assertFalse( $regex->test('foobarbiz') );
    }
}
