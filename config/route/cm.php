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
            "info" => "Management",
            "requestMethod" => "GET",
            "path" => "management/mostbought",
            "callable" => ["managementController", "displaySettingsMostBought"],
        ],
    ]
];
