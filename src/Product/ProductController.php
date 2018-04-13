<?php

namespace Course\Product;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;
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
     * @method getSpecificProduct()
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
     * @method getAllProductsFromCategory()
     * @param  int  $categoryID category ID
     * @param  int  $genderID  0 = Female, 1 = Male.
     * @return mixed
     */
    public function getAllProductsFromCategory($categoryID, $genderID)
    {
        $category = new Category();
        $category->setDb($this->di->get("db"));
        $productCategory = $category->getSpecificCategory($categoryID);

        $request = $this->di->get("request");

        $amountPerPage = 50;

        $calcOffset = $request->getGet(htmlentities("page")) * $amountPerPage;
        $offset = $request->getGet(htmlentities("page")) == 1 ? 0 : $calcOffset;

        $res = $this->pagination(["productCategoryID", $categoryID, $genderID],
            "getProductsByGender", "getProductsByGender", ["productCategoryID", $categoryID, $genderID, $offset], "");

        $data = [
            "products" => $res[0],
            "amountOfProducts" => $res[1],
            "categoryParent" => $productCategory,
        ];

        $this->display("Produkter", "product/products", $data);
    }



    /**
     * Rendering of all female products under 500kr
     * @method getAllProductsUnder500Female()
     * @return mixed
     */
    public function getAllProductsUnder500Female()
    {
        $products = new Product();
        $products->setDb($this->di->get("db"));

        $request = $this->di->get("request");

        $amountPerPage = 50;
        $calcOffset = $request->getGet(htmlentities("page")) * $amountPerPage;
        $offset = $request->getGet(htmlentities("page")) == 1 ? 0 : $calcOffset;

        $res = $this->pagination([0], "getProductsUnder500", "getProductsUnder500",
            [0, null, $offset], "products", "/under500Female?page=1");

        $data = [
            "under500Female" => $res[0],
            "amountOfProducts" => $res[1]
        ];

        $this->display("Produkter under 500kr", "product/under500Female", $data);
    }



    /**
     * Rendering of all male products under 500kr
     * @method getAllProductsUnder500Male()
     * @return mixed
     */
    public function getAllProductsUnder500Male()
    {
        $products = new Product();
        $products->setDb($this->di->get("db"));

        $request = $this->di->get("request");

        $amountPerPage = 50;
        $calcOffset = $request->getGet(htmlentities("page")) * $amountPerPage;
        $offset = $request->getGet(htmlentities("page")) == 1 ? 0 : $calcOffset;

        $res = $this->pagination([1], "getProductsUnder500", "getProductsUnder500",
            [1, null, $offset], "products", "/under500Male?page=1");

        $data = [
            "under500Male" => $res[0],
            "amountOfProducts" => $res[1]
        ];


        $this->display("Produkter under 500kr", "product/under500Male", $data);
    }



    /**
     * This function will render page.
     * @method display()
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



    /**
     * This function will return products based on offset and how many productes there are in the database.
     * @method pagination()
     * @param  array     $getAll array with parameters to send to function
     * @param  string     $f1    name of the first function that will use offset
     * @param  string     $f2    name of the second function with no offset
     * @param  array     $args   array with parameters to send to function
     * @param  string     $url   first part of url
     * @param  string     $path  path to resource
     * @return mixed
     */
    private function pagination($getAll, $f1, $f2, $args, $url, $path = "")
    {
        $product = new Product();
        $product->setDb($this->di->get("db"));
        $amountOfProducts = count($product->$f1(...$getAll));


        $request = $this->di->get("request");

        $amountPerPage = 50;
        $res = null;

        if ($request->getGet("page")) {
            $pageMinCheck = $request->getGet(htmlentities("page")) > 0;
            $pageMaxCheck = $request->getGet(htmlentities("page")) <= floor($amountOfProducts / $amountPerPage);
            $pageLess1 = $request->getGet(htmlentities("page")) < 1;
            $pageLargerMax = $request->getGet(htmlentities("page")) > floor($amountOfProducts / $amountPerPage);
            if ($pageMinCheck && $pageMaxCheck) {
                $res = $product->$f1(...$args);
            } elseif ($pageLess1 || $pageLargerMax) {
                $redirect = $this->di->get("url")->create($url);
                $this->di->get("response")->redirect("$redirect" . "$path");
                return false;
            }
        } elseif (!$request->getGet("page")) {
            $res = $product->$f2(...$getAll);
        }

        return [$res, $amountOfProducts];
    }
}
