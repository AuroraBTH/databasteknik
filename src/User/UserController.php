<?php

namespace Course\User;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;
use \Course\User\HTMLForm\UserLoginForm;
use \Course\User\HTMLForm\UserCreateForm;
use \Course\User\HTMLForm\UserUpdateForm;

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



    /**
     * Rendering of login page.
     * @method getLoginPage()
     * @return void
     */
    public function getLoginPage()
    {
        $url = $this->di->get("url");
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        if ($session->has("email")) {
            $url = $url->create("user/profile");
            $response->redirect($url);
            return false;
        }
        $loginForm = new UserLoginForm($this->di);

        $loginForm->check();

        $data = [
            "content" => $loginForm->getHTML(),
        ];

        $this->display("Inloggning", "default1/article", $data);
    }



    /**
     * Rendering of create user page.
     * @method getCreatePage()
     * @return void
     */
    public function getCreatePage()
    {
        $createForm = new UserCreateForm($this->di);

        $createForm->check();

        $data = [
            "content" => $createForm->getHTML(),
        ];

        $this->display("Skapa ny användare", "default1/article", $data);
    }



    /**
     * Rendering of update profile page.
     * @method updateProfile()
     * @return void
     */
    public function updateProfile()
    {
        $updateForm = new UserUpdateForm($this->di);

        $updateForm->check();

        $data = [
            "content" => $updateForm->getHTML(),
        ];

        $this->display("Uppdatera profil", "default1/article", $data);
    }



    /**
     * Rendering of profile page.
     * @method getProfilePage()
     * @return void
     */
    public function getProfilePage()
    {
        $this->checkLoggedIn();

        # Creating new user and set database.
        $user = new User();
        $user->setDb($this->di->get("db"));

        #Get current session.
        $session = $this->di->get("session");

        $data = [
            "content" => $user->getUserInformationByEmail($session->get("email")),
        ];

        $this->display("Profile", "user/profile", $data);
    }



    /**
     * This function will handle logout.
     * @method logout()
     * @return mixed
     */
    public function logout()
    {
        $url = $this->di->get("url");
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $login = $url->create("user/login");

        if (!$session->has("email")) {
            $response->redirect($login);
        }

        $session->delete("email");
        $session->delete("items");
        $response->redirect($login);

        $hasSession = session_status() == PHP_SESSION_ACTIVE;

        if (!$hasSession) {
            $response->redirect($login);
            return true;
        }
    }



    /**
     * This function will render page.
     * @method display()
     * @param  string $title title of page.
     * @param  string $page  page to render.
     * @param  array  $data  data to render.
     * @return void
     */
    private function display($title, $page, $data = []) {
        $title = $title;
        $view = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $view->add($page, $data);
        $pageRender->renderPage(["title" => $title]);
    }



    /**
     * Check if user is logged in.
     * @method checkLoggedIn()
     * @return mixed
     */
    public function checkLoggedIn()
    {
        $url = $this->di->get("url");
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $login = $url->create("user/login");

        if ($session->has("email")) {
            return true;
        }
        
        $response->redirect($login);
        return false;
    }
}
