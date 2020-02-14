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
$comment = [
    "status" => $_POST["idStatus"],
    "from" => $_POST["pengirim"],
    "text" => $_POST["text"],
    "published_at" => date("Y-m-d H:i:s")
];
$database->insert("comment", $comment);
header("Location: {$nextPage}");