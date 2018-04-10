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
            $nav .= "<li class='nav-item $selected my-auto'><a class='nav-link' href='$createUrl'>$item[text]</a></li>";
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

        foreach ((array) $products as $key => $value) {
            $counter += (int) $value['amount'];
        }

        $searchUrl = $this->di->url->create("search");
        $route .= "<li class='nav-item w-50'>
        <form class='nav-link' action='$searchUrl' method='post'>
        <input class='w-100' type='text' name='search' placeholder='Sök'>
        </form></li>";

        if ($session->get("email")) {
            $route .= "<li class='nav-item dropdown my-auto'>";
            $route .= "<a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button'
            data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Min-sida</a>";
            $route .= "<div class='dropdown-menu' aria-labelledby='navbarDropdown'>";

            $createUrlProfile = $this->di->url->create("user/profile");
            $route .= "<a class='dropdown-item' href='$createUrlProfile'>Min sida</a>";

            if ($user->getPermission($session->get("email")) == 1) {
                $adminUrl = $this->di->url->create("admin");
                $route .= "<a class='dropdown-item' href='$adminUrl'>Admin</a>";
            } else if ($user->getPermission($session->get("email")) == 2) {
                $cmRoute = $this->di->url->create("management");
                $route .= "<a class='dropdown-item' href='$cmRoute'>Management</a>";
            }

            $route .= "<div class='dropdown-divider'></div>";
            $createUrlLogout = $this->di->url->create("user/logout");
            $route .= "<a class='dropdown-item' href='$createUrlLogout'>Logga ut</a>";

            $route .= "</li>";
        } elseif (!$session->get("email")) {
            $loginUrl = $this->di->url->create("user/login");
            $route .= "<li class='nav-item my-auto'><a class='nav-link' href='$loginUrl'>Logga in</a></li>";
        }

        $cartUrl = $this->di->url->create("cart");
        $route .= "<li class='nav-item my-auto' id='cart'><a class='nav-link' href='$cartUrl'>
        <i class='fas fa-shopping-cart'></i> Kundvagn ($counter)</a></li>";

        return $route;
    }
}
