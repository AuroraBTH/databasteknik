<?php

namespace Course\Search;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\Di\InjectionAwareTrait;

use \Course\Product\Product;


class SearchController implements
    ConfigureInterface,
    InjectionAwareInterface
{
    use ConfigureTrait,
    InjectionAwareTrait;



    /**
     * Rendering of search result
     * @method displayResult
     * @return void.
     */
    public function displayResult()
    {
        $title = "Sökresultat";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $url = $this->di->get("url");
        $response = $this->di->get("response");

        $db = $this->di->get("db");

        $product = new Product;
        $product->setDb($db);

        $searchResultCount;
        $searchResult;

        if (isset($_POST["search"])) {
            $searchString = htmlspecialchars($_POST["search"]);
            $searchResult = $product->searchProducts($searchString);
            $searchResultCount = count($searchResult);
        } else if (!isset($_POST["search"])) {
            $redirectUrl = $url->create("");
            $response->redirect($redirectUrl);
            return false;
        }

        $data = [
            "searchResultCount" => $searchResultCount,
            "searchResult" => $searchResult
        ];

        $view->add("search/search", $data);
        $pageRender->renderPage(["title" => $title]);
    }
}
