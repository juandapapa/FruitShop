<?php
include_once('vendor/autoload.php');
include_once('classes/Session.php');
include_once('config/database.php');
use Medoo\Medoo;
use web\Session;
Session::start();
$database = new Medoo($database_config);
if (!$_SESSION["loggedIn"]) {
    // redirect to another page
    header("Location: login.php");
    exit;
}
$cart = [];
if (isset($_SESSION["cart"])) {
    $cart = $_SESSION["cart"];
}
$fruitIds = array_keys($cart);
$fruits = $database->select(
    "fruit",
    "*",
    [
        "id" => $fruitIds,
        "ORDER" => ["name" => "ASC"]
    ]
);
$summary = [
    "qty" => 0,
    "price" => 0.0
];
if (is_array($fruits)) {
    foreach ($fruits as $k => $v) {
        $fruits[$k]["qty"] = $cart[$v["id"]];
        if ($fruits[$k]["qty"] <= $fruits[$k]["stock"]) {
            $fruits[$k]["ready"] = $fruits[$k]["qty"];
        } else if ($fruits[$k]["stock"] == 0) {
            $fruits[$k]["ready"] = 0;
        } else if ($fruits[$k]["qty"] > $fruits[$k]["stock"]) {
            $fruits[$k]["ready"] = $fruits[$k]["stock"];
        }
        $fruits[$k]["ready_str"] = "{$fruits[$k]['ready']} of {$fruits[$k]['qty']}";
        $fruits[$k]["total_price"] = $fruits[$k]["price"] * $fruits[$k]["ready"];
        $summary["qty"] += $fruits[$k]["qty"];
        $summary["price"] += $fruits[$k]["total_price"];
    }
}
$loader = new Twig_Loader_Filesystem("template");
$twig = new Twig_Environment($loader);
$template = $twig->load('template.html');
echo $template->render([
    'title' => 'Testimonial',
    'head' => 'head_index.html',
    'content' => 'cart.html',
    'loggedIn' => Session::get('loggedIn'),
    'loggedInUser' => Session::get('loggedInUser'),
    "fruits" => $fruits,
    "summary" => $summary
]);
