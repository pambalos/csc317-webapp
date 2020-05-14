<?php
include('lib/common.php');

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
$query = "select * from cart where Username = ". "'" . $_SESSION['Username'] ."'";
$result = mysqli_query($db, $query);
$r2 = mysqli_query($db, $query);
$count = mysqli_num_rows($result);

$query2 = "select Price from product;";
$result2 = mysqli_query($db, $query2);
$arrayofrows = array();
while($r = mysqli_fetch_array($result2)) {
    $arrayofrows = $r;
}
console_log("res2");
console_log($arrayofrows);

$totalPrice = 0;

while($r = mysqli_fetch_array($r2)) {
    $totalPrice += $r['Amount']*$arrayofrows[$r['ProductID']];
}

if (array_key_exists('checkout', $_POST)) {
    checkout();
}

if (array_key_exists('remove1', $_POST)) {
    removeProduct(1);
}

if (array_key_exists('remove2', $_POST)) {
    removeProduct(2);
}

if (array_key_exists('remove3', $_POST)) {
    removeProduct(3);
}

if (array_key_exists('remove4', $_POST)) {
    removeProduct(4);
}

if (array_key_exists('remove5', $_POST)) {
    removeProduct(5);
}

if (array_key_exists('remove6', $_POST)) {
    removeProduct(6);
}

if (array_key_exists('remove7', $_POST)) {
    removeProduct(7);
}

if (array_key_exists('remove8', $_POST)) {
    removeProduct(8);
}

if (array_key_exists('remove9', $_POST)) {
    removeProduct(9);
}

if (array_key_exists('remove10', $_POST)) {
    removeProduct(10);
}

if (array_key_exists('remove11', $_POST)) {
    removeProduct(11);
}

if (array_key_exists('remove12', $_POST)) {
    removeProduct(12);
}

function removeProduct($productID) {
    $db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_SCHEMA, DB_PORT);

    $q2 = "delete from cart where Username = '" . $_SESSION['Username'] ."' and ProductID =" . $productID;
    $res = mysqli_query($db, $q2);

    header(REFRESH_TIME . 'url=Cart.php');
}

function checkout() {
    header(REFRESH_TIME . 'url=checkout.php');
}

?>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gold For Code</title>
  <link rel="stylesheet" type="text/css" href="resources/static/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="resources/js/cart.js"></script>
</head>
<body>

  <!--header  please copy to your page-->
  <div class="header">
    <img id="GFC" src="resources/static/Gold_for_Code.jpg" alt="Gold For Code">
  </div>

  <!--please pay attention to the "active" page when you copy navbar to your page-->
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
      <a class="active" href="Cart.php"><i class="fa fa-shopping-cart"></i> Cart</a>
    </div>
  </nav>

  <!-- referenced from AMZN cart -->
  <div id="display"></div>

  <?php
    /*
  output.push("<tr>");

output.push("<td> <img src=\"resources/static/product"+key[0]+".jpg\" style=\"width:600px;height:400px;>\" </td>");//jpg
output.push("<td >" + "Item hash key: "+ makeid(8) +  "</td>")//id
output.push("<td >" + "Unit Price: "+ Number(priceChart[key[0]-1]) +  "</td>" );
output.push("<td >" + "Amount: "+ key[1] +  "</td>" )//name
output.push("<td> <button class=\"button2\" type = \"button\" onclick = \"remove(" + key[0]+ ")\"> REMOVE </button> </td>");

output.push("</tr>"); */
  ?>

    <?php
    echo "<table>";
    while ($row = mysqli_fetch_array($result)) {
        console_log($row);
        echo "<tr>";
        echo "<td> <img src=\"resources/static/product".$row['ProductID'].".jpg\" style=\"width:600px;height:400px;>\" </td>";
        echo "<td >" . "Item Name: ". $row['Name'] .  "</td>";
        echo "<td >" . "Amount: " . $row['Amount'] .  "</td>";
        echo "<td >" . "Price: " . $arrayofrows[$row['ProductID']]*$row['Amount'] .  "</td>";
        echo "<td> <form method=\"post\"> <input type=\"submit\" class=\"button2\" value='REMOVE' name='remove" . $row['ProductID'] . "'/> </form> </td>";
    }
    if ($count > 0) {
        /*
        output.push("<div class=\"form-container2\">");
        output.push("<form class=\"form\">");
        output.push("<button type=\"button\" class=\"form-button\" id = \"tocheckoutpage\" onclick=\"paynow()\">Checkout<br>Total Price: "+totalPrice +"</button>");
        output.push("</form>");
        output.push("</div>");
        */
        echo '<div class="">';
        echo '<form method="post"> <input type="submit" class="form-button" value="Checkout" name="checkout" style="background-color: #00ccff;
	color: white;
	padding: 20px;
	border: none;
	cursor: pointer;
	width: 100%;
	opacity: 0.8;
	font-size: 1.2em;
	font-style: italic;
	font-weight: bold;"/> </form>';
        //echo "<form method=\"post\"> <input type=\"submit\" class=\"form-button\" value='Total Price: " . $totalPrice . "' name='checkout'/> </form>";
        echo '</div>';
    } else {
        echo '<div>  <div class="a-column a-span8 a-span-last"> <div class="a-row sc-your-cart-is-empty"> <h2> Your cart is empty </h2>        </div>        <div class="a-row sc-shop-todays-deals-link">          <a class="a-link-normal" href="productspage.html">            Shop deals now         </a>        </div>      </div> </div>';
    }

    ?>
</body>
</html>
