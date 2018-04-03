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
        $title = "Produkt";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $product = new Product();
        $product->setDb($this->di->get("db"));
        $data = $product->getProducts("productID", $productId);

        if (!$data) {
            $redirect = $this->di->get("url")->create("");
            $this->di->get("response")->redirect($redirect);
            return false;
        }

        $view->add("product/product", $data);
        $pageRender->renderPage(["title" => $title]);
        return true;
    }



    public function getAllProductsFromCategory($categoryID, $genderID)
    {
        $title = "Produkter";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $products = new Product();
        $products->setDb($this->di->get("db"));

        $category = new Category();
        $category->setDb($this->di->get("db"));
        $productCategory = $category->getSpecificCategory($categoryID);

        $data = [
            "products" => $products->getProductsByGender("productCategoryID", $categoryID, $genderID),
            "categoryParent" => $productCategory
        ];

        $view->add("product/products", $data);
        $pageRender->renderPage(["title" => $title]);
    }



    public function getAllProductsUnder500()
    {
        $title = "Produkter under 500kr";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $products = new Product();
        $products->setDb($this->di->get("db"));

        $data = [
            "under500Female" => $products->getProductsUnder500(0, null),
            "under500Male" => $products->getProductsUnder500(1, null)
        ];

        $view->add("product/under500", $data);
        $pageRender->renderPage(["title" => $title]);
    }
}
