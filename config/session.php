<?php
/**
 * Config-file for sessions.
 */

return [
    "name" => preg_replace("/[^a-z\d]/i", "", ANAX_APP_PATH),
];
