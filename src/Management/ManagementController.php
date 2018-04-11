<?php

namespace Course\Management;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\Di\InjectionAwareTrait;

use \Course\User\User;
use \Course\Order\OrderItem;
use \Course\Order\Orders;
use \Course\Product\Product;

class ManagementController implements
    ConfigureInterface,
    InjectionAwareInterface
{
    use ConfigureTrait,
    InjectionAwareTrait;



    /**
     * Rendering of management settings.
     * @method displaySettingsManagement
     * @return void
     */
    public function displaySettingsManagement()
    {
        $this->checkIfManagement();
        $this->display("Management", "management/management");
    }



    /**
     * Rendering of most bought products.
     * @method displaySettingsMostBought
     * @return void
     */
    public function displaySettingsMostBought()
    {
        $this->checkIfManagement();
        $db = $this->di->get("db");

        $orderItems = new OrderItem();
        $orderItems->setDb($db);


        $product = new Product();
        $product->setDb($db);

        $orderItem = new OrderItem();
        $orderItem->setDb($db);

        $items = $orderItems->getMostBoughtProducts();

        $products = [];

        foreach ($items as $value) {
            $productItem = $product->getProductByID($value->productID);
            $res = array_merge_recursive((array) $productItem, (array) $value);
            $products[] = $res;
        }

        $data = [
            'products' => $products
        ];

        $this->display("Management Mest Köpta", "management/mostbought", $data);
    }



    /**
     * Rendering of best selling products.
     * @method displaySettingsBestSelling
     * @return void
     */
    public function displaySettingsBestSelling()
    {
        $this->checkIfManagement();
        $db = $this->di->get("db");

        $order = new Orders();
        $order->setDb($db);

        $orders = $order->getAllOrders1Month();

        $orderItems = [];
        foreach ($orders as $order) {
            $orderItem = new OrderItem();
            $orderItem->setDb($db);

            $products = $orderItem->getAllItemsWhereID($order->orderID);
            foreach ($products as $key => $value) {
                if (array_key_exists($value->productID, $orderItems)) {
                    $productAmount = ((int) $orderItems[$value->productID]->productAmount + $value->productAmount);
                    $orderItems[$value->productID]->totalBought = $productAmount;
                } else if (!array_key_exists($value->productID, $orderItems)) {
                    $orderItems[$value->productID] = $value;
                    $orderItems[$value->productID]->totalBought = $value->productAmount;
                }
            }
        }

        $products = [];
        foreach ($orderItems as $key => $value) {
            $product = new Product();
            $product->setDb($db);
            $product->getProductByID($value->productID);

            $res = array_merge((array) $product, ["totalBought" => $value->totalBought]);
            $products[] = (object) $res;
        }

        foreach ($products as $key => $value) {
            $totalBought[$key] = $value->totalBought;
        }

        array_multisort($totalBought, SORT_DESC, $products);

        $data = [
            "products" => $products
        ];

        $this->display("Management Bästsäljande", "management/bestselling", $data);
    }



    /**
     * This function will check if user is management.
     * @method checkIfManagement
     * @return mixed
     */
    private function checkIfManagement()
    {
        $url = $this->di->get("url");
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $db = $this->di->get("db");
        $login = $url->create("user/login");

        $user = new User();
        $user->setDb($db);

        $email = $session->get("email");

        if ($user->getPermission($email) == 2) {
            return true;
        }

        $response->redirect($login);
        return false;
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
