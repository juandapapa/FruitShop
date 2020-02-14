<?php
include_once('vendor/autoload.php');
include_once('classes/Session.php');
include_once('config/database.php');
include_once('classes/Security.php');
use web\Session;
use Medoo\Medoo;
use web\Security;
Session::start();
$database = new Medoo($database_config);
$nextPage = "index.php";
if (!$_SESSION["loggedIn"]) {
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
if ($_POST["cancel"]) {
    unset($_SESSION["cart"]);
    $cart = [];
}
if ($_POST["pay"]) {
    foreach ($fruits as $k => $v) {
        $fruits[$k]["qty"] = $cart[$v["id"]];
        if ($fruits[$k]["qty"] <= $fruits[$k]["stock"]) {
            $fruits[$k]["ready"] = $fruits[$k]["qty"];
        } else if ($fruits[$k]["stock"] == 0) {
            $fruits[$k]["ready"] = 0;
        } else if ($fruits[$k]["qty"] > $fruits[$k]["stock"]) {
            $fruits[$k]["ready"] = $fruits[$k]["stock"];
        }
        $fruits[$k]["ready_str"] = "{$fruits[$k]["ready"]} of {$fruits[$k]["qty"]}";
        $fruits[$k]["total_price"] = $fruits[$k]["price"] * $fruits[$k]["ready"];
        $summary["qty"] += $fruits[$k]["qty"];
        $summary["price"] += $fruits[$k]["total_price"];
    }
    if ($summary["qty"] && $summary["price"]) {
        $purchasing = [
            "id" => Security::random(64),
            "buyer" => $_SESSION["loggedInUser"]["email"],
            "total" => $summary["price"],
            "issued_at" => date("Y-m-d H:i:s"),
            "payed_at" => date("Y-m-d H:i:s")
        ];
        $database->insert("purchasing", $purchasing);
        foreach ($fruits as $fruit) {
            $purchasingDetail = [
                "purchasing" => $purchasing["id"],
                "fruit" => $fruit["id"],
                "amount" => $fruit["ready"],
                "price" => $fruit["total_price"],
                "placed_at" => date("Y-m-d H:i:s")
            ];
            $database->insert("purchasing_detail", $purchasingDetail);
            $database->update(
                "fruit",
                [
                    "stock" => $fruit["stock"] - $fruit["ready"]
                ],
                ["id" => $fruit["id"]]
            );
        }
        unset($_SESSION["cart"][$fruit["id"]]);
    }
    unset($_SESSION["cart"]);
    $cart = [];
}
header("Location: {$nextPage}");
exit;