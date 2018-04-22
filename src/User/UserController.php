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
     * @return mixed
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

        $this->di->get("render")->display("Inloggning", "default1/article", $data);
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

        $this->di->get("render")->display("Skapa ny användare", "default1/article", $data);
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

        $this->di->get("render")->display("Uppdatera profil", "default1/article", $data);
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

        $this->di->get("render")->display("Profile", "user/profile", $data);
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
