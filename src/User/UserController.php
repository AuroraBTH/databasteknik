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

        $url = $this->di->get("url");
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        if ($session->has("email")) {
            $url = $url->create("user/profile");
            $response->redirect($url);
        } else if (!$session->has("email")) {
            $loginForm = new UserLoginForm($this->di);

            $loginForm->check();

            $data = [
                "content" => $loginForm->getHTML(),
            ];

            $view->add("default1/article", $data);

            $pageRender->renderPage(["title" => $title]);
        }
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

        $this->checkLoggedIn();

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



    public function logout()
    {
        $url = $this->di->get("url");
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $login = $url->create("user/login");

        if ($session->has("email")) {
            $session->delete("email");
            $response->redirect($login);
        } else if (!$session->has("email")) {
            $response->redirect($login);
        }

        $hasSession = session_status() == PHP_SESSION_ACTIVE;

        if (!$hasSession) {
            $response->redirect($login);
            return true;
        }
    }



    public function checkLoggedIn()
    {
        $url = $this->di->get("url");
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $login = $url->create("user/login");

        if ($session->has("email")) {
            return true;
        } else if (!$session->has("email")) {
            $response->redirect($login);
            return false;
        }
    }
}
