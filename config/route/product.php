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
        ],
        [
            "info" => "Under 500kr",
            "requestMethod" => "GET",
            "path" => "products/under500Female",
            "callable" => ["productController", "getAllProductsUnder500Female"]
        ],
        [
            "info" => "Under 500kr",
            "requestMethod" => "GET",
            "path" => "products/under500Male",
            "callable" => ["productController", "getAllProductsUnder500Male"]
        ]
    ]
];
