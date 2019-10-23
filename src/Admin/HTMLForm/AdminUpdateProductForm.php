<?php

namespace Course\Admin\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Course\Product\Product;
use \Anax\DI\DIInterface;
use Course\Category\Category;

/**
 * Example of FormModel implementation.
 */
class AdminUpdateProductForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param \Anax\DI\DIInterface $di a service container
     */

    private $productID;


    public function __construct(DIInterface $di, $productID)
    {
        parent::__construct($di);

        $product = new Product();
        $product->setDb($this->di->get("db"));
        $product->getProductByID($productID);

        $category = new Category();
        $category->setDb($this->di->get("db"));
        $categories = $category->getAllSubCategoriesGender($product->productGender);

        $currentCategory = $category->getSpecificCategory($product->productCategoryID);

        $categoryArr = [];

        foreach ($categories as $value) {
            $categoryArr[$value->categoryID] = $value->categoryName;
        }

        $this->productID = $productID;
        $gender = $product->productGender == 0 ? "Kvinna" : "Man";

        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Updatera produkt ($gender)",
                "class"  => "form-group w-50 w-100-mobile d-flex justify-content-center p-4",
            ],
            [
                "productManufacturer" => [
                    "label"       => "Tillverkare",
                    "type"        => "text",
                    "class"       => "form-control",
                    "placeholder" => "$product->productManufacturer",
                    "value"       => "$product->productManufacturer",
                    "maxlength"   => 80
                ],
                "productName" => [
                    "label"       => "Namn",
                    "type"        => "text",
                    "class"       => "form-control",
                    "placeholder" => "$product->productName",
                    "value"       => html_entity_decode("$product->productName"),
                    "maxlength"   => 80
                ],
                "productOriginCountry" => [
                    "label"       => "Land",
                    "type"        => "text",
                    "class"       => "form-control",
                    "placeholder" => "$product->productOriginCountry",
                    "value"       => "$product->productOriginCountry",
                    "maxlength"   => 39
                ],
                "productWeight" => [
                    "label"       => "Vikt",
                    "type"        => "number",
                    "class"       => "form-control",
                    "placeholder" => "$product->productWeight",
                    "value"       => "$product->productWeight",
                ],
                "productSize" => [
                    "label"       => "Storlek",
                    "type"        => "text",
                    "class"       => "form-control",
                    "placeholder" => "$product->productSize",
                    "value"       => "$product->productSize",
                    "maxlength"   => 3
                ],
                "productSellPrize" => [
                    "label"       => "Säljpris",
                    "type"        => "number",
                    "class"       => "form-control",
                    "placeholder" => "$product->productSellPrize",
                    "value"       => "$product->productSellPrize",
                ],
                "productBuyPrize" => [
                    "label"       => "Inköpspris",
                    "type"        => "number",
                    "class"       => "form-control",
                    "placeholder" => "$product->productBuyPrize",
                    "value"       => "$product->productBuyPrize",
                ],
                "productColor" => [
                    "label"       => "Färg",
                    "type"        => "text",
                    "class"       => "form-control",
                    "placeholder" => "$product->productColor",
                    "value"       => "$product->productColor",
                    "maxlength"   => 20
                ],
                "productAmount" => [
                    "label"       => "Antal",
                    "type"        => "number",
                    "class"       => "form-control",
                    "placeholder" => "$product->productAmount",
                    "value"       => "$product->productAmount",
                ],
                "productCategoryID" => [
                    "type"        => "select",
                    "label"       => "Kategori",
                    "class"       => "custom-select",
                    "options"     => $categoryArr,
                    "value"     => $currentCategory[0]->categoryID
                ],
                "submit" => [
                    "type"     => "submit",
                    "value"    => "Updatera product",
                    "class"    => "btn btn-lg btn-primary w-100",
                    "callback" => [$this, "callbackSubmit"]
                ],
                "back" => [
                    "type"     => "submit",
                    "value"    => "Tillbaka till produkter",
                    "class"    => "btn btn-lg btn-primary w-100",
                    "callback" => [$this, "back"],
                ],
            ]
        );
    }


    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        # Create new user and set databas.
        $product = new Product();
        $product->setDb($this->di->get("db"));

        $productID = $this->productID;

        $product->getProductByID($productID);

        #Get all values from Form
        $arrayOfData = $this->getDataFromForm();

        $formcheck = $this->arrayEmpty($arrayOfData);

        if (!$formcheck) {
            $this->form->addOutput("Please fill all inputs!");
            return false;
        }

        $product->setProductManufacturer($arrayOfData["productManufacturer"]);
        $product->setProductName($arrayOfData["productName"]);
        $product->setProductCountry($arrayOfData["productOriginCountry"]);
        $product->setProductWeight((int) $arrayOfData["productWeight"]);
        $product->setProductSize($arrayOfData["productSize"]);
        $product->setProductSellPrize((int) $arrayOfData["productSellPrize"]);
        $product->setProductBuyPrize((int) $arrayOfData["productBuyPrize"]);
        $product->setProductColor($arrayOfData["productColor"]);
        $product->setProductAmount((int) $arrayOfData["productAmount"]);
        $product->setProductCategoryID((int) $arrayOfData["productCategoryID"]);
        $product->setProductGender($product->productGender);
        $product->setProductDeleted("false");
        $product->save();

        // #Create url and redirect to login.
        $url = $this->di->get("url")->create("admin/products");
        $this->di->get("response")->redirect($url);
        return true;
    }



    /**
     * Get all data from form.
     * @method getDataFromForm
     * @return array with data from form.
     */
    public function getDataFromForm()
    {
        $arrayOfData = [
            "productManufacturer" => $this->form->value("productManufacturer"),
            "productName" => $this->form->value("productName"),
            "productOriginCountry" => $this->form->value("productOriginCountry"),
            "productWeight" => $this->form->value("productWeight"),
            "productSize" => $this->form->value("productSize"),
            "productSellPrize" => $this->form->value("productSellPrize"),
            "productBuyPrize" => $this->form->value("productBuyPrize"),
            "productColor" => $this->form->value("productColor"),
            "productAmount" => $this->form->value("productAmount"),
            "productCategoryID" => $this->form->value("productCategoryID")
        ];

        return $arrayOfData;
    }



    /**
     * On click it will take you back to admin products
     * @method back()
     * @return boolean true when redirected.
     */
    public function back()
    {
        #Create url and redirect to user profile.
        $url = $this->di->get("url")->create("admin/products");
        $this->di->get("response")->redirect($url);
        return true;
    }



    /**
     * A simple function to check if any of the values in the targeted array is null.
     *
     * @return boolean true if okey, false if one or more is null.
     */
    public function arrayEmpty($array)
    {
        foreach ($array as $item) {
            if ($item == null) {
                return false;
            }
        }

        return true;
    }
}
