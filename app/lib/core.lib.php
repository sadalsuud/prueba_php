<?php
error_reporting(E_ERROR | E_PARSE | E_WARNING);
ini_set("session.cookie_lifetime", "12600");
ini_set("session.gc_maxlifetime", "12600");

if (preg_match("/core.lib.php/", $_SERVER["PHP_SELF"]) || preg_match("/core.lib.php/", $_SERVER["PHP_SELF"])) {
    die("Access denied!");
}

$ini_request = microtime(true);

/* Variables de Configuracion del Sistema */
require_once dirname(__FILE__) . "/config_var.php";

require_once APPROOT . "lib/rewrite_globals.php";
require_once APPROOT . "lib/common/general_functions.php";
require_once APPROOT . "lib/class/autoloader.class.php";
require_once APPROOT . "lib/class/dbtools.class.php";

Autoloader::Register();
session_start();
