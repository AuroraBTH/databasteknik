<?php
/**
 * Default route to create a 404, use if no else route matched.
 */
return [
    "routes" => [
        [
            "info" => "Basket handler",
            "requestMethod" => "POST",
            "path" => "ajax",
            "callable" => ["ajaxController", "addToCart"],
        ],
        [
            "info" => "Ta bort från kundvagnen",
            "requestMethod" => "POST",
            "path" => "ajax/remove",
            "callable" => ["ajaxController", "removeFromCart"]
        ],
        [
            "info" => "Ta bort allt från kundvagnen",
            "requestMethod" => "POST",
            "path" => "ajax/removeall",
            "callable" => ["ajaxController", "removeAllFromCart"]
        ],
        [
            "info" => "Ta bort produkt",
            "requestMethod" => "POST",
            "path" => "ajax/removeProduct",
            "callable" => ["ajaxController", "removeProduct"]
        ],
        [
            "info" => "Uppdatera antal av en product",
            "requestMethod" => "POST",
            "path" => "ajax/plusProduct",
            "callable" => ["ajaxController", "plusProduct"]
        ],
        [
            "info" => "Uppdatera antal av en product",
            "requestMethod" => "POST",
            "path" => "ajax/minusProduct",
            "callable" => ["ajaxController", "minusProduct"]
        ],
        [
            "info" => "Validera en kupong",
            "requestMethod" => "POST",
            "path" => "ajax/validateCoupon",
            "callable" => ["ajaxController", "validateCoupon"]
        ],
    ]
];
