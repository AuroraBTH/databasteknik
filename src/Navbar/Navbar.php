<?php
namespace Course\Navbar;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

class Navbar implements InjectionAwareInterface
{
    use \Anax\Common\ConfigureTrait;
    use InjectionAwareTrait;

    public function createNav()
    {
        $nav = "";
        foreach ($this->config["items"]["user"] as $item) {
            $createUrl = $this->di->url->create($item["route"]);
            $selected = $this->di->request->getRoute() == $item["route"] ? "selected" : "";
            $nav .= "<li class='$selected' ><a href='$createUrl'>$item[text]</a></li>";
        }
        return $nav;
    }
}
