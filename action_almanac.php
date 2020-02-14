<?php
include_once("vendor/autoload.php");
include_once("classes/Security.php");
include_once("classes/Session.php");
include_once("config/database.php");

use Medoo\Medoo;
use web\Session;
use web\Security;


Session::start();

$database = new Medoo($database_config);
$nextPage = "almanac.php";

$fruit = [
"name" => $_GET["name"],
"latin" => $_GET["latin"],
"color" => $_GET["color"]
];



header("Location: almanac.php");

?>