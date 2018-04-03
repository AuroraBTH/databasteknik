<?php

namespace Course\Product;

use \Anax\Database\ActiveRecordModel;

class Product extends ActiveRecordModel {
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Product";

    protected $tableIdColumn = "productID";

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
    public $productGender;
    public $productDeleted;



    public function setProductManufacturer($productManufacturer)
    {
        $this->productManufacturer = $productManufacturer;
    }



    public function setProductName($productName)
    {
        $this->productName = $productName;
    }



    public function setProductCountry($productOriginCountry)
    {
        $this->productOriginCountry = $productOriginCountry;
    }



    public function setProductWeight($productWeight)
    {
        $this->productWeight = $productWeight;
    }



    public function setProductSize($productSize)
    {
        $this->productSize = $productSize;
    }



    public function setProductSellPrize($productSellPrize)
    {
        $this->productSellPrize = $productSellPrize;
    }



    public function setProductBuyPrize($productBuyPrize)
    {
        $this->productBuyPrize = $productBuyPrize;
    }



    public function setProductColor($productColor)
    {
        $this->productColor = $productColor;
    }



    public function setProductAmount($productAmount)
    {
        $this->productAmount = $productAmount;
    }



    public function setProductCategoryID($productCategoryID)
    {
        $this->productCategoryID = $productCategoryID;
    }



    public function setProductGender($productGender)
    {
        $this->productGender = $productGender;
    }



    public function setProductDeleted($deleted)
    {
        $this->productDeleted = $deleted;
    }






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
        $query = $key . " = ? and productDeleted = ?";
        return $this->findAllWhere($query, [$value, "false"]);
    }



    public function getAllProducts()
    {
        return $this->findAllWhere("productDeleted = ?", "false");
    }



    /**
     * Get product by key.
     *
     * @param mixed $key to use in where statement.
     * @param mixed $value to use in where statement.
     *
     * @return array with product(s) from database.
     */
    public function getProductsByGender($key, $value, $gender)
    {
        $query = $key . " = ? and productGender = ? and productDeleted = ?";
        return $this->findAllWhere($query, [$value, $gender, "false"]);
    }



    public function getProductByID($productID){
        $res = $this->findwhere("productID = ? and productDeleted = ?", [$productID, "false"]);
        return $res;
    }


    public function getProductsUnder500($gender, $limit) {
        if ($limit === null) {
            $sql = "SELECT * FROM Product WHERE productSellPrize <= 500 and productGender = ? and productDeleted = ?";
            $res = $this->findAllSql($sql, [$gender, "false"]);
        } elseif ($limit !== null) {
            $sql = "SELECT * FROM Product WHERE productSellPrize <= 500 and productGender = ? and productDeleted = ? LIMIT ?";
            $res = $this->findAllSql($sql, [$gender, "false", $limit]);
        }
        return $res;
    }



    public function getProductsWithLowAmount()
    {
        $res = $this->findAllWhere("productAmount <= ? and productDeleted = ?", [5, "false"]);
        return $res;
    }



    public function searchProducts($searchString) {
        $param = "[[:<:]]{$searchString}[[:>:]]";
        $sql = "SELECT * FROM Product WHERE productName REGEXP ? and productDeleted = ?";
        $res = $this->findAllSql($sql, [$param, "false"]);
        return $res;
    }
}
