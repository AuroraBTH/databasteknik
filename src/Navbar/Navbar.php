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

        if ($session->get("email")) {
            $createUrlLogout = $this->di->url->create("user/logout");
            $createUrlProfile = $this->di->url->create("user/profile");
            $route = "<li class='nav-item'><a class='nav-link' href='$createUrlProfile'>Min sida</a></li>";
            $route .= "<li class='nav-item'><a class='nav-link' href='$createUrlLogout'>Logga ut</a></li>";
        } else if (!$session->get("email")) {
            $loginUrl = $this->di->url->create("user/login");
            $route = "<li class='nav-item'><a class='nav-link' href='$loginUrl'>Logga in</a></li>";
        }

        $cartUrl = $this->di->url->create("cart");
        $route .= "<li class='nav-item'><a class='nav-link' href='$cartUrl'>
        <i class='fas fa-shopping-cart'></i> Cart</a></li>";

        return $route;
    }
}
