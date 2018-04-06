<?php
/**
 * Category routes.
 */
return [
    "routes" => [
        [
            "info" => "Kundvagn",
            "requestMethod" => "GET",
            "path" => "cart",
            "callable" => ["cartController", "displayCart"]
        ],
        [
            "info" => "Kassa",
            "requestMethod" => "GET",
            "path" => "cart/checkout",
            "callable" => ["cartController", "displayCheckout"]
        ],
        [
            "info" => "Beställning lagd",
            "requestMethod" => "GET | POST",
            "path" => "cart/order",
            "callable" => ["cartController", "displayOrder"]
        ],
    ]
];
