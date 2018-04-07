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
use \Course\Coupon\Coupon;

use \Course\Admin\HTMLForm\AdminUpdateProductForm;
use \Course\Admin\HTMLForm\AdminBuyFemaleForm;
use \Course\Admin\HTMLForm\AdminBuyMaleForm;
use \Course\Admin\HTMLForm\CouponCreateForm;



class AdminController implements
    ConfigureInterface,
    InjectionAwareInterface
{
    use ConfigureTrait,
    InjectionAwareTrait;



    public function displaySettingsAdmin()
    {
        $this->checkIfAdmin();
        $this->display("Admin", "admin/admin");
    }



    public function displayProductsAdmin()
    {
        $this->checkIfAdmin();
        $product = new Product();
        $product->setDb($this->di->get("db"));

        $data = [
            "products" => $product->getAllProducts()
        ];

        $this->display("Admin Produkter", "admin/products", $data);
    }



    public function displayUsersAdmin()
    {
        $this->checkIfAdmin();
        $user = new User();
        $user->setDb($this->di->get("db"));

        $data = [
            "users" => $user->getAllUsers()
        ];

        $this->display("Admin Användare", "admin/users", $data);
    }



    public function displayLowAdmin()
    {
        $this->checkIfAdmin();
        $product = new Product();
        $product->setDb($this->di->get("db"));

        $data = [
            "products" => $product->getProductsWithLowAmount()
        ];

        $this->display("Admin Lågt antal", "admin/low", $data);
    }



    public function displayOrdersAdmin()
    {
        $this->checkIfAdmin();
        $order = new Orders();
        $order->setDb($this->di->get("db"));

        $data = [
            "orders" => $order->getAllOrders(),
        ];

        $this->display("Admin Ordrar", "admin/orders", $data);
    }



    public function displatSingleOrderAdmin($orderID)
    {
        $this->checkIfAdmin();
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

            $this->display("Admin Order", "admin/order", $data);
        } elseif (!in_array($orderID, $orderNumbers)) {
            $url = $this->di->get("url");
            $response = $this->di->get("response");
            $login = $url->create("admin/orders");
            $response->redirect($login);
            return false;
        }
    }



    public function displayBuyFemaleAdmin()
    {
        $this->checkIfAdmin();
        $buyForm = new AdminBuyFemaleForm($this->di);

        $buyForm->check();

        $data = [
            "content" => $buyForm->getHTML(),
        ];

        $this->display("Admin Köp Product", "default1/article", $data);
    }



    public function displayBuyMaleAdmin()
    {
        $this->checkIfAdmin();
        $buyForm = new AdminBuyMaleForm($this->di);

        $buyForm->check();

        $data = [
            "content" => $buyForm->getHTML(),
        ];

        $this->display("Admin Köp Product", "default1/article", $data);
    }



    public function displayEditAdmin($productID)
    {
        $this->checkIfAdmin();
        $updateForm = new AdminUpdateProductForm($this->di, $productID);

        $updateForm->check();

        $data = [
            "content" => $updateForm->getHTML(),
        ];


        $this->display("Admin Köp Product", "default1/article", $data);
    }


    /**
    * Page for adding new coupons.
    *
    * @return void
    */
    public function displayAddCoupon()
    {
        $this->checkIfAdmin();
        $form = new CouponCreateForm($this->di);

        $form->check();

        $data = [
            "content" => $form->getHTML(),
        ];


        $this->display("Admin | Lägg till kupong", "default1/article", $data);
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



    private function display($title, $page, $data = []) {
        $title = $title;
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $view->add($page, $data);
        $pageRender->renderPage(["title" => $title]);
    }



    private function getOrderNumbers($orders)
    {
        $orderNumbers = [];
        foreach ((array)$orders as $order) {
            array_push($orderNumbers, $order->orderID);
        }
        return $orderNumbers;
    }
}
