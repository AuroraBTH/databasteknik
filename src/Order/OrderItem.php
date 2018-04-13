<?php

namespace Course\Order;

use \Anax\Database\ActiveRecordModel;

class OrderItem extends ActiveRecordModel {
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "OrderItem";

    /**
     * Columns in the table.
     *
     * @var integer $productID primary key auto incremented.
     * @var string $productManufacturer not null.
     * @var string $productName not null.
     */

    public $orderID;
    public $productID;
    public $productAmount;



    /**
     * Set orderID.
     * @method setOrderID()
     * @param  int $orderID ID of order.
     */
    public function setOrderID($orderID)
    {
        $this->orderID = $orderID;
    }



    /**
     * Set productID
     * @method setProductID()
     * @param  int $productID ID of product.
     */
    public function setProductID($productID)
    {
        $this->productID = $productID;
    }



    /**
     * Set amount of product.
     * @method setProductAmount()
     * @param int $amount amount of product.
     */
    public function setProductAmount($amount)
    {
        $this->productAmount = $amount;
    }



    /**
     * Get all orderItems.
     * @method getAllOrderItems()
     * @return array with all orderItems.
     */
    public function getAllOrderItems()
    {
        $sql = "SELECT productID, SUM(productAmount) AS Amount
        FROM OrderItem GROUP BY productID
        ORDER BY SUM(productAmount) DESC";
        $res = $this->findAllSql($sql);
        return $res;
    }



    /**
     * Get all orderItems from specific order.
     * @method getAllItemsWhereID()
     * @param  int $orderID ID of order
     * @return array with orderItems.
     */
    public function getAllItemsWhereID($orderID)
    {
        return $this->findAllWhere("orderID = ?", $orderID);
    }



    /**
     * Get most bought products.
     * @method getMostBoughtProducts()
     * @return array with most bought product.
     */
    public function getMostBoughtProducts()
    {
        $sql = "SELECT productID,
        SUM(productAmount) AS total
        FROM OrderItem
        GROUP BY productID
        ORDER BY SUM(productAmount)
        DESC LIMIT 10";
        $res = $this->findAllSql($sql);
        return $res;
    }
}
