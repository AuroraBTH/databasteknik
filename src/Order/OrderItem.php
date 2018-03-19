<?php

namespace Course\Order;

use \Anax\Database\ActiveRecordModel;

class OrderItem extends ActiveRecordModel {
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "OrderItem";

    // protected $tableIdColumn = "orderID";

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



    public function setOrderID($orderID)
    {
        $this->orderID = $orderID;
    }



    public function setProductID($productID)
    {
        $this->productID = $productID;
    }



    public function setProductAmount($amount)
    {
        $this->productAmount = $amount;
    }



    public function getAllOrderItems()
    {
        $sql = "SELECT productID, SUM(productAmount) AS Amount
        FROM OrderItem GROUP BY productID
        ORDER BY SUM(productAmount) DESC";
        $res = $this->findAllSql($sql);
        return $res;
    }



    public function getAllItemsWhereID($orderID)
    {
        return $this->findallwhere("orderID = ?", $orderID);
    }

}
