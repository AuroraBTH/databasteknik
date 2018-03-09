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
    ]
];
