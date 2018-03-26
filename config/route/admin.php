<?php
/**
 * Default route to create a 404, use if no else route matched.
 */
return [
    "routes" => [
        [
            "info" => "Admin",
            "requestMethod" => "GET",
            "path" => "admin",
            "callable" => ["adminController", "displaySettingsAdmin"],
        ],
        [
            "info" => "Admin Alla Produkter",
            "requestMethod" => "GET",
            "path" => "admin/products",
            "callable" => ["adminController", "displayProductsAdmin"],
        ],
        [
            "info" => "Admin Alla användare",
            "requestMethod" => "GET",
            "path" => "admin/users",
            "callable" => ["adminController", "displayUsersAdmin"],
        ],
        [
            "info" => "Admin Alla Produkter Med Lågt Lagerantal",
            "requestMethod" => "GET",
            "path" => "admin/low",
            "callable" => ["adminController", "displayLowAdmin"],
        ],
        [
            "info" => "Admin Alla Ordrar",
            "requestMethod" => "GET",
            "path" => "admin/orders",
            "callable" => ["adminController", "displayOrdersAdmin"],
        ],
        [
            "info" => "Admin En Order",
            "requestMethod" => "GET",
            "path" => "admin/order/{id:digit}",
            "callable" => ["adminController", "displatSingleOrderAdmin"]
        ],
        [
            "info" => "Admin Köp Produkter",
            "requestMethod" => "GET",
            "path" => "admin/buy",
            "callable" => ["adminController", "displayBuyAdmin"],
        ],
        [
            "info" => "Admin Redigera Produkt",
            "requestMethod" => "GET",
            "path" => "admin/edit",
            "callable" => ["adminController", "displayEditAdmin"],
        ],
    ]
];
