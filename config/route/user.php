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
        ],
        [
            "info" => "User create",
            "requestMethod" => "GET|POST",
            "path" => "user/create",
            "callable" => ["userController", "getCreatePage"]
        ],
        [
            "info" => "User profile",
            "requestMethod" => "GET|POST",
            "path" => "user/profile",
            "callable" => ["userController", "getProfilePage"]
        ],
        [
            "info" => "Logout",
            "requestMethod" => "get",
            "path" => "user/logout",
            "callable" => ["userController", "logout"]
        ],
        [
            "info" => "Update profile",
            "requestMethod" => "GET|POST",
            "path" => "user/profile/edit",
            "callable" => ["userController", "updateProfile"]
        ]
    ]
];
