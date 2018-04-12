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
     * Rendering of specific product.
     * @method getSpecificProduct
     * @param  int $productId ID of product.
     * @return mixed
     */
    public function getSpecificProduct($productId)
    {
        $product = new Product();
        $product->setDb($this->di->get("db"));
        $data = $product->getProducts("productID", $productId);

        if (empty($data)) {
            $redirect = $this->di->get("url")->create("");
            $this->di->get("response")->redirect($redirect);
            return false;
        }

        $this->display("Produkt", "product/product", $data);
        return true;
    }



    /**
     * Rendering of all products in specific category.
     * @method getAllProductsFromCategory
     * @param  int  $categoryID category ID
     * @param  int  $genderID  0 = Female, 1 = Male.
     * @return void
     */
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



    /**
     * Rendering of all female products under 500kr
     * @method getAllProductsUnder500Female
     * @return void
     */
    public function getAllProductsUnder500Female()
    {
        $products = new Product();
        $products->setDb($this->di->get("db"));

        $data = [
            "under500Female" => $products->getProductsUnder500(0)
        ];

        $this->display("Produkter under 500kr", "product/under500Female", $data);
    }



    /**
     * Rendering of all male products under 500kr
     * @method getAllProductsUnder500Male
     * @return void
     */
    public function getAllProductsUnder500Male()
    {
        $products = new Product();
        $products->setDb($this->di->get("db"));

        $res = null;

        $amountOfProducts = count($products->getProductsUnder500(1));

        if (isset($_GET["page"])) {
            $offset = ($_GET["page"] * 20);
            $res = $products->getProductsUnder500(1, null, $offset);
        } elseif (!isset($_GET["offset"])) {
            $res = $products->getProductsUnder500(1);
        }


        $data = [
            "under500Male" => $res,
            "amountOfProducts" => $amountOfProducts
        ];

        $this->display("Produkter under 500kr", "product/under500Male", $data);
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
