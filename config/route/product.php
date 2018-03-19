<?php
/**
 * Category routes.
 */
return [
    "routes" => [
        [
            "info" => "Specific product",
            "requestMethod" => "GET",
            "path" => "product/{id:digit}",
            "callable" => ["productController", "getSpecificProduct"]
        ],
        [
            "info" => "Products",
            "requestMethod" => "GET",
            "path" => "products/{id:digit}/{gender:digit}",
            "callable" => ["productController", "getAllProductsFromCategory"]
        ]
    ]
];
