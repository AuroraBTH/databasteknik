<?php
namespace Course\Pagination;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;
use \Course\Product\Product;
use \Course\Category\Category;

class Pagination implements InjectionAwareInterface
{
    use InjectionAwareTrait;


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
    public function pagination($getAll, $f1, $f2, $args, $url, $path = "")
    {
        $product = new Product();
        $product->setDb($this->di->get("db"));
        $amountOfProducts = count($product->$f1(...$getAll));

        $request = $this->di->get("request");

        $amountPerPage = 50;
        $res = null;

        $currentPage = $request->getGet("page");

        if ($currentPage == '0') {
            $redirect = $this->di->get("url")->create($url);
            $this->di->get("response")->redirect("$redirect" . "$path");
            return false;
        }

        if ($request->getGet("page")) {
            $pageMinCheck = $request->getGet(htmlentities("page")) > 0;
            $max = (floor($amountOfProducts / $amountPerPage) == 0 ? 1 : floor($amountOfProducts / $amountPerPage));
            $pageMaxCheck = $request->getGet(htmlentities("page")) <= $max;

            if ($pageMinCheck && $pageMaxCheck && $currentPage > 0) {
                $res = $product->$f1(...$args);
                return [$res, $amountOfProducts];
            }

            $redirect = $this->di->get("url")->create($url);
            $this->di->get("response")->redirect("$redirect" . "$path");
            return false;
        }

        $res = $product->$f2(...$getAll);
        return [$res, $amountOfProducts];
    }

}
