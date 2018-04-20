<?php

namespace Course\Admin;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

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



    /**
     * Render admin settings.
     */
    public function displaySettingsAdmin()
    {
        $this->checkIfAdmin();
        $this->display("Admin", "admin/admin");
    }



    /**
     * Render admin products.
     */
    public function displayProductsAdmin()
    {
        $this->checkIfAdmin();

        $res = $this->pagination("getAllProducts", "getAllProducts", "admin", "/products?page=1");

        $data = [
            "products" => $res[0],
            "amountOfProducts" => $res[1]
        ];

        $this->display("Admin Produkter", "admin/products", $data);
    }



    /**
     * Render admin users.
     */
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



    /**
     * Render products with low amount.
     */
    public function displayLowAdmin()
    {
        $this->checkIfAdmin();

        $res = $this->pagination("getProductsWithLowAmount", "getProductsWithLowAmount", "admin", "/low?page=1");

        $data = [
            "products" => $res[0],
            "amountOfProducts" => $res[1]
        ];

        $this->display("Admin Lågt antal", "admin/low", $data);
    }



    /**
     * Render admin orders.
     */
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



    /**
     * Render admin single order.
     */
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
                $res = array_merge_recursive((array) $productItem, (array) $value);
                $products[] = $res;
            }

            $data = [
                "userInfo" => $userInfo,
                "orderItems" => $products,
            ];

            $this->display("Admin Order", "admin/order", $data);
        }
        
        $url = $this->di->get("url");
        $response = $this->di->get("response");
        $login = $url->create("admin/orders");
        $response->redirect($login);
        return false;
    }



    /**
     * Render admin buy product female.
     */
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



    /**
     * Render admin buy product male.
     */
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



    /**
     * Render admin edit product.
     */
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



    /**
     * Checks if user is admin.
     * @method checkIfAdmin()
     * @return mixed
     */
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

        if ($user->getPermission($email) == 1) {
            return true;
        }

        $response->redirect($login);
        return false;
    }



    /**
     * This function will render page.
     * @method display()
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



    /**
     * This function will return all orderIDs.
     * @method getOrderNumbers()
     * @param  array $orders all orders in database.
     * @return array array with all orderiDs.
     */
    private function getOrderNumbers($orders)
    {
        $orderNumbers = [];
        foreach ((array) $orders as $order) {
            array_push($orderNumbers, $order->orderID);
        }
        return $orderNumbers;
    }


    /**
     * This function will return products based on offset and how many productes there are in the database.
     * @method pagination()
     * @param  string     $f1   name of the first function that will use offset
     * @param  string     $f2   name of the second function with no offset
     * @param  string     $url  first part of url
     * @param  string     $path path to resource
     * @return mixed
     */
    private function pagination($f1, $f2, $url, $path = "")
    {
        $product = new Product();
        $product->setDb($this->di->get("db"));
        $amountOfProducts = count($product->$f1());


        $request = $this->di->get("request");

        $amountPerPage = 50;
        $res = null;

        $currentPage = $request->getGet("page");

        if ($currentPage == '0') {
            $redirect = $this->di->get("url")->create($url);
            $this->di->get("response")->redirect("$redirect" . "$path");
            return false;
        }

        if ($request->getGet("page")) {
            $pageMinCheck = $request->getGet(htmlentities("page")) > 0;
            $max = (floor($amountOfProducts / $amountPerPage) == 0 ? 1 : floor($amountOfProducts / $amountPerPage));
            $pageMaxCheck = $request->getGet(htmlentities("page")) <= $max;

            if ($pageMinCheck && $pageMaxCheck && $currentPage > 0) {
                $calcOffset = $request->getGet(htmlentities("page")) * $amountPerPage;
                $offset = $request->getGet(htmlentities("page")) == 1 ? 0 : $calcOffset;
                $res = $product->$f1($offset);
                return [$res, $amountOfProducts];
            }

            $redirect = $this->di->get("url")->create($url);
            $this->di->get("response")->redirect("$redirect" . "$path");
            return false;
        }

        $res = $product->$f2();
        return [$res, $amountOfProducts];
    }
}
