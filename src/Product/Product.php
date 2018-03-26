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



    public function getAllProducts()
    {
        return $this->findAll();
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
        $query = $key . " = ? and productGender = ?";
        return $this->findAllWhere($query, [$value, $gender]);
    }



    public function getProductByID($productID){
        $res = $this->find("productID", $productID);
        return $res;
    }


    public function getProductsUnder500($gender, $limit) {
        if ($limit === null) {
            $sql = "SELECT * FROM Product WHERE productSellPrize <= 500 and productGender = ?";
            $res = $this->findAllSql($sql, [$gender]);
        } elseif ($limit !== null) {
            $sql = "SELECT * FROM Product WHERE productSellPrize <= 500 and productGender = ? LIMIT ?";
            $res = $this->findAllSql($sql, [$gender, $limit]);
        }
        return $res;
    }



    public function getProductsWithLowAmount()
    {
        $res = $this->findAllWhere("productAmount <= ?", 5);
        return $res;
    }



    public function searchProducts($searchString) {
        $param = "[[:<:]]{$searchString}[[:>:]]";
        $sql = "SELECT * FROM Product WHERE productName REGEXP ?";
        $res = $this->findAllSql($sql, [$param]);
        return $res;
    }
}
