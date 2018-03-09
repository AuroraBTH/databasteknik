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
        $exists = false;
        if ($this->di->get("session")->get("items")) {
            $getItems = $this->di->get("session")->get("items");

            foreach ($getItems as $key => $value) {
                if ($data['productID'] === $value['productID']) {
                    $test = $value["amount"] + 1;
                    $getItems[$key]['amount'] = $test;
                    $exists = true;
                }
            }

            if (!$exists) {
                $data["amount"] = 1;
                array_push($getItems, $data);
            }

            $this->di->get("session")->set("items", $getItems);
        } elseif (!$this->di->get("session")->get("items")) {
            $this->di->get("session")->set("items", []);
            $getItems = $this->di->get("session")->get("items");
            $data["amount"] = 1;
            array_push($getItems, $data);
            $this->di->get("session")->set("items", $getItems);
        }
        return "success";
    }
}
