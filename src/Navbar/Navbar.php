<?php
namespace Course\Navbar;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;
use \Course\User\User;

class Navbar implements InjectionAwareInterface
{
    use \Anax\Common\ConfigureTrait;
    use InjectionAwareTrait;

    public function createNav()
    {
        $nav = "";
        foreach ($this->config["items"]["user"] as $item) {
            $createUrl = $this->di->url->create($item["route"]);
            $selected = $this->di->request->getRoute() == $item["route"] ? "active" : "";
            $nav .= "<li class='nav-item $selected' ><a class='nav-link' href='$createUrl'>$item[text]</a></li>";
        }

        $logUrl = $this->checkUserLogin();

        return $nav . $logUrl;
    }

    /**
    * Checks if user is logged in.
    *
    * @return string $route to login || logout
    */
    public function checkUserLogin()
    {
        $user = new User();
        $user->setDb($this->di->get("db"));

        $session = $this->di->get("session");
        $route = "";

        $counter = 0;


        $products = $this->di->get("session")->get("items");

        foreach ((array)$products as $key => $value) {
            $counter += (int)$value['amount'];
        }


        if ($session->get("email")) {
            $createUrlLogout = $this->di->url->create("user/logout");
            $createUrlProfile = $this->di->url->create("user/profile");
            $route = "<li class='nav-item'><a class='nav-link' href='$createUrlProfile'>Min sida</a></li>";
            $route .= "<li class='nav-item'><a class='nav-link' href='$createUrlLogout'>Logga ut</a></li>";
        } elseif (!$session->get("email")) {
            $loginUrl = $this->di->url->create("user/login");
            $route = "<li class='nav-item'><a class='nav-link' href='$loginUrl'>Logga in</a></li>";
        }

        $searchUrl = $this->di->url->create("search");
        $route .= "<li class='nav-item'>
        <form class='nav-link' action='$searchUrl' method='post'>
        <input type='text' name='search' placeholder='Sök'>
        </form></li>";
        $cartUrl = $this->di->url->create("cart");
        $route .= "<li class='nav-item' id='cart'><a class='nav-link' href='$cartUrl'>
        <i class='fas fa-shopping-cart'></i> Kundvagn ($counter)</a></li>";


        if ($session->has("email")) {
            if ($user->getPermission($session->get("email")) == 1 || $user->getPermission($session->get("email")) == 2) {
                $adminUrl = $this->di->url->create("admin");
                $route .= "<li class='nav-item'><a class='nav-link' href='$adminUrl'>Admin</a></li>";
            }
        }

        return $route;
    }
}
