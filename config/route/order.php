<?php
/**
 * Category routes.
 */
return [
    "routes" => [
        [
            "info" => "Beställningar",
            "requestMethod" => "GET",
            "path" => "orders",
            "callable" => ["orderController", "getOrderPage"]
        ],
        [
            "info" => "Beställningar",
            "requestMethod" => "GET",
            "path" => "order/{id:digit}",
            "callable" => ["orderController", "getSingleOrder"]
        ]
    ]
];
