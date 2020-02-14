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
$nextPage = "testimonial.php";
date_default_timezone_set("Asia/Bangkok");
$target_dir = "images/";
$name = $_FILES["image"]["name"];
$tmp_name = $_FILES["image"]["tmp_name"];
move_uploaded_file($tmp_name,$target_dir.$name);
    $testimoni = [
    "id" => Security::random(64),
    "text" => $_POST["text"],
    "email" => $_POST["email"],
    "full_name" => $_POST["full_name"],
    "image" => "images/".$name,
    "published_at" => date("Y-m-d H:i:s")
    ];
    $database->insert("testimony", $testimoni);
    header("Location: {$nextPage}");
    exit;
exit;