<?php

namespace Course\Category;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\Di\InjectionAwareTrait;
use \Course\Category\Category;

class CategoryController implements
    ConfigureInterface,
    InjectionAwareInterface
{
    use ConfigureTrait,
    InjectionAwareTrait;


    /**
     * This function handles the rendering of all categories in the database.
     */
    public function getAllCategories()
    {
        $title = "Kategorier";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $category = new Category();
        $category->setDb($this->di->get("db"));

        $data = [
            "categories" => $category->getAllCategories()
        ];

        $view->add("category/categories", $data);
        $pageRender->renderPage(["title" => $title]);
    }



    /**
     * This function handles the rendering of one specific categories.
     */
    public function getSpecificCategory($categoryId)
    {
        $title = "Kategori";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $data = [
            "categoryId" => $categoryId
        ];

        $view->add("category/specificCategory", $data);
        $pageRender->renderPage(["title" => $title]);
    }



    /**
     * This function handles the rendering of one specific subcategory.
     */
    public function getSpecificSubCategory($categoryId, $specificCategoryId)
    {
        $title = "Kategori";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $data = [
            "categoryId" => $categoryId,
            "specificCategoryId" => $specificCategoryId
        ];

        $view->add("category/specificSubCategory", $data);
        $pageRender->renderPage(["title" => $title]);
    }

}
