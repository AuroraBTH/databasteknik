<?php

namespace Course\Product;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\Di\InjectionAwareTrait;
use \Course\Product\Product;

class ProductController implements
    ConfigureInterface,
    InjectionAwareInterface
{
    use ConfigureTrait,
    InjectionAwareTrait;

    /**
     * This function handles the rendering of one specific categories.
     */
    public function getSpecificProduct($productId)
    {
        $title = "Produkt";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $product = new Product();
        $product->setDb($this->di->get("db"));
        $data = $product->getProducts("productID", $productId);

        $view->add("product/product", $data);
        $pageRender->renderPage(["title" => $title]);
    }
}
