<?php
/**
 * Category routes.
 */
return [
    "routes" => [
        [
            "info" => "User login",
            "requestMethod" => "GET|POST",
            "path" => "user/login",
            "callable" => ["userController", "getLoginPage"]
        ]
    ]
];
