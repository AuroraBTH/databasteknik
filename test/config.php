<?php
/**
 * Sample configuration file for test configuration.
 */
/**
 * Define essential Anax paths, end with /
 */
define("ANAX_INSTALL_PATH", realpath(__DIR__ . "/.."));
define("ANAX_APP_PATH", ANAX_INSTALL_PATH);
$di = null;
/**
 * Include autoloader.
 */
require ANAX_INSTALL_PATH . "/vendor/autoload.php";
