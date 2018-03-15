<?php

namespace Course\User\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Course\User\User;
use \Anax\DI\DIInterface;

/**
 * Example of FormModel implementation.
 */
class UserUpdateForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param \Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di)
    {
        parent::__construct($di);

        $session = $this->di->get("session");
        
        $currentUser = new User();
        $currentUser->setDb($this->di->get("db"));
        $currentUser->getUserInformationByEmail($session->get("email"));

        $gender = $currentUser->userGender === 1 ? "Male" : "Female";

        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Update user",
                "class"  => "form-group w-50 d-flex justify-content-center p-4",
            ],
            [
                "firstname" => [
                    "type"        => "text",
                    "class"       => "form-control",
                    "placeholder" => "$currentUser->userFirstName",
                    "value"       => "$currentUser->userFirstName",
                ],

                "surname" => [
                    "type"        => "text",
                    "class"       => "form-control",
                    "placeholder" => "$currentUser->userSurName",
                    "value"       => "$currentUser->userSurName",
                ],

                "phone" => [
                    "type"        => "number",
                    "class"       => "form-control",
                    "placeholder" => "$currentUser->userPhone",
                    "value"       => "$currentUser->userPhone",
                ],

                "email" => [
                    "type"        => "email",
                    "class"       => "form-control",
                    "placeholder" => "$currentUser->userMail",
                    "value"       => "$currentUser->userMail",
                ],

                "address" => [
                    "type"        => "text",
                    "class"       => "form-control",
                    "placeholder" => "$currentUser->userAddress",
                    "value"       => "$currentUser->userAddress",
                ],

                "postcode" => [
                    "type"        => "number",
                    "class"       => "form-control",
                    "placeholder" => "$currentUser->userPostcode",
                    "value"       => "$currentUser->userPostcode",
                ],

                "city" => [
                    "type"        => "text",
                    "class"       => "form-control",
                    "placeholder" => "$currentUser->userCity",
                    "value"       => "$currentUser->userCity",
                ],

                "gender" => [
                    "type"        => "radio",
                    "label"       => "Gender",
                    "values"      => [
                        "Female",
                        "Male"
                    ],
                    "checked"     => "$gender",
                ],

                "password" => [
                    "type"        => "password",
                    "class"       => "form-control",
                    "placeholder" => "Password",
                ],

                "password-again" => [
                    "type"        => "password",
                    "class"       => "form-control",
                    "placeholder" => "Password again",
                    "validation"  => [
                        "match" => "password"
                    ],
                ],

                "submit" => [
                    "type"     => "submit",
                    "value"    => "Update profile",
                    "class"    => "btn btn-lg btn-primary w-100",
                    "callback" => [$this, "callbackSubmit"]
                ],

                "create" => [
                    "type"     => "submit",
                    "value"    => "Back to profile",
                    "class"    => "btn btn-lg btn-primary w-100",
                    "callback" => [$this, "backToProfile"],
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
        $user = new User();
        $user->setDb($this->di->get("db"));
        $session = $this->di->get("session");
        $user->getUserInformationByEmail($session->get("email"));

        #Get all values from Form
        $arrayOfData = [
            "firstname" => htmlentities($this->form->value("firstname")),
            "surname" => htmlentities($this->form->value("surname")),
            "email" => htmlentities($this->form->value("email")),
            "phone" => htmlentities($this->form->value("phone")),
            "address" => htmlentities($this->form->value("address")),
            "gender" => htmlentities($this->form->value("gender")),
            "postcode" => htmlentities($this->form->value("postcode")),
            "city" => htmlentities($this->form->value("city")),
            "password" => htmlentities($this->form->value("password")),
            "passwordAgain" => htmlentities($this->form->value("password-again"))
        ];

        # Check password matches
        if ($arrayOfData["password"] !== $arrayOfData["passwordAgain"]) {
            $this->form->rememberValues();
            $this->form->addOutput("Password did not match.");
            return false;
        }

        $formcheck = $this->arrayEmpty($arrayOfData);

        if (!$formcheck) {
            $this->form->addOutput("Please fill all inputs!");
            return false;
        }

        # Check if email is already in use. If not create new user.
        if (!$user->checkUserExists($arrayOfData["email"]) || $user->checkUserExists($session->get("mail"))) {
            $user->setFirstname($arrayOfData["firstname"]);
            $user->setSurname($arrayOfData["surname"]);
            $user->setEmail($arrayOfData["email"]);
            $user->setAddress($arrayOfData["address"]);
            $user->setPostcode((int)$arrayOfData["postcode"]);
            $user->setCity($arrayOfData["city"]);
            $user->setPhone((int)$arrayOfData["phone"]);
            $user->setPassword($arrayOfData["password"]);
            $user->setGender($arrayOfData["gender"] === 'Female' ? 0 : 1);
            $user->save();
        } else if ($user->checkUserExists($arrayOfData["email"])) {
            $this->form->addOutput("That mail is already in use.");
            return false;
        }

        $session->set("email", $user->userMail);

        #Create url and redirect to login.
        $url = $this->di->get("url")->create("user/profile");
        $this->di->get("response")->redirect($url);
        return true;
    }



    /**
     * On click it will take the user back their profile page.
     * @method back
     * @return boolean true when redirected.
     */
    public function back()
    {
        #Create url and redirect to user profile.
        $url = $this->di->get("url")->create("user/profile");
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
