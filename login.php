<?php
include_once("vendor/autoload.php");
include_once('classes/Session.php');
include_once('config/database.php');

use web\Security;
use web\Session;
use Medoo\Medoo;

Session::start();

// if someone has been logged in
// redirect to the homepage
if(Session::get("loggedIn")){
    header("Location: index.php");
    die;
}

$loader = new Twig_Loader_Filesystem("template");
$twig = new Twig_Environment($loader);
$template = $twig->load('template.html');

echo $template->render([
    'title' => 'FruitShop',
    'head' => 'head.html',
    'content' => 'login.html'
    ]);
