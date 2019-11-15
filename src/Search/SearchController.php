<?php

namespace Course\Search;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

use \Course\Product\Product;


class SearchController implements
    ConfigureInterface,
    InjectionAwareInterface
{
    use ConfigureTrait,
    InjectionAwareTrait;



    /**
     * Rendering of search result
     * @method displayResult()
     * @return mixed
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

        if (!isset($_POST["search"])) {
            $redirectUrl = $url->create("");
            $response->redirect($redirectUrl);
            return false;
        }

        $searchString = $_POST["search"];
        $searchResult = $product->searchProducts($searchString);
        $searchResultCount = count($searchResult);

        $data = [
            "searchResultCount" => $searchResultCount,
            "searchResult" => $searchResult
        ];

        $view->add("search/search", $data);
        $pageRender->renderPage(["title" => $title]);
    }
}
