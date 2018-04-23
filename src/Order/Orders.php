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
     * @var integer $price
     */

    public $userID;
    public $couponID;
    public $price;



    /**
     * Set userID.
     * @method setUserID()
     * @param  int $userID ID of user
     */
    public function setUserID($userID)
    {
        $this->userID = $userID;
    }



    /**
     * Set couponID
     * @method setCouponID()
     * @param  int $couponID ID of coupon.
     */
    public function setCouponID($couponID)
    {
        $this->couponID = $couponID;
    }



    /**
     * Set price
     * @method setPrice
     * @param  integer   $price price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }



    /**
     * Get orderID.
     * @method getOrderID()
     * @param  int $userID ID of user
     * @return mixed with order.
     */
    public function getOrderID($userID)
    {
        $orderID = $this->find("userID", $userID);
        return $orderID;
    }



    /**
     * Get last inserted id.
     * @method getLastInsertedID()
     * @return int id of last insert.
     */
    public function getLastInsertedID()
    {
        $orderID = $this->lastInsertId();
        return $orderID;
    }



    /**
     * Get order by ID.
     * @method getOrderByID()
     * @param  int  $orderID ID of order.
     * @return mixed with specific order.
     */
    public function getOrderByID($orderID)
    {
        return $this->find("orderID", $orderID);
    }



    /**
     * Get all orders from specific user.
     * @method getAllOrderByUserID()
     * @param  int  $userID ID of user.
     * @return array with all orders from specific user.
     */
    public function getAllOrderByUserID($userID)
    {
        return $this->findAllWhere("userID = ?", $userID);
    }



    /**
     * Get all orders.
     * @method getAllOrders()
     * @return array with all orders in database.
     */
    public function getAllOrders()
    {
        return $this->findAll();
    }



    /**
     * Get all orders from 1 month.
     * @method getAllOrders1Month()
     * @return array with orders.
     */
    public function getAllOrders1Month()
    {
        $orders = $this->findAllWhere("purchaseTime >= ?", "(NOW() - INTERVAL 1 MONTH)");
        return $orders;
    }
}
