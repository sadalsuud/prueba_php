<?php
function rehtmlspecialchars($arg)
{
    $arg = str_replace("&lt;", "<", $arg);
    $arg = str_replace("&gt;", ">", $arg);
    $arg = str_replace("&quot;", "\"", $arg);
    $arg = str_replace("&amp;", "&", $arg);
    return $arg;
}

function checkValue($arg)
{
    if (is_string($arg)) {
        $arg = addslashes(stripcslashes(trim(trim($arg), ':')));
    } else {
        if ($arg != null) {
            foreach ($arg as $key => $value) {
                $arg[$key] = checkValue($value);
            }
        }
    }
    return $arg;
}

function regGlobals($array, &$target_array)
{
    reset($array);
    foreach ($array as $key => $value) {
        global ${$key};
        $value = checkValue($value);
        ${$key} = $value;
        $target_array[$key] = $value;
    }
    return true;
}

ini_set('magic_quotes_runtime', 0);
if (!defined("GLOBAL_VARS_REWRITED")) {
    define("GLOBAL_VARS_REWRITED", 1);

    $GPC = [];
    if (!empty($_GET)) {
        regGlobals($_GET, $GPC);
    }
    if (!empty($_POST)) {
        regGlobals($_POST, $GPC);
    }
    if (!empty($_COOKIE)) {
        regGlobals($_COOKIE, $GPC);
    }
    if (!empty($_SERVER)) {
        $GPC["PHP_SELF"] = $_SERVER["PHP_SELF"];
        $GPC["PURE_PHP_SELF"] = basename($_SERVER["PHP_SELF"]);
        $GPC["QUERY_STRING"] = $_SERVER["QUERY_STRING"];
        $GPC["HTTP_USER_AGENT"] = $_SERVER["HTTP_USER_AGENT"];
        $GPC["HTTP_ACCEPT_ENCODING"] = $_SERVER["HTTP_ACCEPT_ENCODING"];
    }
}
