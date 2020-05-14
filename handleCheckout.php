<?php
include('lib/common.php');
include('lib/show_queries.php');
include('lib/error.php');


function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
        ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

console_log("in handle checkout...");

$db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_SCHEMA, DB_PORT);
$query = "select * from cart where Username = ". "'" . $_SESSION['Username'] ."'";

if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error() . NEWLINE;
    echo "Running on: ". DB_HOST . ":". DB_PORT . '<br>' . "Username: " . DB_USER . '<br>' . "Password: " . DB_PASS . '<br>' ."Database: " . DB_SCHEMA;
    phpinfo();   //unsafe, but verbose for learning.
    exit();
}

$result = mysqli_query($db, $query);
console_log($query);
console_log($result);

while ($product = mysqli_fetch_row($result)) {
    console_log($product);
    $query = "insert into history value (" . "\"" . $_SESSION['Username'] . "\"" . "," . $product['1'] . "," . "\"" . $product['2'] . "\"" . "," . 'NOW()' . ',' . $product['3'] . ')';
    console_log($query);
    $res = mysqli_query($db, $query);
    console_log($res);
    $deleteQuery = "delete from cart where Username = " . "\"" . $_SESSION['Username'] . "\"" . " and ProductID = " . $product[1];
    console_log($deleteQuery);
    $r = mysqli_query($db, $deleteQuery);
    console_log($r);
}


header(REFRESH_TIME . 'url=About.html');

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gold For Code</title>
    <link rel="stylesheet" type="text/css" href="resources/static/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<script src="resources/js/total.js"></script>
<body>

<!--header  please copy to your page-->
<div class="header">
    <img id="GFC" src="resources/static/Gold_for_Code.jpg" alt="Gold For Code">
</div>

<!--please pay attention to the "active" page when you copy navbar to your page-->
<nav class="navbar">
    <a href="../index.html">Home</a>
    <a class="active" href="productspage.html">Products</a>
    <a href="about.html">About</a>
    <a href="faq.html">FAQ</a>
    <a href="contact_us.html">Contact US</a>

    <div class="navbar-right">
        <div class="dropdown">
            <button class="dropbtn">
                <i class="fa fa-fw fa-user"></i> Sign In <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
                <a href="sign_in.html">Sign In</a>
                <a href="register.html">Sign Up</a>
                <a href="account.php">Account</a>
            </div>
        </div>
        <a href="Cart.php"><i class="fa fa-shopping-cart"></i> Cart</a>
        </div>
    </nav>

    <div style = "text-align: center; align-content: center; width: 100%; min-height: 600px">
        <h3>Processing your purchase...<br><span>Please wait</span></h3>
    </div>

</body>
</html>