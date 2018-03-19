<?php
/**
 * Category routes.
 */
return [
    "routes" => [
        [
            "info" => "All Category",
            "requestMethod" => "GET",
            "path" => "category",
            "callable" => ["categoryController", "getAllCategories"]
        ],
        [
            "info" => "Specific category",
            "requestMethod" => "GET",
            "path" => "category/{id:digit}",
            "callable" => ["categoryController", "getSpecificCategory"]
        ],
        [
            "info" => "Specific subcategory",
            "requestMethod" => "GET",
            "path" => "category/{id:digit}/{id:digit}/{gender:digit}",
            "callable" => ["categoryController", "getSpecificSubCategory"]
        ]
    ]
];
