<?php
// start the session


session_start();

$user = $_SESSION["user"] ?? null; 
  
  $votes = null;
  if (isset($_SESSION["votes"])) {
    $votes = $_SESSION["votes"];
  } else {
    $votes = [
      "apple" => 0,
      "cherry" => 0,
      "grape" => 0,
      "strawberry" => 0
    ];
  }
  ?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Wiro Sableng</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a class="navbar-brand" href="#">FruitShop</a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="shop.php">Shop</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="status.php">Status</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="testimonial.php">Testimonials</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="voting.php">Fruit Voting</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="almanac.php">Fruit Almanac</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="register.php">Register</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="login.php">Login</a>
            </li>
        </ul>
    </nav>
    <div class="container" style="margin-top:20px">
        <div class="row">
            <div class="col-md-3"><img class="rounded-circle w-50 mx-auto d-block" src="images/wiro.jpg"> </div>
            <div class="col-md-9">
                <h1>Fruit Voting</h1>
                <h3>According to you, which one of the following fruit is the best?</h3>
            </div>
        </div>
    </div>
    <div class="container" style="margin-top:20px">
        <div class="card-group">
            <div class="card bg-primary">
                <div class="card-body text-center">
                    <h4 class="card-title">Apple</h4>
                    <img class="rounded-circle w-50 mx-auto d-block card-img-top" src="images/apple.jpg">
                    <p class="card-text font-weight-bold"><?= $votes["apple"]?> votes</p>
                    <form action="vote.php" method="post">
                        <input type="hidden" name="voted_fruit" value="apple">
                        <input type="hidden" name="action" value="vote">
                        <p><input type="submit" value="Vote" class="btn btn-sm btn-light"></p>
                    </form>
                </div>
            </div>
            <div class="card bg-success">
                <div class="card-body text-center">
                    <h4 class="card-title">Cherry</h4>
                    <img class="rounded-circle w-50 mx-auto d-block card-img-top" src="images/cherry.jpg">
                    <p class="card-text font-weight-bold"><?= $votes["cherry"]?> votes</p>
                    <form action="vote.php" method="post">
                        <input type="hidden" name="voted_fruit" value="cherry">
                        <input type="hidden" name="action" value="vote">
                        <p><input type="submit" value="Vote" class="btn btn-sm btn-light"></p>
                    </form>
                </div>
            </div>
            <div class="card bg-warning">
                <div class="card-body text-center">
                    <h4 class="card-title">Grape</h4>
                    <img class="rounded-circle w-50 mx-auto d-block card-img-top" src="images/grape.jpg">
                    <p class="card-text font-weight-bold"><?= $votes["grape"]?> votes</p>
                    <form action="vote.php" method="post">
                        <input type="hidden" name="voted_fruit" value="grape">
                        <input type="hidden" name="action" value="vote">
                        <p><input type="submit" value="Vote" class="btn btn-sm btn-light"></p>
                    </form>
                </div>
            </div>
            <div class="card bg-danger">
                <div class="card-body text-center">
                    <h4 class="card-title">Strawberry</h4>
                    <img class="rounded-circle w-50 mx-auto d-block card-img-top" src="images/strawberry.jpg">
                    <p class="card-text font-weight-bold"><?= $votes["strawberry"]?>votes</p>
                    <form action="vote.php" method="post">
                        <input type="hidden" name="voted_fruit" value="strawberry">
                        <input type="hidden" name="action" value="vote">
                        <p><input type="submit" value="Vote" class="btn btn-sm btn-light"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>