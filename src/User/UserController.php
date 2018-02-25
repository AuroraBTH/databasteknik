<?php

namespace Course\User;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\Di\InjectionAwareTrait;
use \Course\User\HTMLForm\UserLoginForm;

/**
 * A controller class.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class UserController implements
    ConfigureInterface,
    InjectionAwareInterface
{
    use ConfigureTrait,
        InjectionAwareTrait;



    public function getLoginPage()
    {
        $title = "Inloggning";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");


        $loginForm = new UserLoginForm($this->di);

        $loginForm->check();

        $data = [
            "content" => $loginForm->getHTML(),
        ];

        $view->add("default1/article", $data);

        $pageRender->renderPage(["title" => $title]);
    }
}
