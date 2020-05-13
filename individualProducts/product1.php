<?php
include('../lib/common.php');
include('../lib/show_queries.php');
include('../lib/error.php');

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
include('lib/show_queries.php');

if (array_key_exists('submitButton', $_POST)) {
    addToCart(1);
}

function addToCart($productId) {
    $db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_SCHEMA, DB_PORT);

    $query = "select * from cart where Username = ". "'" . $_SESSION['Username'] ."' and ProductID = " . $productId;
    $result = mysqli_query($db, $query);
    $count = mysqli_num_rows($result);
    $cartRow = mysqli_fetch_array($result, MYSQLI_ASSOC);
    console_log($cartRow);

    $query2 = "select * from product where ProductID = " . $productId;
    $product = mysqli_query($db, $query2);
    $productRow = mysqli_fetch_array($product, MYSQLI_ASSOC);
    console_log($productRow);

    if (empty($product)) {
        console_log("ERROR product not found");
    } else {
        console_log("Found product");
    }

    if (!empty($result) && ($count > 0)) {
        console_log("Found Cart");
        console_log($cartRow);
        $updateQuery = "update cart set Amount = Amount+1 where Username = " . "'" . $_SESSION['Username'] ."'" . " and ProductID = " . $productId;
        $res = mysqli_query($db, $updateQuery);
        console_log("Update res:");
        console_log($res);

    } else {
        console_log("Must Create Cart");
        if (!empty($_SESSION)) {
            console_log("Found Session");
            $query = 'insert into cart value (' . "'" . $_SESSION['Username'] ."'" . ',' . $productRow['ProductID'] . ',' . "'" . strval($productRow['Name']). "'" . ',' .'1' .')';
            $res = mysqli_query($db, $query);
            console_log($query);
            console_log($res);
        }
    }
}

include("product1.html");

?>