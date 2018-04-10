<?php

namespace Course\Base;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\Di\InjectionAwareTrait;
use \Course\Base\Base;

use \Course\Order\OrderItem;
use \Course\Product\Product;
use \Course\Category\Category;

class BaseController implements
    ConfigureInterface,
    InjectionAwareInterface
{
    use ConfigureTrait,
    InjectionAwareTrait;


    /**
     * This function handles the rendering of frontpage.
     */
    public function frontpage()
    {
        $title = "Frontpage";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $db = $this->di->get("db");

        $orderItem = new OrderItem;
        $orderItem->setDb($db);
        $orderItems = $orderItem->getAllOrderItems();

        $product = new Product;
        $product->setDb($db);

        $maleTop10 = [];
        $femaleTop10 = [];

        foreach ($orderItems as $item) {
            $product->getProductByID($item->productID);
            if ($product->productGender == 0 && count($femaleTop10) < 10 && $product->productID !== null) {
                $femaleTop10[] = (array) $product;
            } else if ($product->productGender == 1 && count($maleTop10) < 10 && $product->productID !== null) {
                $maleTop10[] = (array) $product;
            }
        }

        $data = [
            "femaleTop10" => $femaleTop10,
            "maleTop10" => $maleTop10
        ];

        $under500 = [
            "productsUnder500Female" => $product->getProductsUnder500(0, 10),
            "productsUnder500Male" => $product->getProductsUnder500(1, 10),
        ];


        $view->add("base/home", [$data, $under500]);
        $pageRender->renderPage(["title" => $title]);
    }
}
