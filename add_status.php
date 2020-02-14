<?php
include_once('vendor/autoload.php');
include_once('classes/Session.php');
include_once('config/database.php');
include_once('classes/Security.php');
use web\Session;
use Medoo\Medoo;
use web\Security;
Session::start();
$database = new Medoo($database_config);
$nextPage = "status.php";
$status = [
    "id" => Security::random(64),
    "text" => $_POST["text"],
    // create a date with PHP function
    "published_at" => date("Y-m-d H:i:s")
    ];
$database->insert("status", $status);
header("Location: {$nextPage}");