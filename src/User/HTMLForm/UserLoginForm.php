<?php

namespace Course\User\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Course\User\User;

/**
 * Example of FormModel implementation.
 */
class UserLoginForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di)
    {
        parent::__construct($di);

        $this->form->create(
            [
                "id"     => __CLASS__,
                "legend" => "User Login",
            ],
            [
                "email" => [
                    "type" => "email"
                ],

                "password" => [
                    "type" => "password"
                ],

                "submit" => [
                    "type"     => "submit",
                    "value"    => "Login",
                    "callback" => [$this, "callbackSubmit"],
                ]
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

    }

    public function createUser()
    {

    }
}
