<?php

namespace Course\Admin\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Course\Product\Product;
use \Anax\DI\DIInterface;

use \Course\Category\Category;

/**
 * Example of FormModel implementation.
 */
class AdminBuyFemaleForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param \Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di)
    {
        parent::__construct($di);

        $category = new Category();
        $category->setDb($this->di->get("db"));
        $categories = $category->getAllSubCategoriesGender(0);

        $categoryArr = [];

        foreach ($categories as $value) {
            $categoryArr[$value->categoryID] = $value->categoryName;
        }


        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Köp produkt (Kvinna)",
                "class"  => "form-group w-50 w-100-mobile d-flex justify-content-center p-4",
            ],
            [
                "productManufacturer" => [
                    "label"       => "Tillverkare",
                    "type"        => "text",
                    "class"       => "form-control",
                    "maxlength"   => 80
                ],
                "productName" => [
                    "label"       => "Namn",
                    "type"        => "text",
                    "class"       => "form-control",
                    "maxlength"   => 80
                ],
                "productOriginCountry" => [
                    "label"       => "Land",
                    "type"        => "text",
                    "class"       => "form-control",
                    "maxlength"   => 39
                ],
                "productWeight" => [
                    "label"       => "Vikt",
                    "type"        => "number",
                    "class"       => "form-control",
                ],
                "productSize" => [
                    "label"       => "Storlek",
                    "type"        => "text",
                    "class"       => "form-control",
                    "maxlength"   => 3
                ],
                "productSellPrize" => [
                    "label"       => "Säljpris",
                    "type"        => "number",
                    "class"       => "form-control",
                ],
                "productBuyPrize" => [
                    "label"       => "Pris (Köp)",
                    "type"        => "number",
                    "class"       => "form-control",
                ],
                "productColor" => [
                    "label"       => "Färg",
                    "type"        => "text",
                    "class"       => "form-control",
                    "maxlength"   => 20
                ],
                "productAmount" => [
                    "label"       => "Antal",
                    "type"        => "number",
                    "class"       => "form-control",
                ],
                "productCategoryID" => [
                    "type"        => "select",
                    "label"       => "Kategori",
                    "class"       => "custom-select",
                    "options"     => $categoryArr
                ],
                "submit" => [
                    "type"     => "submit",
                    "value"    => "Lägg till",
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

        $arrayOfData = $this->getDataFromForm();

        $formcheck = $this->arrayEmpty($arrayOfData);

        if (!$formcheck) {
            $this->form->addOutput("Please fill all inputs!");
            return false;
        }

        $product = new Product();
        $product->setDb($this->di->get("db"));

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
        $product->setProductGender(1);
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
     * On press it will take the user back to admin.
     * @method back()
     * @return boolean true when redirected.
     */
    public function back()
    {
        #Create url and redirect to login.
        $url = $this->di->get("url")->create("admin");
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
