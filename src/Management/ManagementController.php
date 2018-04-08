<?php

namespace Course\Management;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\Di\InjectionAwareTrait;

use \Course\User\User;
use \Course\Order\OrderItem;
use \Course\Product\Product;

class ManagementController implements
    ConfigureInterface,
    InjectionAwareInterface
{
    use ConfigureTrait,
    InjectionAwareTrait;



    public function displaySettingsManagement()
    {
        $this->checkIfManagement();
        $this->display("Management", "management/management");
    }



    public function displaySettingsMostBought()
    {
        $this->checkIfManagement();

        $orderItems = new OrderItem();
        $orderItems->setDb($this->di->get("db"));


        $product = new Product();
        $product->setDb($this->di->get("db"));

        $orderItem = new OrderItem();
        $orderItem->setDb($this->di->get("db"));

        $items = $orderItems->getMostBoughtProducts();

        $products = [];

        foreach ($items as $value) {
            $productItem = $product->getProductByID($value->productID);
            $res = array_merge_recursive((array)$productItem, (array)$value);
            $products[] = $res;
        }

        $data = [
            'products' => $products
        ];

        $this->display("Management Mest Köpta", "management/mostbought", $data);
    }



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

        if ($user->getPermission($email) == 2 ) {
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
}
