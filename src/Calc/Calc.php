<?php
namespace Course\Calc;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

class Calc implements InjectionAwareInterface
{
    use InjectionAwareTrait;


    /**
     * Calculate price for items
     * @method calcPrice
     * @return integer total price.
     */
    public function calcPrice($products, $name = "amount")
    {
        $price = 0;

        foreach ((array) $products as $items) {
            $price += ((int) $items['productSellPrize'] * (int) $items[$name]);
        }

        return $price;
    }



    /**
     * Calculate amount of products in cart
     * @method calcAmount
     * @return   integer  amount of products in cart.
     */
    public function calcAmount($products, $name = "amount")
    {
        $amount = 0;

        foreach ((array) $products as $items) {
            $amount += (int) $items[$name];
        }

        return $amount;
    }



    /**
     * Calculate shipping price
     * @method calcShipping
     * @return array with shippingprice and weight.
     */
    public function calcShipping($products, $name = "amount")
    {
        $totalWeight = 0;

        foreach ((array) $products as $items) {
            $totalWeight += (int) $items['productWeight'] * (int) $items[$name];
        }

        $totalShipping = ($totalWeight / 1000) < 1 ? 50 : 50 + (20 * round($totalWeight / 1000));

        return [$totalShipping, $totalWeight];
    }

}
