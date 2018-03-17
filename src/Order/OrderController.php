<?php

namespace Course\Order;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\Di\InjectionAwareTrait;

use \Course\Order\Orders;
use \Course\Order\OrderItems;

use \Course\User\User;

use \Course\Product\Product;

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


        public function getOrderPage()
        {
            $title = "Order";
            $view = $this->di->get("view");
            $pageRender = $this->di->get("pageRender");
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

            $view->add("order/orders", $data);
            $pageRender->renderPage(["title" => $title]);
        }



        public function getSingleOrder($orderID)
        {
            $title = "Order";
            $view = $this->di->get("view");
            $pageRender = $this->di->get("pageRender");
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
                    $res = array_merge_recursive((array)$productItem, (array)$value);
                    $products[] = $res;
                }


                $data = [
                    "userInfo" => $userInformation,
                    "orderItems" => $products,
                ];


                $view->add("order/order", $data);
                $pageRender->renderPage(["title" => $title]);
            } elseif (!in_array($orderID, $orderNumbers)) {
                $url = $this->di->get("url");
                $response = $this->di->get("response");
                $login = $url->create("orders");
                $response->redirect($login);
                return false;
            }
        }



        public function checkLoggedIn()
        {
            $url = $this->di->get("url");
            $response = $this->di->get("response");
            $session = $this->di->get("session");
            $login = $url->create("user/login");

            if ($session->has("email")) {
                return true;
            } else if (!$session->has("email")) {
                $response->redirect($login);
                return false;
            }
        }


        public function getOrderNumbers($orders)
        {
            $orderNumbers = [];
            foreach ((array)$orders as $order) {
                array_push($orderNumbers, $order->orderID);
            }
            return $orderNumbers;
        }
}
