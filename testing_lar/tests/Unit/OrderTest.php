<?php


namespace Tests\Unit;
use App\Product;
use App\Order;
use PHPUnit\Framework\TestCase;


class OrderTest extends  TestCase
{



    /** @test   */
    public function an_order_consists_of_products()
    {
        $order = new Order();

        $product = new Product('Fallout 4', 58);
        $product2 = new Product('Hogrwards', 7);

        $order->add($product);
        $order->add($product2);

         $this->assertEquals(2, count( $order->products() ) );
    }

    /** @test   */
    public function an_order_determine_the_total_costs_of_its_products()
    {
        $order = new Order();

        $product = new Product('Fallout 4', 58);
        $product2 = new Product('Hogrwards', 7);

        $order->add($product);
        $order->add($product2);

        $this->assertEquals(65,  $order->total()  );
    }


}
