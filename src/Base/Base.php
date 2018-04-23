<?php
namespace Course\Base;

use \Anax\Database\ActiveRecordModel;
use \Course\Order\OrderItem;
use \Course\Order\Orders;
use \Course\Product\Product;

class Base extends ActiveRecordModel
{
    /**
     * Function that will get top10 male/female products.
     * @method getTop10
     * @param  array $orderItems with orderItems.
     * @return array with top10s.
     */
    public function getTop10($orderItems, $db)
    {
        $product = new Product;
        $product->setDb($db);

        $maleTop10 = [];
        $femaleTop10 = [];

        foreach ($orderItems as $item) {
            $product->getProductByID($item->productID);
            if ($product->productGender == 0 && count($femaleTop10) < 10 && $product->productID !== null) {
                $femaleTop10[] = (array) $product;
                continue;
            }

            $maleTop10[] = (array) $product;
        }

        return [$femaleTop10, $maleTop10];
    }
}
