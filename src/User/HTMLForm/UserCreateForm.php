<?php

namespace Course\User\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Course\User\User;
use \Anax\DI\DIInterface;

/**
 * Example of FormModel implementation.
 */
class UserCreateForm extends FormModel
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
                "legend" => "Skapa användare",
                "class"  => "form-group w-50 d-flex justify-content-center p-4",
            ],
            [
                "firstname" => [
                    "type"        => "text",
                    "class"       => "form-control",
                    "placeholder" => "Förnamn",
                    "label"       => "Förnamn"
                ],

                "surname" => [
                    "type"        => "text",
                    "class"       => "form-control",
                    "placeholder" => "Efternamn",
                    "label"       => "Efternamn"
                ],

                "phone" => [
                    "type"        => "number",
                    "class"       => "form-control",
                    "placeholder" => "Telefonnummer",
                    "label"       => "Telefonnummer"
                ],

                "email" => [
                    "type"        => "email",
                    "class"       => "form-control",
                    "placeholder" => "Email",
                    "label"       => "Email"
                ],

                "address" => [
                    "type"        => "text",
                    "class"       => "form-control",
                    "placeholder" => "Adress",
                    "label"       => "Adress"
                ],

                "postcode" => [
                    "type"        => "number",
                    "class"       => "form-control",
                    "placeholder" => "Postnummer",
                    "label"       => "Postnummer",
                ],

                "city" => [
                    "type"        => "text",
                    "class"       => "form-control",
                    "placeholder" => "Stad",
                    "label"       => "Stad"
                ],

                "gender" => [
                    "type"        => "radio",
                    "label"       => "Kön",
                    "values"      => [
                        "Kvinna",
                        "Man"
                    ],
                    "checked"     => "Kvinna",
                ],

                "password" => [
                    "type"        => "password",
                    "class"       => "form-control",
                    "placeholder" => "********",
                    "label"       => "Lösenord"
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
                    "value"    => "Skapa användare",
                    "class"    => "btn btn-lg btn-primary w-100",
                    "callback" => [$this, "callbackSubmit"]
                ],

                "create" => [
                    "type"     => "submit",
                    "value"    => "Tillbaka",
                    "class"    => "btn btn-lg btn-primary w-100",
                    "callback" => [$this, "backToLogin"],
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
        #Get all values from Form
        $firstname = $this->form->value("firstname");
        $surname = $this->form->value("surname");
        $email = $this->form->value("email");
        $phone = $this->form->value("phone");
        $address = $this->form->value("address");
        $gender = $this->form->value("gender");
        $postcode = $this->form->value("postcode");
        $city = $this->form->value("city");
        $password = $this->form->value("password");
        $passwordAgain = $this->form->value("password-again");

        # Check password matches
        if ($password !== $passwordAgain) {
            $this->form->rememberValues();
            $this->form->addOutput("Password did not match.");
            return false;
        }

        $arrayOfData = [
            $firstname,
            $surname,
            $email,
            $address,
            $postcode,
            $city,
            $password,
            $passwordAgain,
            $phone,
            $gender
        ];

        $formcheck = $this->arrayEmpty($arrayOfData);

        if (!$formcheck) {
            $this->form->addOutput("Please fill all inputs!");
            return false;
        }

        # Create new user and set databas.
        $user = new User();
        $user->setDb($this->di->get("db"));


        # Check if email is already in use. If not create new user.
        if ($user->checkUserExists($email)) {
            $user->setFirstname($firstname);
            $user->setSurname($surname);
            $user->setEmail($email);
            $user->setAddress($address);
            $user->setPostcode((int) $postcode);
            $user->setCity($city);
            $user->setPhone((int) $phone);
            $user->setRole(0);
            $user->setPassword($password);
            $user->setGender($gender === 'Female' ? 0 : 1);
            $user->save();
        } else if (!$user->checkUserExists($email)) {
            $this->form->addOutput("Email already in use");
            return false;
        }

        #Create url and redirect to login.
        $url = $this->di->get("url")->create("user/login");
        $this->di->get("response")->redirect($url);
        return true;
    }



    /**
     * On press it will take the user back to loginpage.
     * @method backToLogin
     * @return boolean true when redirected.
     */
    public function backToLogin()
    {
        #Create url and redirect to login.
        $url = $this->di->get("url")->create("user/login");
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
