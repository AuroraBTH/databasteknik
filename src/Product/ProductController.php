<?php

namespace Course\Product;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\Di\InjectionAwareTrait;
use \Course\Product\Product;
use \Course\Category\Category;

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
        $product = new Product();
        $product->setDb($this->di->get("db"));
        $data = $product->getProducts("productID", $productId);

        if (!$data) {
            $redirect = $this->di->get("url")->create("");
            $this->di->get("response")->redirect($redirect);
            return false;
        }

        $this->display("Produkt", "product/product", $data);
        return true;
    }



    public function getAllProductsFromCategory($categoryID, $genderID)
    {
        $products = new Product();
        $products->setDb($this->di->get("db"));

        $category = new Category();
        $category->setDb($this->di->get("db"));
        $productCategory = $category->getSpecificCategory($categoryID);

        $data = [
            "products" => $products->getProductsByGender("productCategoryID", $categoryID, $genderID),
            "categoryParent" => $productCategory
        ];

        $this->display("Produkter", "product/products", $data);
    }



    public function getAllProductsUnder500()
    {
        $products = new Product();
        $products->setDb($this->di->get("db"));

        $data = [
            "under500Female" => $products->getProductsUnder500(0, null),
            "under500Male" => $products->getProductsUnder500(1, null)
        ];

        $this->display("Produkter under 500kr", "product/under500", $data);
    }



    private function display($title, $page, $data = []) {
        $title = $title;
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $view->add($page, $data);
        $pageRender->renderPage(["title" => $title]);
    }
}
