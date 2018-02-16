<?php

namespace Course\Base;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\Di\InjectionAwareTrait;
use \Course\Base\Base;

class BaseController implements
    ConfigureInterface,
    InjectionAwareInterface
{
    use ConfigureTrait,
    InjectionAwareTrait;


    /**
     * This function handles the rendering of frontpage.
     */
    public function frontpage()
    {
        $title = "Frontpage";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $view->add("base/home");
        $pageRender->renderPage(["title" => $title]);
    }

    /**
     * This function handles the rendering of aboutpage.
     */
    public function aboutpage()
    {
        $title = "About";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $view->add("base/about");
        $pageRender->renderPage(["title" => $title]);
    }
}
