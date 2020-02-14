<?php
include_once('vendor/autoload.php');
include_once('classes/Session.php');
include_once('config/database.php');

use web\Session;
use Medoo\Medoo;

Session::start();

$database = new Medoo($database_config);

$loader = new Twig_Loader_Filesystem("template");
$twig = new Twig_Environment($loader);
$template = $twig->load('template.html');

$lastStatus = $database->select(
  "status",
  ["text", "published_at"],
  [
    "ORDER" => [
      "published_at" => "DESC",
    ],
    "LIMIT" => 1
  ]
);

$votes = $database
  ->query("
    SELECT voted_fruit AS 'id', count(id) AS 'votes' 
    FROM fruit_voting 
    GROUP BY voted_fruit 
    ORDER BY count(id) DESC 
    LIMIT 1")
  ->fetch(PDO::FETCH_ASSOC);

$mostVotedFruit = NULL;
if($votes){
  $mostVotedFruit = $database->select(
    "fruit",
    "*",
    [
      "id" => $votes["id"],
	  "LIMIT" => 1
    ]
  );
  
  if($mostVotedFruit){
    $mostVotedFruit = $mostVotedFruit[0];
    $mostVotedFruit["votes"] = $votes["votes"];
  }
}

$latestAddedFruit = $database->select(
  "fruit",
  "*",
  [
    "ORDER" => [  
      "added_at" => "DESC"
    ],
    "LIMIT" => 1
  ]
);

if($latestAddedFruit){
  $latestAddedFruit = $latestAddedFruit[0];
}

echo $template->render([
  'title' => 'FruitShop',
  'head' => 'head_index.html',
  'content' => 'index.html',
  'loggedIn' => Session::get('loggedIn'),
  'loggedInUser' => Session::get('loggedInUser'),
  'lastStatus' => $lastStatus[0],
  'mostVotedFruit' => $mostVotedFruit,
  'latestAddedFruit' => $latestAddedFruit
]);

/*



if($lastStatus){
  $lastStatus = $lastStatus[0];
}


$votes = $database
  ->query("
    SELECT voted_fruit AS 'id', count(id) AS 'votes' 
    FROM fruit_voting 
    GROUP BY voted_fruit 
    ORDER BY count(id) DESC 
    LIMIT 1")
  ->fetch(PDO::FETCH_ASSOC);

$mostVotedFruit = NULL;
if($votes){
  $mostVotedFruit = $database->select(
    "fruit",
    "*",
    [
      "id" => $votes["id"],
	  "LIMIT" => 1
    ]
  );
  
  if($mostVotedFruit){
    $mostVotedFruit = $mostVotedFruit[0];
    $mostVotedFruit["votes"] = $votes["votes"];
  }
}

$latestAddedFruit = $database->select(
  "fruit",
  "*",
  [
    "ORDER" => [
      "added_at" => "DESC"
    ],
    "LIMIT" => 1
  ]
);

if($latestAddedFruit){
  $latestAddedFruit = $latestAddedFruit[0];
}

$loader = new Twig_Loader_Filesystem("templates");
$twig = new Twig_Environment($loader);
$template = $twig->load('index.html');

echo $template->render([
  "loggedIn" => $_SESSION["loggedIn"],
  "loggedInUser" => $_SESSION["loggedInUser"],
  "lastStatus" => $lastStatus,
  "mostVotedFruit" => $mostVotedFruit,
  "latestAddedFruit" => $latestAddedFruit
]);
*/
