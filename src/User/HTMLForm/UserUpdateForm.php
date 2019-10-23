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

        $gender = $currentUser->userGender === 1 ? "Man" : "Kvinna";

        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Uppdatera användare",
                "class"  => "form-group w-50 w-100-mobile d-flex justify-content-center p-4",
            ],
            [
                "firstname" => [
                    "type"        => "text",
                    "class"       => "form-control",
                    "placeholder" => "$currentUser->userFirstName",
                    "value"       => "$currentUser->userFirstName",
                    "label"       => "Förnamn:"
                ],
                "surname" => [
                    "type"        => "text",
                    "class"       => "form-control",
                    "placeholder" => "$currentUser->userSurName",
                    "value"       => "$currentUser->userSurName",
                    "label"       => "Efternamn:"
                ],
                "phone" => [
                    "type"        => "number",
                    "class"       => "form-control",
                    "placeholder" => "$currentUser->userPhone",
                    "value"       => "$currentUser->userPhone",
                    "label"       => "Telefonnummer"
                ],
                "email" => [
                    "type"        => "email",
                    "class"       => "form-control",
                    "placeholder" => "$currentUser->userMail",
                    "value"       => "$currentUser->userMail",
                    "label"       => "Email:"
                ],
                "address" => [
                    "type"        => "text",
                    "class"       => "form-control",
                    "placeholder" => "$currentUser->userAddress",
                    "value"       => "$currentUser->userAddress",
                    "label"       => "Adress:"
                ],
                "postcode" => [
                    "type"        => "number",
                    "class"       => "form-control",
                    "placeholder" => "$currentUser->userPostcode",
                    "value"       => "$currentUser->userPostcode",
                    "label"       => "Postnummer:"
                ],
                "city" => [
                    "type"        => "text",
                    "class"       => "form-control",
                    "placeholder" => "$currentUser->userCity",
                    "value"       => "$currentUser->userCity",
                    "label"       => "Stad:"
                ],
                "gender" => [
                    "type"        => "radio",
                    "label"       => "Kön:",
                    "values"      => [
                        "Kvinna",
                        "Man"
                    ],
                    "checked"     => "$gender",
                ],
                "password" => [
                    "type"        => "password",
                    "class"       => "form-control",
                    "placeholder" => "********",
                    "label"       => "Lösenord:"
                ],
                "password-again" => [
                    "type"        => "password",
                    "class"       => "form-control",
                    "placeholder" => "********",
                    "label"       => "Verifiera lösenord",
                    "validation"  => [
                        "match" => "password"
                    ],
                ],
                "submit" => [
                    "type"     => "submit",
                    "value"    => "Uppdatera profil",
                    "class"    => "btn btn-lg btn-primary w-100",
                    "callback" => [$this, "callbackSubmit"]
                ],
                "create" => [
                    "type"     => "submit",
                    "value"    => "Tillbaka",
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

        $arrayOfData = $this->getDataFromForm();

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

        if ($user->checkUserExists($arrayOfData["email"]) && $session->get("email") !== $arrayOfData["email"]) {
            $this->form->addOutput("That mail is already in use.");
            return false;
        }

        $user->setFirstname($arrayOfData["firstname"]);
        $user->setSurname($arrayOfData["surname"]);
        $user->setEmail($arrayOfData["email"]);
        $user->setAddress($arrayOfData["address"]);
        $user->setPostcode((int) $arrayOfData["postcode"]);
        $user->setCity($arrayOfData["city"]);
        $user->setPhone((int) $arrayOfData["phone"]);
        $user->setPassword($arrayOfData["password"]);
        $user->setGender($arrayOfData["gender"] === 'Female' ? 0 : 1);
        $user->save();

        $session->set("email", $user->userMail);

        #Create url and redirect to login.
        $url = $this->di->get("url")->create("user/profile");
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
            "firstname" => $this->form->value("firstname"),
            "surname" => $this->form->value("surname"),
            "email" => $this->form->value("email"),
            "phone" => $this->form->value("phone"),
            "address" => $this->form->value("address"),
            "gender" => $this->form->value("gender"),
            "postcode" => $this->form->value("postcode"),
            "city" => $this->form->value("city"),
            "password" => $this->form->value("password"),
            "passwordAgain" => $this->form->value("password-again")
        ];

        return $arrayOfData;
    }


    /**
     * On click it will take the user back their profile page.
     * @method backToProfile()
     * @return boolean true when redirected.
     */
    public function backToProfile()
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
