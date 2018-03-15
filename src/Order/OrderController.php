<?php

namespace Course\Order;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\Di\InjectionAwareTrait;

use \Course\Order\Orders;
use \Course\Order\OrderItems;

use \Course\User\User;

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

            $user = new User();
            $user->setDb($this->di->get("db"));

            $orderItem = new OrderItem();
            $orderItem->setDb($this->di->get("db"));

            $data = [
                "orders" => $orderItem->getAllItemsWhereID($orderID),
            ];

            $view->add("order/order", $data);
            $pageRender->renderPage(["title" => $title]);
        }
}
