<?php

namespace Course\Category;

use \Anax\Database\ActiveRecordModel;

class Category extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Category";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $categoryID;
    public $categoryName;
    public $parentID;
    public $gender;



    /**
     * Set $categoryName
     *
     * @param string $categoryName name of category
     */
    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;
    }



    /**
     * Set $parentID
     *
     * @param integer $parentID value of parent category.
     */
    public function setParentID($parentID)
    {
        $this->parentID = $parentID;
    }



    /**
     * Set gender: 0 = Female, 1 = Male, 2 = Unisex.
     *
     * @param integer $gender value of gender.
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }



    /**
     * Get all categories from database.
     *
     * @return array $categories list of categories.
     */
    public function getAllCategories()
    {
        $categories = $this->findAll();
        return $categories;
    }



    /**
     * Get all categories based on gender.
     *
     * @param integer $genderID value of gender in database. 0 = Female, 1 = Male
     *
     * @return array
     */
    public function getAllCategoriesGender($genderID)
    {
        $categories = $this->findAllWhere("gender = ? AND parentID IS NULL", $genderID);
        return $categories;
    }



    public function getAllSubCategoriesGender($genderID)
    {
        $categories = $this->findAllWhere("gender = ? AND parentID IS NOT NULL", $genderID);
        return $categories;
    }



    /**
     * Get specific categories based on its ID.
     *
     * @param integer $categoryID the ID to the category
     *
     * @return array
     */
    public function getSpecificCategory($categoryID)
    {
        $categories = $this->findAllWhere("categoryID = ?", $categoryID);
        return $categories;
    }



    /**
     * Get all sub-ategories based on parent category ID.
     *
     * @param integer $parentID ID to parent category.
     *
     * @return array
     */
    public function getAllSubCategories($parentID)
    {
        $categories = $this->findAllWhere("parentID = ?", $parentID);
        return $categories;
    }
}
