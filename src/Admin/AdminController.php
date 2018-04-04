<?php

namespace Course\Admin;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\Di\InjectionAwareTrait;

use \Course\User\User;
use \Course\Product\Product;
use \Course\Order\Orders;
use \Course\Order\OrderItem;

use \Course\Admin\HTMLForm\AdminUpdateProductForm;
use \Course\Admin\HTMLForm\AdminBuyFemaleForm;
use \Course\Admin\HTMLForm\AdminBuyMaleForm;



class AdminController implements
    ConfigureInterface,
    InjectionAwareInterface
{
    use ConfigureTrait,
    InjectionAwareTrait;



    public function displaySettingsAdmin()
    {
        $this->checkIfAdmin();
        $title = "Admin";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $view->add("admin/admin");
        $pageRender->renderPage(["title" => $title]);
    }



    public function displayProductsAdmin()
    {
        $this->checkIfAdmin();
        $title = "Admin Produkter";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");


        $product = new Product();
        $product->setDb($this->di->get("db"));

        $data = [
            "products" => $product->getAllProducts()
        ];

        $view->add("admin/products", $data);
        $pageRender->renderPage(["title" => $title]);
    }



    public function displayUsersAdmin()
    {
        $this->checkIfAdmin();
        $title = "Admin Användare";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");


        $user = new User();
        $user->setDb($this->di->get("db"));

        $data = [
            "users" => $user->getAllUsers()
        ];

        $view->add("admin/users", $data);
        $pageRender->renderPage(["title" => $title]);
    }



    public function displayLowAdmin()
    {
        $this->checkIfAdmin();
        $title = "Admin Produkter";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $product = new Product();
        $product->setDb($this->di->get("db"));

        $data = [
            "products" => $product->getProductsWithLowAmount()
        ];

        $view->add("admin/low", $data);
        $pageRender->renderPage(["title" => $title]);
    }



    public function displayOrdersAdmin()
    {
        $this->checkIfAdmin();
        $title = "Admin Ordrar";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");


        $order = new Orders();
        $order->setDb($this->di->get("db"));

        $data = [
            "orders" => $order->getAllOrders(),
        ];

        $view->add("admin/orders", $data);
        $pageRender->renderPage(["title" => $title]);
    }



    public function displatSingleOrderAdmin($orderID)
    {
        $this->checkIfAdmin();
        $title = "Admin Ordrar";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $order = new Orders();
        $order->setDb($this->di->get("db"));
        $orders = $order->getAllOrders();

        $orderNumbers = $this->getOrderNumbers($orders);

        if (in_array($orderID, $orderNumbers)) {
            $product = new Product();
            $product->setDb($this->di->get("db"));

            $orderItem = new OrderItem();
            $orderItem->setDb($this->di->get("db"));

            $getOrder = $order->getOrderByID($orderID);

            $user = new User();
            $user->setDb($this->di->get("db"));
            $userInfo = $user->getUserInformationById($getOrder->userID);

            $items = $orderItem->getAllItemsWhereID($orderID);

            $products = [];

            foreach ($items as $value) {
                $productItem = $product->getProductByID($value->productID);
                $res = array_merge_recursive((array)$productItem, (array)$value);
                $products[] = $res;
            }

            $data = [
                "userInfo" => $userInfo,
                "orderItems" => $products,
            ];

            $view->add("admin/order", $data);
            $pageRender->renderPage(["title" => $title]);
        } elseif (!in_array($orderID, $orderNumbers)) {
            $url = $this->di->get("url");
            $response = $this->di->get("response");
            $login = $url->create("orders");
            $response->redirect($login);
            return false;
        }
    }



    public function displayBuyFemaleAdmin()
    {
        $this->checkIfAdmin();
        $title = "Admin Köp Produkt";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");


        $buyForm = new AdminBuyFemaleForm($this->di);

        $buyForm->check();

        $data = [
            "content" => $buyForm->getHTML(),
        ];

        $view->add("default1/article", $data);
        $pageRender->renderPage(["title" => $title]);
    }



    public function displayBuyMaleAdmin()
    {
        $this->checkIfAdmin();
        $title = "Admin Köp Produkt";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");


        $buyForm = new AdminBuyMaleForm($this->di);

        $buyForm->check();

        $data = [
            "content" => $buyForm->getHTML(),
        ];

        $view->add("default1/article", $data);
        $pageRender->renderPage(["title" => $title]);
    }



    public function displayEditAdmin($productID)
    {
        $this->checkIfAdmin();
        $title = "Admin Uppdatera Produkt";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");


        $updateForm = new AdminUpdateProductForm($this->di, $productID);

        $updateForm->check();

        $data = [
            "content" => $updateForm->getHTML(),
        ];

        $view->add("default1/article", $data);

        $pageRender->renderPage(["title" => $title]);
    }


    private function checkIfAdmin()
    {
        $url = $this->di->get("url");
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $db = $this->di->get("db");
        $login = $url->create("user/login");

        $user = new User();
        $user->setDb($db);

        $email = $session->get("email");

        if ($user->getPermission($email) == 1 || $user->getPermission($email) == 2 ) {
            return true;
        }

        $response->redirect($login);
        return false;
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
