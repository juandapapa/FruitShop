<?php 
include_once("vendor/autoload.php");
include_once("classes/Session.php");
include_once("config/database.php");
include_once("classes/Security.php");


use web\Session;
use Medoo\Medoo;
use web\Security;

Session::start();
$database = new Medoo($database_config);
$loader = new Twig_Loader_Filesystem("template");
$twig = new Twig_Environment($loader);
$template = $twig->load("template.html");
    
$fruits = $database->select(
        "fruit",
        ["name", "latin", "color"],
        [
            "ORDER" => [
                "added_at" => "ASC"
            ]
        ]
);

echo $template->render([
    'title' => 'Almanac',
    'head' => 'head_index.html',
    'content' => 'almanac.html',
    'loggedId' => Session::get('loggedIn'),
    'loggedInUser' => Session::get('loggedInUser'),
    'fruits' => $fruits

    ]);



