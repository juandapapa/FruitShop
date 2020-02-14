<?php
// start the session
session_start();

// extract form parameters
$action = $_POST["action"];
$voted_fruit = $_POST["voted_fruit"];

$votes = null;
// check the existence of session named "votes
// if it does exist, take it and extract values from it
// when it does not, simply create a new structure.
if(isset($_SESSION["votes"])){
    $votes = $_SESSION["votes"];
} else {
    $votes = [
        "apple" => 0,
        "cherry" => 0,
        "grape" => 0,
        "strawberry" => 0
    ];
}

// increase the vote counter of a particular option
$votes[$voted_fruit]++;

// update the session
$_SESSION["votes"] = $votes;

header("Location: voting.php");
die; 
?>