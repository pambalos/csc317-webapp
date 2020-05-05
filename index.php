<?php

session_start();
if (empty($_SESSION['Username']) ){
    header("Location: sign_in.php");
    die();
}else{
    header("Location: Cart.html");
    die();
}
?>