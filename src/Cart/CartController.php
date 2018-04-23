<?php

namespace Course\Cart;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

use \Course\Order\OrderItem;
use \Course\Order\Orders;
use \Course\Product\Product;
use \Course\User\User;
use \Course\Coupon\Coupon;

class CartController implements
    ConfigureInterface,
    InjectionAwareInterface
{
    use ConfigureTrait,
    InjectionAwareTrait;



    /**
     * Rendering of cart.
     * @method displayCart()
     * @return void
     */
    public function displayCart() {
        #Get current session.
        $session = $this->di->get("session");

        $items = $session->get("items");

        $data = [
            "cartItems" => $items,
            "price" => $this->di->get("calc")->calcPrice($items)
        ];

        $this->di->get("render")->display("Kassa", "cart/cart", $data);
    }



    /**
     * Rendering of checkout
     * @method displayCheckout()
     * @return void
     */
    public function displayCheckout() {
        #Get current session.
        $session = $this->di->get("session");
        $session->set("order", true);
        $session->set("orderID", null);

        $items = $session->get("items");

        $shippingAndWeight = $this->di->get("calc")->calcShipping($items);

        $data = [
            "cartItems" => $items,
            "price" => $this->di->get("calc")->calcPrice($items),
            "shipping" => $shippingAndWeight[0],
            "weight" => $shippingAndWeight[1],
            "amountOfItems" => $this->di->get("calc")->calcAmount($items),
        ];

        $this->di->get("render")->display("Kassa", "cart/checkout", $data);
    }



    /**
     * Rendering of order
     * @method displayOrder()
     * @return void
     */
    public function displayOrder() {
        $db = $this->di->get("db");

        $session = $this->di->get("session");

        $user = new User();
        $user->setDb($db);
        $user->getUserInformationByEmail($session->get("email"));
        $couponData = null;
        $discount = null;

        $items = $session->get("items");

        $shippingAndWeight = $this->di->get("calc")->calcShipping($items);
        $price = $this->di->get("calc")->calcPrice($items);

        if ($session->get("order") == true) {
            if ($this->di->get("request")->getPost("coupon") != null) {
                $coupon = new Coupon();
                $code = $this->di->get("request")->getPost("coupon", null);
                $coupon->setDb($db);
                $couponData = $coupon->validateCoupon($code);

                $discount = isset($couponData) ? 1 - ($couponData->couponAmount / 100) : null;
            }

            $order = new Orders();
            $order->setDb($db);
            $order->setUserID($user->userID);
            $order->setPrice(($shippingAndWeight[0] + $price) * (isset($couponData) ? $discount : 1));

            if (isset($couponData)) {
                $order->setCouponID($couponData->couponID);
            }

            $order->save();

            $orderID = $order->getLastInsertedID();
            $session->set("orderID", $orderID);

            foreach ((array) $session->get("items") as $value) {
                $this->removeFromTotal($db, $value['productID'], $value["amount"]);

                $this->createOrderItem($db, $orderID, $value["productID"], $value["amount"]);
            }

            $this->di->get("session")->set("order", false);
        }

        $data = [
            "userInfo" => $user,
            "orderID" => $session->get("orderID"),
            "coupon" => $couponData,
            "cartItems" => $items,
            "price" => $price,
            "shipping" => $shippingAndWeight[0],
            "weight" => $shippingAndWeight[1],
            "amountOfItems" => $this->di->get("calc")->calcAmount($items),
            "discount" => $discount,
        ];

        $session->delete("items");
        $session->delete("orderID");

        $this->di->get("render")->display("Beställning lagd", "cart/order", $data);
    }


    private function removeFromTotal($db, $productID, $amount)
    {
        $product = new Product();
        $product->setDb($db);
        $product->getProductByID($productID);
        $product->productAmount = ($product->productAmount - (int) $amount);
        $product->save();
    }



    private function createOrderItem($db, $orderID, $productID, $amount)
    {
        $orderItem = new OrderItem();
        $orderItem->setDb($db);
        $orderItem->setOrderID((int) $orderID);
        $orderItem->setProductID((int) $productID);
        $orderItem->setProductAmount((int) $amount);
        $orderItem->save();
    }
}
