<?php
include_once('vendor/autoload.php');
include_once('classes/Security.php');
include_once('classes/Session.php');
include_once('config/database.php');

use web\Security;
use web\Session;
use Medoo\Medoo;

Session::start();

// see config/database.php
$database = new Medoo($database_config);

// if the $_SESSION variable stores a session named "loggedIn"
// and the value of that session is TRUE, then accessing this page
// is a mistake.
// hence, move the user to another page, say index.php.
if(Session::has("loggedIn")){
  // redirect to another page
  header("Location: index.php");
  die;
}

// catch the thrown parameters.
// it was sent with an input named "email".
$email = $_POST["email"];
// it was sent with an input named "password".
$password = $_POST["password"];

// assume that the user is not authenticated.
$authenticated = false;
// define the message.
$message = null;
// what is the next page to be displayed?
$nextPage = "index.php";

// find the account in the account table.
$account = $database->select(
  "account",
  "*",
  [
    "email" => $email,
	"LIMIT" => 1
  ]
);

// if there is a record with the same email.
if($account){
    $account = $account[0];
    // verify the password.
    // if it is verified then the user is authenticated.
    $authenticated = Security::verifyPassword($password, $account["password"]);
}

// when the user is FAILED to authenticate.
if(!$authenticated){
  // set the message.
  $message = "Incorrect credential.";
  // let the user to retry by reopening the login page.
  $nextPage = "login.php";
} else {
  // when the uset is authenticated, 
  // update the session named "loggedId" with TRUE.
  // the default value of this session is FALSE, 
  // see php/config/session.php.
  unset($account["password"]);
  Session::set("loggedIn", true);
  Session::set("loggedInUser", $account);
}

// redirect to another page
header("Location: $nextPage");
die;
