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
                "legend" => "Create user",
            ],
            [
                "firstname" => [
                    "type" => "text",
                ],

                "surname" => [
                    "type" => "text",
                ],

                "email" => [
                    "type" => "email"
                ],

                "address" => [
                    "type" => "text"
                ],

                "postcode" => [
                    "type" => "number"
                ],

                "city" => [
                    "type" => "text"
                ],

                "password" => [
                    "type" => "password"
                ],

                "password-again" => [
                    "type" => "password",
                    "validation" => [
                        "match" => "password"
                    ],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Create user",
                    "callback" => [$this, "callbackSubmit"]
                ],

                "create" => [
                    "type"     => "submit",
                    "value"    => "Back to login",
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
        $firstname = htmlentities($this->form->value("firstname"));
        $surname = htmlentities($this->form->value("surname"));
        $email = htmlentities($this->form->value("email"));
        $address = htmlentities($this->form->value("address"));
        $postcode = htmlentities($this->form->value("postcode"));
        $city = htmlentities($this->form->value("city"));
        $password = htmlentities($this->form->value("password"));
        $passwordAgain = htmlentities($this->form->value("password-again"));


        # Check password matches
        if ($password !== $passwordAgain) {
            $this->form->rememberValues();
            $this->form->addOutput("Password did not match.");
            return false;
        }

        $arrayOfData = [$firstname, $surname, $email, $address, $postcode, $city, $password, $passwordAgain];
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
            $user->setPostcode((int)$postcode);
            $user->setCity($city);
            $user->setRole(0);
            $user->setPassword($password);
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
