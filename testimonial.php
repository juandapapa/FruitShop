<?php
include_once('vendor/autoload.php');
include_once('classes/Session.php');
include_once('config/database.php');
use Medoo\Medoo;
use web\Session;
Session::start();
$database = new Medoo($database_config);
$loader = new Twig_Loader_Filesystem("template");
$twig = new Twig_Environment($loader);
$template = $twig->load('template.html');
$testimonial = $database->select(   
    "testimony",   
    ["text", "full_name", "image"],   
    [     
        "ORDER" => [       
        "published_at" => "DESC"     
        ],
        "LIMIT" => "3"   
    ] 
);
echo $template->render([
    'title' => 'Testimonial',
    'head' => 'head_index.html',
    'content' => 'testimonial.html',
    'loggedIn' => Session::get('loggedIn'),
    'loggedInUser' => Session::get('loggedInUser'),
    "testimonial" => $testimonial
]);