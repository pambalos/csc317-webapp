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

$db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_SCHEMA, DB_PORT);
$query = "select * from user where Username = ". "'" . $_SESSION['Username'] ."'";
$query2 = "select * from history where Username = ". "'" . $_SESSION['Username'] ."'";
$res1 = mysqli_query($db, $query);
$res2 = mysqli_query($db, $query2);

console_log("something at least");

$user = array();
$arr2 = array();


while($r = mysqli_fetch_array($res1)) {
    $user = $r;
}

console_log($user);


?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account</title>
    <link rel="stylesheet" type="text/css" href="resources/static/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<script src="resources/js/total.js"></script>
<body>
<div class="header">
    <img id="GFC" src="resources/static/Gold_for_Code.jpg" alt="Gold For Code">
</div>
<nav class="navbar">
    <a href="index.html">Home</a>
    <a href="productspage.html">Products</a>
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
                <a href="register.php">Sign Up</a>
                <a onclick = "signout()" href="sign_in.html">Sign Out</a>
                <a href="account.html">Account</a>
            </div>
        </div>
        <a href="Cart.php"><i class="fa fa-shopping-cart"></i> Cart</a>
    </div>
</nav>

<!--sideNavBar-->
<div id="mySideNav" class="sidebar" style="height: 100%;">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="individualProducts/cpp.html"> C++ </a>
    <a href="individualProducts/javascript.html"> Javascript </a>
    <a href="individualProducts/html.html"> HTML </a>
    <a href="individualProducts/ruby.html"> Ruby </a>
    <a href="individualProducts/python.html"> Python </a>
</div>


<div class = "form-container">
    <form class="form">
        <h2 align = "center">Account Details</h2>
        <div class = "account-grid">
        <div class = "columnleft">
            <p><b>Username:</b></p>
            <p><b>Email:</b></p>
            <p><b>First Name:</b></p>
            <p><b>Last Name:</b></p>
        </div> <!--end of columnleft -->
        <div class = "columnright">
            <?php
            echo '<p>' . $user['Username'] . '</p>';
            echo '<p>' . $user['EmailAddress'] . '</p>';
            echo '<p>' . $user['FirstName'] . '</p>';
            echo '<p>' . $user['LastName'] . '</p>';

            ?>

        </div> <!--end of columnright -->
        </div>  <!-- end of grid -->
    </form>

    <?php
    echo '<div style="width: 100%; height: 80px; align-content: center"> <h3 style="color: white">Purchase History</h3> </div>';
    echo "<table style='width: 100%; background-color: black'>";
    while($row = mysqli_fetch_array($res2)) {
        console_log($row);
        echo "<tr>";
        echo "<td> <img src=\"resources/static/product".$row['ProductID'].".jpg\" style=\"width:500px;height:180px;object-fit: cover>\" </td>";
        echo "<td >" . "Item Name: ". $row['Name'] .  "</td>";
        echo "<td >" . "Amount: " . $row['Amount'] .  "</td>";
        echo "<td colspan='2'>" . "Purchase Date: " . $row['PurchaseDate'] . "</td>";
    }
    ?>
</div> <!--end of form-container-->



<!--Please copy the footer into your page.-->

</body>
</html>