<?php
include_once('vendor/autoload.php');
include_once('classes/Session.php');

use web\Session;

Session::start();

// if someone has been logged in
// redirect to the homepage
if (Session::get("loggedIn")) {
  header("Location: index.php");
  die;
}

$loader = new Twig_Loader_Filesystem("template");
$twig = new Twig_Environment($loader);
$template = $twig->load('template.html');

echo $template->render([
  'title' => 'FruitShop',
  'head' => 'head.html',
  'content' => 'register.html'
]);
