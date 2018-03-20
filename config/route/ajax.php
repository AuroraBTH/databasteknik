<?php
/**
 * Default route to create a 404, use if no else route matched.
 */
return [
    "routes" => [
        [
            "info" => "Basket handler",
            "requestMethod" => "POST",
            "path" => "ajax",
            "callable" => ["ajaxController", "addToCart"],
        ],
        [
            "info" => "Ta bort från kundvagnen",
            "requestMethod" => "GET|POST",
            "path" => "ajax/remove",
            "callable" => ["ajaxController", "removeFromCart"]
        ],
    ]
];
