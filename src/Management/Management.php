<?php
namespace Course\Management;

use \Anax\Database\ActiveRecordModel;
use \Course\Order\OrderItem;
use \Course\Order\Orders;
use \Course\Product\Product;

class Management extends ActiveRecordModel
{

    public function getAllOrders1Month($db)
    {
        $order = new Orders();
        $order->setDb($db);

        $orders = $order->getAllOrders1Month();
        return $orders;
    }



    public function getAllOrderItems($orders, $db)
    {
        $orderItems = [];

        foreach ($orders as $order) {
            $orderItem = new OrderItem();
            $orderItem->setDb($db);

            $products = $orderItem->getAllItemsWhereID($order->orderID);
            foreach ($products as $value) {
                if (array_key_exists($value->productID, $orderItems)) {
                    $productAmount = ((int) $orderItems[$value->productID]->productAmount + $value->productAmount);
                    $orderItems[$value->productID]->totalBought = $productAmount;
                    continue;
                }

                $orderItems[$value->productID] = $value;
                $orderItems[$value->productID]->totalBought = $value->productAmount;
            }
        }

        return $orderItems;
    }



    public function getAllProductsFromOrderItem($orderItems, $db)
    {
        $products = [];

        foreach ($orderItems as $value) {
            $product = new Product();
            $product->setDb($db);
            $product->getProductByID($value->productID);

            $res = array_merge((array) $product, ["totalBought" => $value->totalBought]);
            $products[] = (object) $res;
        }

        return $products;
    }

}
