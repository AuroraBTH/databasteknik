<?php

namespace Course\Product;

use \Anax\Database\ActiveRecordModel;

class Product extends ActiveRecordModel {
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Product";

    /**
     * Columns in the table.
     *
     * @var integer $productID primary key auto incremented.
     * @var string $productManufacturer not null.
     * @var string $productName not null.
     * @var string $productOriginCountry not null.
     * @var integer $productWeight not null.
     * @var string $productSize not null.
     * @var integer $productSellPrize not null.
     * @var integer $productBuyPrize not null.
     * @var string $productColor not null.
     * @var integer $productAmount not null.
     * @var integer $productCategoryID.
     */

    public $productID;
    public $productManufacturer;
    public $productName;
    public $productOriginCountry;
    public $productWeight;
    public $productSize;
    public $productSellPrize;
    public $productBuyPrize;
    public $productColor;
    public $productAmount;
    public $productCategoryID;

    /**
     * Get product by key.
     *
     * @param mixed $key to use in where statement.
     * @param mixed $value to use in where statement.
     *
     * @return array with product(s) from database.
     */
    public function getProducts($key, $value)
    {
        $query = $key . " = ?";
        return $this->findAllWhere($query, $value);
    }



    public function getProductByID($productID){
        $res = $this->find("productID", $productID);
        // var_dump($res);
        return $res;
    }
}
