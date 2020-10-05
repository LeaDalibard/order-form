<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

//we are going to use session variables so we need to enable sessions
session_start();

// cookie variables to save user information

$cookie_mail = "";
$cookie_street = "";
$cookie_number = "";
$cookie_city = "";
$cookie_zipcode = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email'])) {
        $cookie_mail = $_POST['email'];
    }}

   // setcookie($cookie_mail, $cookie_street, $cookie_number, $cookie_city, $cookie_zipcode, time() + (86400 * 30), "/"); // 86400 = 1 day, will expire after 30 days

    if (filter_var($cookie_mail, FILTER_VALIDATE_EMAIL)) {
        echo("$cookie_mail is a valid email address");
    } else {
        echo("$cookie_mail is not a valid email address");
    }


    function whatIsHappening()
    {
        echo '<h2>$_GET</h2>';
        var_dump($_GET);
        echo '<h2>$_POST</h2>';
        var_dump($_POST);
        echo '<h2>$_COOKIE</h2>';
        var_dump($_COOKIE);
        echo '<h2>$_SESSION</h2>';
        var_dump($_SESSION);
    }

//your products with their price.
    $products = [
        ['name' => 'Club Ham', 'price' => 3.20],
        ['name' => 'Club Cheese', 'price' => 3],
        ['name' => 'Club Cheese & Ham', 'price' => 4],
        ['name' => 'Club Chicken', 'price' => 4],
        ['name' => 'Club Salmon', 'price' => 5]
    ];

    $products = [
        ['name' => 'Cola', 'price' => 2],
        ['name' => 'Fanta', 'price' => 2],
        ['name' => 'Sprite', 'price' => 2],
        ['name' => 'Ice-tea', 'price' => 3],
    ];

    $totalValue = 0;

    require 'form-view.php';