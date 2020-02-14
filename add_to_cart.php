<?php
include_once('vendor/autoload.php');
include_once('classes/Session.php');
include_once('config/database.php');
include_once('classes/Security.php');
use web\Session;
use Medoo\Medoo;
use web\Security;
Session::start();
$cart = [];
if (isset($_SESSION["cart"])) {
    $cart = $_SESSION["cart"];
}
$addedFruit = $_POST["added_fruit"];
if (!array_key_exists($addedFruit, $cart)) {
    $cart[$addedFruit] = 0;
}
$cart[$addedFruit]++;
$_SESSION["cart"] = $cart;
// redirect to another page
header("Location: shop.php");
exit;