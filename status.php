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
$statuses = $database->select(
    "status",
    ["id", "text", "published_at"],
    [
        "ORDER" => [
            "published_at" => "DESC"
        ]
    ]
);
$comments = $database->select(
    "comment",
    [
        "[>]account" => ["from" => "email"]
    ],
    ["comment.status", "comment.from", "comment.text", "comment.published_at", "account.full_name"],
    [
        "ORDER" => [
            "published_at" => "DESC"
        ]
    ]
);
echo $template->render([
    'title' => 'Status',
    'head' => 'head_index.html',
    'content' => 'status.html',
    'loggedIn' => Session::get('loggedIn'),
    'loggedInUser' => Session::get('loggedInUser'),
    "statuses" => $statuses,
    "comments" => $comments
]);