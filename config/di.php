<?php
/**
 * Configuration file for DI container.
 */
return [

    // Services to add to the container.
    "services" => [
        "request" => [
            "shared" => true,
            "callback" => function() {
                $request = new \Anax\Request\Request();
                $request->init();
                return $request;
            }
        ],
        "response" => [
            "shared" => true,
            "callback" => function() {
                $obj = new \Anax\Response\ResponseUtility();
                $obj->setDI($this);
                return $obj;
            }
        ],
        "url" => [
            "shared" => true,
            "callback" => function() {
                $url = new \Anax\Url\Url();
                $request = $this->get("request");
                $url->setSiteUrl($request->getSiteUrl());
                $url->setBaseUrl($request->getBaseUrl());
                $url->setStaticSiteUrl($request->getSiteUrl());
                $url->setStaticBaseUrl($request->getBaseUrl());
                $url->setScriptName($request->getScriptName());
                $url->configure("url.php");
                $url->setDefaultsFromConfiguration();
                return $url;
            }
        ],
        "router" => [
            "shared" => true,
            "callback" => function() {
                $router = new \Anax\Route\Router();
                $router->setDI($this);
                $router->configure("route.php");
                return $router;
            }
        ],
        "view" => [
            "shared" => true,
            "callback" => function() {
                $view = new \Anax\View\ViewCollection();
                $view->setDI($this);
                $view->configure("view.php");
                return $view;
            }
        ],
        "viewRenderFile" => [
            "shared" => true,
            "callback" => function() {
                $viewRender = new \Anax\View\ViewRenderFile2();
                $viewRender->setDI($this);
                return $viewRender;
            }
        ],
        "session" => [
            "shared" => true,
            "active" => true,
            "callback" => function() {
                $session = new \Anax\Session\SessionConfigurable();
                $session->configure("session.php");
                $session->start();
                return $session;
            }
        ],
        "pageRender" => [
            "shared" => true,
            "callback" => function() {
                $obj = new \Anax\Page\PageRender();
                $obj->setDI($this);
                return $obj;
            }
        ],
        "errorController" => [
            "shared" => true,
            "callback" => function() {
                $obj = new \Anax\Page\ErrorController();
                $obj->setDI($this);
                return $obj;
            }
        ],
        "debugController" => [
            "shared" => true,
            "callback" => function() {
                $obj = new \Anax\Page\DebugController();
                $obj->setDI($this);
                return $obj;
            }
        ],
        "db" => [
            "shared" => true,
            "callback" => function() {
                $obj = new \Anax\Database\DatabaseQueryBuilder();
                $obj->configure("database.php");
                return $obj;
            }
        ],
        "baseController" => [
            "shared" => true,
            "callback" => function() {
                $obj = new \Course\Base\BaseController();
                $obj->setDI($this);
                return $obj;
            }
        ],
        "categoryController" => [
            "shared" => true,
            "callback" => function() {
                $obj = new \Course\Category\CategoryController();
                $obj->setDI($this);
                return $obj;
            }
        ],
        "productController" => [
            "shared" => true,
            "callback" => function() {
                $obj = new \Course\Product\ProductController();
                $obj->setDI($this);
                return $obj;
            }
        ],
        "userController" => [
            "shared" => true,
            "callback" => function() {
                $obj = new \Course\User\UserController();
                $obj->setDI($this);
                return $obj;
            }
        ],
        "ajaxController" => [
            "shared" => true,
            "callback" => function() {
                $obj = new \Course\Ajax\AjaxController();
                $obj->setDI($this);
                return $obj;
            }
        ],
        "cartController" => [
            "shared" => true,
            "callback" => function() {
                $obj = new \Course\Cart\CartController();
                $obj->setDI($this);
                return $obj;
            }
        ],
        "orderController" => [
            "shared" => true,
            "callback" => function() {
                $obj = new \Course\Order\OrderController();
                $obj->setDI($this);
                return $obj;
            }
        ],
        "searchController" => [
            "shared" => true,
            "callback" => function() {
                $obj = new \Course\Search\SearchController();
                $obj->setDI($this);
                return $obj;
            }
        ],
        "adminController" => [
            "shared" => true,
            "callback" => function() {
                $obj = new \Course\Admin\AdminController();
                $obj->setDI($this);
                return $obj;
            }
        ],
        "managementController" => [
            "shared" => true,
            "callback" => function() {
                $obj = new \Course\Management\ManagementController();
                $obj->setDI($this);
                return $obj;
            }
        ],
        "navbar" => [
            "shared" => true,
            "callback" => function() {
                $navbar = new \Course\Navbar\Navbar();
                $navbar->setDI($this);
                $navbar->configure("navbar.php");
                return $navbar;
            }
        ],
        "pagination" => [
            "shared" => true,
            "callback" => function() {
                $pagination = new \Course\Pagination\Pagination();
                $pagination->setDI($this);
                return $pagination;
            }
        ],
        "render" => [
            "shared" => true,
            "callback" => function() {
                $render = new \Course\Render\Render();
                $render->setDI($this);
                return $render;
            }
        ],
        "calc" => [
            "shared" => true,
            "callback" => function() {
                $calc = new \Course\Calc\Calc();
                $calc->setDI($this);
                return $calc;
            }
        ],
    ],
];
