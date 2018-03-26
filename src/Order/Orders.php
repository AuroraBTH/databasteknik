<?php

namespace Course\Order;

use \Anax\Database\ActiveRecordModel;

class Orders extends ActiveRecordModel {
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Orders";

    protected $tableIdColumn = "orderID";

    /**
     * Columns in the table.
     *
     * @var integer $productID primary key auto incremented.
     * @var string $productManufacturer not null.
     * @var string $productName not null.
     */

    public $userID;
    public $couponID;



    public function setUserID($userID)
    {
        $this->userID = $userID;
    }



    public function setCouponID($couponID)
    {
        $this->couponID = $couponID;
    }



    public function getOrderID($userID)
    {
        $orderID = $this->find("userID", $userID);
        return $orderID;
    }



    public function getLastInsertedID()
    {
        $orderID = $this->lastInsertId();
        return $orderID;
    }



    public function getOrderByID($orderID)
    {
        return $this->find("orderID", $orderID);
    }



    public function getAllOrderByUserID($userID)
    {
        return $this->findallwhere("userID = ?", $userID);
    }



    public function getAllOrders()
    {
        return $this->findAll();
    }
}
