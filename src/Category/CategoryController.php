<?php

namespace Course\Category;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;
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
        $category = new Category();
        $category->setDb($this->di->get("db"));

        $data = [
            "categoriesFemale" => $category->getAllCategoriesGender(0),
            "categoriesMale" => $category->getAllCategoriesGender(1)
        ];

        $this->di->get("render")->display("Kategorier", "category/categories", $data);
    }



    /**
     * Renders the page for subcategories.
     *
     * @param integer $parentID ID to parent category
     *
     */
    public function getSpecificCategory($parentID)
    {
        $category = new Category();
        $category->setDb($this->di->get("db"));

        $title = $category->getSpecificCategory($parentID);
        $categories = $category->getAllSubCategories($parentID);

        if (empty($title) || empty($categories)) {
            $redirect = $this->di->get("url")->create("");
            $this->di->get("response")->redirect($redirect);
            return false;
        }

        $data = [
            "title" => $title,
            "categories" => $categories
        ];

        $this->di->get("render")->display("Kategori", "category/specificCategory", $data);
    }
}
