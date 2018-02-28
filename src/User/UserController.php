<?php

namespace Course\User;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\Di\InjectionAwareTrait;
use \Course\User\HTMLForm\UserLoginForm;
use \Course\User\HTMLForm\UserCreateForm;

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


    public function getCreatePage()
    {
        $title = "Skapa ny användare";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");


        $createForm = new UserCreateForm($this->di);

        $createForm->check();

        $data = [
            "content" => $createForm->getHTML(),
        ];

        $view->add("default1/article", $data);

        $pageRender->renderPage(["title" => $title]);
    }


    public function getProfilePage()
    {
        $title = "Profil";
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        # Creating new user and set database.
        $user = new User();
        $user->setDb($this->di->get("db"));

        #Get current session.
        $session = $this->di->get("session");

        $data = [
            "content" => $user->getUserInformationByEmail($session->get("email")),
        ];

        $view->add("user/profile", $data);
        $pageRender->renderPage(["title" => $title]);
    }
}
