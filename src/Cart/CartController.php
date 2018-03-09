<?php

namespace Course\Cart;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\Di\InjectionAwareTrait;

class CartController implements
    ConfigureInterface,
    InjectionAwareInterface
{
    use ConfigureTrait,
    InjectionAwareTrait;


    public function displayCart() {
        $title = "Kundvagn";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        #Get current session.
        $session = $this->di->get("session");

        $data = [
            "cartItems" => $session->get("items"),
        ];

        $view->add("cart/cart", $data);
        $pageRender->renderPage(["title" => $title]);
    }
}
