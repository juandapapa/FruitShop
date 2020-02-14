<?php
include_once('vendor/autoload.php');
include_once('classes/Session.php');
include_once('config/database.php');
use Medoo\Medoo;
use web\Session;
Session::start();
$database = new Medoo($database_config);
$cart = [];
if (isset($_SESSION["cart"])) {
    $cart = $_SESSION["cart"];
}
$loader = new Twig_Loader_Filesystem("template");
$twig = new Twig_Environment($loader);
$template = $twig->load('template.html');
$fruits = $database->select(
    "fruit",
    "*",
    [
        "ORDER" => [
            "added_at" => "ASC"
        ]
    ]
);
foreach ($fruits as $k => $v) {
    $votes = $database->count(
        "fruit_voting",
        [
            "voted_fruit" => $v["id"]
        ]
    );
    $fruits[$k]["votes"] = $votes;
    $fruits[$k]["in_cart"] = 0;
    if (array_key_exists($v["id"], $cart)) {
        $fruits[$k]["in_cart"] = $cart[$v["id"]];
    }
}
$mostVotedFruit = $database
    ->query("
    SELECT voted_fruit AS 'id', count(id) AS 'votes'
    FROM fruit_voting
    GROUP BY voted_fruit
    ORDER BY count(id) DESC
    LIMIT 1")
    ->fetch(PDO::FETCH_ASSOC);
if ($mostVotedFruit) {
    $mostVotedFruit = $mostVotedFruit['id'];
} else {
    $mostVotedFruit = "";
}
echo $template->render([
    'title' => 'Testimonial',
    'head' => 'head_index.html',
    'content' => 'shop.html',
    'loggedIn' => Session::get('loggedIn'),
    'loggedInUser' => Session::get('loggedInUser'),
    "fruits" => $fruits,
    "mostVotedFruit" => $mostVotedFruit
]);