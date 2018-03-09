<?php

namespace Anax\Page;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

/**
 * A default page rendering class.
 * @SuppressWarnings(PHPMD.ExitExpression)
 */
class PageRender implements PageRenderInterface, InjectionAwareInterface
{
    use InjectionAwareTrait;



    /**
     * Render a standard web page using a specific layout.
     *
     * @param array   $data   variables to expose to layout view.
     * @param integer $status code to use when delivering the result.
     *
     * @return void
     */
    public function renderPage($data = null, $status = 200)
    {
        $data["stylesheets"] = ["css/style.css", "../vendor/twbs/bootstrap/dist/css/bootstrap.min.css"];
        $data["scripts"] = [
            "../vendor/twbs/bootstrap/assets/js/vendor/jquery-slim.min.js",
            "../vendor/twbs/bootstrap/assets/js/vendor/popper.min.js",
            "../vendor/twbs/bootstrap/dist/js/bootstrap.min.js",
            "https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"
        ];

        $view = $this->di->get("view");
        $view->add("defaults/header", [], "header");
        $view->add("navbar/navbar", [], "navbar");
        $view->add("defaults/footer", [], "footer");

        // Add layout, render it, add to response and send.
        $view = $this->di->get("view");
        $view->add("defaults/layout", $data, "layout");
        $body = $view->renderBuffered("layout");
        $this->di->get("response")->setBody($body)
                                  ->send($status);
        exit;
    }
}
