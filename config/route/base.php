<?php
/**
 * Base routes.
 */
return [
    "routes" => [
        [
            "info" => "Home",
            "requestMethod" => "GET",
            "path" => "",
            "callable" => ["baseController", "frontpage"],
        ],
        [
            "info" => "About",
            "requestMethod" => "GET",
            "path" => "about",
            "callable" => ["baseController", "aboutpage"],
        ]
    ]
];
