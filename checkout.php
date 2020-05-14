<?php
include('lib/common.php');
include('lib/show_queries.php');
include('lib/error.php');

define('DB_HOST', "localhost");
define('DB_PORT', "3307");
define('DB_USER', "web");
define('DB_PASS', "web317");
define('DB_SCHEMA', "gy2020");

function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
        ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

console_log($_SESSION['Username']);


include('checkout.html');