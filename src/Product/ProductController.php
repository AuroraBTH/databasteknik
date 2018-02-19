<?php

namespace Course\Product;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\Di\InjectionAwareTrait;
use \Course\Product\Product;

class productController implements
    ConfigureInterface,
    InjectionAwareInterface
{
    use ConfigureTrait,
    InjectionAwareTrait;

    /**
     * This function handles the rendering of one specific categories.
     */
    public function getSpecificProduct($id)
    {
        $title = "Kategori";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $data = [
            "id" => $id
        ];

        $view->add("product/product", $data);
        $pageRender->renderPage(["title" => $title]);
    }
}
