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
        $data["stylesheets"] = [
            "../vendor/twbs/bootstrap/dist/css/bootstrap.min.css",
            "../vendor/components/font-awesome/css/all.min.css",
            "css/style.css"
        ];

        $data["scripts"] = [
            "../vendor/components/jquery/jquery.min.js",
            "../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js",
            "js/product.js",
            "js/cart.js"
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
