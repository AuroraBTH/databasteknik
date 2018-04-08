<?php
/**
 * Configuration file for routes.
 */
return [
    // Load these routefiles in order specified and optionally mount them
    // onto a base route.
    "routeFiles" => [
        [
            // Base routes
            "mount" => null,
            "file" => __DIR__ . "/route/base.php",
        ],
        [
            "mount" => null,
            "file" => __DIR__ . "/route/admin.php",
        ],
        [
            "mount" => null,
            "file" => __DIR__ . "/route/cm.php",
        ],
        [
            "mount" => null,
            "file" => __DIR__ . "/route/ajax.php",
        ],
        [
            "mount" => null,
            "file" => __DIR__ . "/route/search.php",
        ],
        [
            "mount" => null,
            "file" => __DIR__ . "/route/order.php",
        ],
        [
            "mount" => null,
            "file" => __DIR__ . "/route/user.php",
        ],
        [
            "mount" => null,
            "file" => __DIR__ . "/route/cart.php",
        ],
        [
            "mount" => null,
            "file" => __DIR__ . "/route/category.php"
        ],
        [
            "mount" => null,
            "file" => __DIR__ . "/route/product.php"
        ],
        [
            // These are for internal error handling and exceptions
            "mount" => null,
            "file" => __DIR__ . "/route/internal.php",
        ],
        [
            // For debugging and development details on Anax
            "mount" => "debug",
            "file" => __DIR__ . "/route/debug.php",
        ],
        [
            // Keep this last since its a catch all
            "mount" => null,
            "file" => __DIR__ . "/route/404.php",
        ],
    ],

];
