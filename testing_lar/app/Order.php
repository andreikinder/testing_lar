<?php


namespace App;


class Order
{

    protected $products;

    public function __construct()
    {
        $this->products = array();
    }

    public function add($product)
    {
        $this->products []= $product;
    }

    public function products()
    {
        return $this->products;
    }

    public function total()
    {

        return array_reduce($this->products, function ($carry, $product) {
           return $carry + $product->cost();
        });
//        $total = 0;
//
//        foreach ($this->products as $product) {
//            $total += $product->cost();
//        }
//
//        return $total;
    }
}
