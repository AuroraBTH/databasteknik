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



    /**
     * Set product manufacturer.
     * @method setProductManufacturer
     * @param  string $productManufacturer name of manufacturer
     */
    public function setProductManufacturer($productManufacturer)
    {
        $this->productManufacturer = $productManufacturer;
    }



    /**
     * Set product name
     * @method setProductName
     * @param  string $productName name of product.
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;
    }



    /**
     * Set product country
     * @method setProductCountry
     * @param  string $productOriginCountry name of origin country.
     */
    public function setProductCountry($productOriginCountry)
    {
        $this->productOriginCountry = $productOriginCountry;
    }



    /**
     * Set product weight.
     * @method setProductWeight
     * @param int $productWeight weight in grams.
     */
    public function setProductWeight($productWeight)
    {
        $this->productWeight = $productWeight;
    }



    /**
     * Set product size
     * @method setProductSize
     * @param  string $productSize product size
     */
    public function setProductSize($productSize)
    {
        $this->productSize = $productSize;
    }



    /**
     * Set product selling prize.
     * @method setProductSellPrize
     * @param  int $productSellPrize selling prize
     */
    public function setProductSellPrize($productSellPrize)
    {
        $this->productSellPrize = $productSellPrize;
    }



    /**
     * Set product buying prize.
     * @method setProductBuyPrize
     * @param  int $productBuyPrize buying prize
     */
    public function setProductBuyPrize($productBuyPrize)
    {
        $this->productBuyPrize = $productBuyPrize;
    }



    /**
     * Set product color.
     * @method setProductColor
     * @param  string $productColor color of product.
     */
    public function setProductColor($productColor)
    {
        $this->productColor = $productColor;
    }



    /**
     * Set product amount
     * @method setProductAmount
     * @param  int  $productAmount amount of products.
     */
    public function setProductAmount($productAmount)
    {
        $this->productAmount = $productAmount;
    }



    /**
     * Set product category
     * @method setProductCategoryID
     * @param  int $productCategoryID product category.
     */
    public function setProductCategoryID($productCategoryID)
    {
        $this->productCategoryID = $productCategoryID;
    }



    /**
     * Set product gender.
     * @method setProductGender
     * @param  int $productGender 0 = Female, 1 = Male
     */
    public function setProductGender($productGender)
    {
        $this->productGender = $productGender;
    }



    /**
     * Set product deleted.
     * @method setProductDeleted
     * @param  string  $deleted true or false.
     */
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



    /**
     * Get all products.
     * @method getAllProducts
     * @return array all products from database.
     */
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



    /**
     * Get product by id.
     * @method getProductByID
     * @param  int $productID ID of product.
     * @return array with one product.
     */
    public function getProductByID($productID){
        $res = $this->findwhere("productID = ? and productDeleted = ?", [$productID, "false"]);
        return $res;
    }


    /**
     * Get all products under 500kr.
     * @method getProductsUnder500
     * @param  int $gender 0 = Female, 1 = Male.
     * @param  mixed $limit amount of product.
     * @return array with products under 500kr.
     */
    public function getProductsUnder500($gender, $limit) {
        $res = null;
        
        if (!is_int($limit)) {
            $sql = "SELECT * FROM Product WHERE productSellPrize <= 500
            and productGender = ? and productDeleted = ?";
            $res = $this->findAllSql($sql, [$gender, "false"]);
        } elseif (is_int($limit)) {
            $sql = "SELECT * FROM Product WHERE productSellPrize <= 500
            and productGender = ? and productDeleted = ? LIMIT ?";
            $res = $this->findAllSql($sql, [$gender, "false", $limit]);
        }
        return $res;
    }



    /**
     * Get all products with low amount in database.
     * @method getProductsWithLowAmount
     * @return array with all products with low amount.
     */
    public function getProductsWithLowAmount()
    {
        $res = $this->findAllWhere("productAmount <= ? and productDeleted = ?", [5, "false"]);
        return $res;
    }



    /**
     * Search for products in database.
     * @method searchProducts
     * @param  string  $searchString searchstring
     * @return array with products.
     */
    public function searchProducts($searchString) {
        $searchString = htmlentities($searchString);
        $sql = "SELECT * FROM Product WHERE productName like ? and productDeleted = ?";
        $res = $this->findAllSql($sql, ["%$searchString%","false"]);
        return $res;
    }
}
