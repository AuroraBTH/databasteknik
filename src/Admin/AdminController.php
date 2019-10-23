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
        $this->di->get("render")->display("Admin", "admin/admin");
    }



    /**
     * Render admin products.
     */
    public function displayProductsAdmin()
    {
        $this->checkIfAdmin();

        $request = $this->di->get("request");

        $amountPerPage = 50;
        $calcOffset = $request->getGet(htmlentities("page")) * $amountPerPage;
        $offset = $request->getGet(htmlentities("page")) == 1 ? 0 : $calcOffset;

        $res = $this->di->get("pagination")->pagination([],
            "getAllProducts", "getAllProducts", [$offset], "admin", "/products?page=1");

        $data = [
            "products" => $res[0],
            "amountOfProducts" => $res[1]
        ];

        $this->di->get("render")->display("Admin | Produkter", "admin/products", $data);
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

        $this->di->get("render")->display("Admin | Användare", "admin/users", $data);
    }



    /**
     * Render products with low amount.
     */
    public function displayLowAdmin()
    {
        $this->checkIfAdmin();

        $request = $this->di->get("request");

        $amountPerPage = 50;
        $calcOffset = $request->getGet(htmlentities("page")) * $amountPerPage;
        $offset = $request->getGet(htmlentities("page")) == 1 ? 0 : $calcOffset;

        $res = $this->di->get("pagination")->pagination([],
            "getProductsWithLowAmount", "getProductsWithLowAmount", [$offset], "admin", "/low?page=1");

        $data = [
            "products" => $res[0],
            "amountOfProducts" => $res[1]
        ];

        $this->di->get("render")->display("Admin | Lågt antal", "admin/low", $data);
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

        $this->di->get("render")->display("Admin | Ordrar", "admin/orders", $data);
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
            
            $coupon = null;

            if ($order->couponID !== null) {
                $coupon = new Coupon();
                $coupon->setDb($this->di->get("db"));
                $coupon->getCoupon($order->couponID);
            }

            $shippingAndWeight = $this->di->get("calc")->calcShipping($products, "productAmount");

            $data = [
                "userInfo" => $userInfo,
                "coupon" => $coupon,
                "orderItems" => $products,
                "price" => $order->getOrderByID($orderID)->price,
                "shipping" => $shippingAndWeight[0],
                "weight" => $shippingAndWeight[1],
                "amountOfItems" => $this->di->get("calc")->calcAmount($products, "productAmount"),
            ];

            $this->di->get("render")->display("Admin | Order", "admin/order", $data);
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

        $this->di->get("render")->display("Admin | Köp Product", "default1/article", $data);
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

        $this->di->get("render")->display("Admin | Köp Product", "default1/article", $data);
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


        $this->di->get("render")->display("Admin | Köp Product", "default1/article", $data);
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


        $this->di->get("render")->display("Admin | Lägg till kupong", "default1/article", $data);
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
}
