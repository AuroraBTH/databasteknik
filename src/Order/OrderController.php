<?php

namespace Course\Order;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

use \Course\Order\Orders;
use \Course\Order\OrderItem;

use \Course\User\User;

use \Course\Product\Product;

use \Course\Coupon\Coupon;

/**
 * A controller class.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class OrderController implements
    ConfigureInterface,
    InjectionAwareInterface
{
    use ConfigureTrait,
        InjectionAwareTrait;



    /**
     * Rendering of orders
     * @method getOrderPage()
     * @return void
     */
    public function getOrderPage()
    {
        $session = $this->di->get("session");

        $this->checkLoggedIn();

        $user = new User();
        $user->setDb($this->di->get("db"));
        $userInformation = $user->getUserInformationByEmail($session->get("email"));

        $order = new Orders();
        $order->setDb($this->di->get("db"));

        $data = [
            "orders" => $order->getAllOrderByUserID($userInformation->userID),
        ];

        $this->di->get("render")->display("Ordrar", "order/orders", $data);
    }



    /**
     * Rendering of single order
     * @method getSingleOrder()
     * @param  int         $orderID orderID
     * @return mixed
     */
    public function getSingleOrder($orderID)
    {
        $session = $this->di->get("session");

        $this->checkLoggedIn();

        $user = new User();
        $user->setDb($this->di->get("db"));
        $userInformation = $user->getUserInformationByEmail($session->get("email"));

        $order = new Orders();
        $order->setDb($this->di->get("db"));
        $orders = $order->getAllOrderByUserID($userInformation->userID);

        $orderNumbers = $this->getOrderNumbers($orders);

        if (in_array($orderID, $orderNumbers)) {
            $product = new Product();
            $product->setDb($this->di->get("db"));

            $orderItem = new OrderItem();
            $orderItem->setDb($this->di->get("db"));

            $items = $orderItem->getAllItemsWhereID($orderID);

            $products = [];

            foreach ($items as $value) {
                $productItem = $product->getProductByID($value->productID);
                $res = array_merge_recursive((array) $productItem, (array) $value);
                $products[] = $res;
            }

            $order->getOrderByID($orderID);
            $coupon = null;

            if ($order->couponID !== null) {
                $coupon = new Coupon();
                $coupon->setDb($this->di->get("db"));
                $coupon->getCoupon($order->couponID);
            }

            $shippingAndWeight = $this->di->get("calc")->calcShipping($products, "productAmount");

            $data = [
                "userInfo" => $userInformation,
                "coupon" => $coupon,
                "orderItems" => $products,
                "price" => $order->getOrderByID($orderID)->price,
                "shipping" => $shippingAndWeight[0],
                "weight" => $shippingAndWeight[1],
                "amountOfItems" => $this->di->get("calc")->calcAmount($products, "productAmount"),
            ];

            $this->di->get("render")->display("Order", "order/order", $data);
        }
        $url = $this->di->get("url");
        $response = $this->di->get("response");
        $login = $url->create("orders");
        $response->redirect($login);
        return false;
    }



    /**
     * Check if user is logged in.
     * @method checkLoggedIn()
     * @return mixed
     */
    public function checkLoggedIn()
    {
        $url = $this->di->get("url");
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $login = $url->create("user/login");

        if ($session->has("email")) {
            return true;
        }

        $response->redirect($login);
        return false;
    }



    /**
     * This function will return all orderIDs.
     * @method getOrderNumbers()
     * @param  array $orders all orders in database.
     * @return array array with all orderiDs.
     */
    public function getOrderNumbers($orders)
    {
        $orderNumbers = [];
        foreach ((array) $orders as $order) {
            array_push($orderNumbers, $order->orderID);
        }
        return $orderNumbers;
    }
}
