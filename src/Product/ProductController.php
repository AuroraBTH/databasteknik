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

        $res = null;

        $amountOfProducts = count((array) $products->getProductsByGender("productCategoryID", $categoryID, $genderID));

        $amountPerPage = 50;
        
        if (isset($_GET["page"])) {
            if ($_GET["page"] > 0 && $_GET["page"] <= round($amountOfProducts / $amountPerPage)) {
                $offset = $_GET["page"] == 1 ? 0 : ($_GET["page"] * $amountPerPage);
                $res = $products->getProductsByGender("productCategoryID", $categoryID, $genderID, $offset);
            } elseif ($_GET["page"] < 1 || $_GET["page"] > round($amountOfProducts / $amountPerPage)) {
                $redirect = $this->di->get("url")->create("");
                $this->di->get("response")->redirect($redirect);
                return false;
            }
        } elseif (!isset($_GET["page"])) {
            $res = $products->getProductsByGender("productCategoryID", $categoryID, $genderID);
        }

        $data = [
            "products" => $res,
            "categoryParent" => $productCategory,
            "amountOfProducts" => $amountOfProducts
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

        $res = null;

        $amountOfProducts = count($products->getProductsUnder500(0));

        $amountPerPage = 50;

        if (isset($_GET["page"])) {
            if ($_GET["page"] > 0 && $_GET["page"] <= round($amountOfProducts / $amountPerPage)) {
                $offset = $_GET["page"] == 1 ? 0 : ($_GET["page"] * $amountPerPage);
                $res = $products->getProductsUnder500(0, null, $offset);
            } elseif ($_GET["page"] < 1 || $_GET["page"] > round($amountOfProducts / $amountPerPage)) {
                $redirect = $this->di->get("url")->create("products");
                $this->di->get("response")->redirect("$redirect/under500Female?page=1");
                return false;
            }
        } elseif (!isset($_GET["page"])) {
            $res = $products->getProductsUnder500(0);
        }


        $data = [
            "under500Female" => $res,
            "amountOfProducts" => $amountOfProducts
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

        $amountPerPage = 50;

        if (isset($_GET["page"])) {
            if ($_GET["page"] > 0 && $_GET["page"] <= round($amountOfProducts / $amountPerPage)) {
                $offset = $_GET["page"] == 1 ? 0 : ($_GET["page"] * $amountPerPage);
                $res = $products->getProductsUnder500(1, null, $offset);
            } elseif ($_GET["page"] < 1 || $_GET["page"] > round($amountOfProducts / $amountPerPage)) {
                $redirect = $this->di->get("url")->create("products");
                $this->di->get("response")->redirect("$redirect/under500Male?page=1");
                return false;
            }
        } elseif (!isset($_GET["page"])) {
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
