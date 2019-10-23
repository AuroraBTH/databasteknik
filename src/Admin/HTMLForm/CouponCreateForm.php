<?php

namespace Course\Admin\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Course\Coupon\Coupon;
use \Anax\DI\DIInterface;

/**
 * Example of FormModel implementation.
 */
class CouponCreateForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param \Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Lägg till kupong",
                "class"  => "form-group w-50 w-100-mobile d-flex justify-content-center p-4",
            ],
            [
                "name" => [
                    "type"        => "text",
                    "class"       => "form-control",
                    "placeholder" => "Namn/Kod",
                ],

                "amount" => [
                    "type"        => "number",
                    "class"       => "form-control",
                    "placeholder" => "Mängd (%)",
                ],

                "start" => [
                    "type"        => "date",
                    "class"       => "form-control",
                ],

                "end" => [
                    "type"        => "date",
                    "class"       => "form-control",
                ],

                "submit" => [
                    "type"     => "submit",
                    "value"    => "Lägg till kupong",
                    "class"    => "btn btn-lg btn-primary w-100",
                    "callback" => [$this, "callbackSubmit"]
                ],

                "create" => [
                    "type"     => "submit",
                    "value"    => "Tillbaka",
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

        #Create new Coupon and set databas.
        $coupon = new Coupon();
        $coupon->setDb($this->di->get("db"));

        if ($coupon->getCouponByName($arrayOfData["name"]) != null) {
            $this->form->addOutput("Coupon already exists.");
            return false;
        }

        $coupon->setName($arrayOfData["name"]);
        $coupon->setAmount((int) $arrayOfData["amount"]);
        $coupon->setStartDate($arrayOfData["start"]);
        $coupon->setFinishDate($arrayOfData["end"]);
        $coupon->save();

        #Create url and redirect to admin.
        $url = $this->di->get("url")->create("admin");
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
            "name" => $this->form->value("name"),
            "amount" => $this->form->value("amount"),
            "start" => $this->form->value("start"),
            "end" => $this->form->value("end")
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
