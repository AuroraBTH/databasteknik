<?php
namespace Course\Coupon;

use \Anax\Database\ActiveRecordModel;

class Coupon extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Coupon";
    protected $tableIdColumn = "couponID";

    /**
     * Columns in the table.
     *
     * @var integer $couponID primary key auto incremented.
     * @var string $couponName
     * @var integer $couponAmount
     * @var DateTime $startDate
     * @var DateTime $finishDate
     */

    public $couponID;
    public $couponName;
    public $couponAmount;
    public $startDate;
    public $finishDate;



    /**
     * Set coupon name.
     *
     * @param string $name for the coupon.
     *
     * @return void
     */
    public function setName($name)
    {
        $this->couponName = $name;
    }



    /**
     * Set coupon amount.
     *
     * @param integer $amount for the coupon.
     *
     * @return void
     */
    public function setAmount($amount)
    {
        $this->couponAmount = $amount;
    }



    /**
     * Set coupon start date.
     *
     * @param string $date for the start of the coupon.
     *
     * @return void
     */
    public function setStartDate($date)
    {
        $this->startDate = $date;
    }



    /**
     * Set coupon end date.
     *
     * @param string $date for the end of the coupon.
     *
     * @return void
     */
    public function setFinishDate($date)
    {
        $this->finishDate = $date;
    }



    /**
     * Get all information about a specific coupon by id.
     *
     * @param integer $id of coupon.
     *
     * @return \Anax\Database\ActiveRecordModel
     */
    public function getCoupon($id)
    {
        $information = $this->find("couponID", $id);
        return $information;
    }



    /**
     * Get all information about a specific coupon by name.
     *
     * @param string $name name of coupon.
     *
     * @return \Anax\Database\ActiveRecordModel
     */
    public function getCouponByName($name)
    {
        $information = $this->find("couponName", $name);
        return $information;
    }



    /**
     * Validate date.
     *
     * @param string $name of the coupon.
     *
     * @return mixed
     */
    public function validateCoupon($name)
    {
        $currentDate = new \DateTime();
        $currentDate = $currentDate->setTime(0, 0, 0);
        $coupon = $this->find("couponName", $name);

        if ($coupon instanceof Coupon) {
            if ($currentDate < new \DateTime("$coupon->startDate")
                || $currentDate > new \DateTime("$coupon->finishDate")) {
                return null;
            }
            return $coupon;
        }

        return null;
    }
}
