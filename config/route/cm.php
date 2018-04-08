<?php
/**
 * Default route to create a 404, use if no else route matched.
 */
return [
    "routes" => [
        [
            "info" => "Management",
            "requestMethod" => "GET",
            "path" => "management",
            "callable" => ["managementController", "displaySettingsManagement"],
        ],
        [
            "info" => "Management Most Bought Product",
            "requestMethod" => "GET",
            "path" => "management/mostbought",
            "callable" => ["managementController", "displaySettingsMostBought"],
        ],
        [
            "info" => "Management Best Selling Product 1 Month",
            "requestMethod" => "GET",
            "path" => "management/bestselling",
            "callable" => ["managementController", "displaySettingsBestSelling"],
        ],
    ]
];
