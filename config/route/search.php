<?php
/**
 * Category routes.
 */
return [
    "routes" => [
        [
            "info" => "Beställningar",
            "requestMethod" => "GET | POST",
            "path" => "search",
            "callable" => ["searchController", "displayResult"]
        ]
    ]
];
