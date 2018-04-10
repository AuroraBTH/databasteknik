<?php

namespace Course\Cart;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\Di\InjectionAwareTrait;

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
     * @method displayCart
     * @return void
     */
    public function displayCart() {
        #Get current session.
        $session = $this->di->get("session");

        $data = [
            "cartItems" => $session->get("items"),
        ];

        $this->display("Kassa", "cart/cart", $data);
    }



    /**
     * Rendering of checkout
     * @method displayCheckout
     * @return void
     */
    public function displayCheckout() {
        #Get current session.
        $session = $this->di->get("session");
        $session->set("order", true);
        $session->set("orderID", null);

        $data = [
            "cartItems" => $session->get("items"),
        ];

        $this->display("Kassa", "cart/checkout", $data);
    }



    /**
     * Rendering of order
     * @method displayOrder
     * @return void
     */
    public function displayOrder() {
        $db = $this->di->get("db");

        $session = $this->di->get("session");

        $user = new User();
        $user->setDb($db);
        $user->getUserInformationByEmail($session->get("email"));

        if ($session->get("order") == true) {
            if ($this->di->get("request")->getPost("coupon") != null) {
                $coupon = new Coupon();
                $code = $this->di->get("request")->getPost("coupon", null);
                $coupon->setDb($db);
                $couponData = $coupon->validateCoupon($code);
            }

            $order = new Orders();
            $order->setDb($db);
            $order->setUserID($user->userID);

            if (isset($couponData)) {
                $order->setCouponID($couponData->couponID);
            }

            $order->save();

            $orderID = $order->getLastInsertedID();
            $session->set("orderID", $orderID);

            foreach ((array) $session->get("items") as $value) {
                $product = new Product();
                $product->setDb($db);
                $product->getProductByID($value['productID']);
                $product->productAmount = ($product->productAmount - (int) $value["amount"]);
                $product->save();

                $orderItem = new OrderItem();
                $orderItem->setDb($db);
                $orderItem->setOrderID((int) $orderID);
                $orderItem->setProductID((int) $value["productID"]);
                $orderItem->setProductAmount((int) $value["amount"]);
                $orderItem->save();
            }

            $this->di->get("session")->set("order", false);
        }

        $data = [
            "userInfo" => $user,
            "orderID" => $session->get("orderID"),
            "cartItems" => $session->get("items"),
        ];

        $session->delete("items");
        $session->delete("orderID");

        $this->display("Beställning lagd", "cart/order", $data);
    }



    /**
     * This function will render page.
     * @method display
     * @param  string $title title of page.
     * @param  string $page  page to render.
     * @param  array  $data  data to render.
     * @return void
     */
    private function display($title, $page, $data = []) {
        $title = $title;
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $view->add($page, $data);
        $pageRender->renderPage(["title" => $title]);
    }
}
