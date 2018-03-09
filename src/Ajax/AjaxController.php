<?php

namespace Course\Ajax;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\Di\InjectionAwareTrait;

class AjaxController implements
    ConfigureInterface,
    InjectionAwareInterface
{
    use ConfigureTrait,
    InjectionAwareTrait;


    public function addToCart()
    {
        $data = $_POST["data"];
        if ($this->di->get("session")->get("items")) {
            $getItems = $this->di->get("session")->get("items");
            array_push($getItems, $data);
            $this->di->get("session")->set("items", $getItems);
        } else {
            $this->di->get("session")->set("items", []);
            $getItems = $this->di->get("session")->get("items");
            array_push($getItems, $data);
            $this->di->get("session")->set("items", $getItems);
        }
        return "success";
    }
}
