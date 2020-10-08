<?php

//this line makes PHP behave in a more strict way
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

//we are going to use session variables so we need to enable sessions
session_start();
//require 'ooptrying.php';


//-----------------------------------Cookie setting

$cookie_mail = "";
$cookie_street = "";
$cookie_number = "";
$cookie_city = "";
$cookie_zipcode = "";


$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;

if (isset($_COOKIE['cookie_mail'])) {
    $cookie_mail = $_COOKIE['cookie_mail'];
}
if (isset($_COOKIE['cookie_street'])) {
    $cookie_street = $_COOKIE['cookie_street'];
}
if (isset($_COOKIE['cookie_number'])) {
    $cookie_number = $_COOKIE['cookie_number'];
}
if (isset($_COOKIE['cookie_city'])) {
    $cookie_city = $_COOKIE['cookie_city'];
}
if (isset($_COOKIE['cookie_zipcode'])) {
    $cookie_zipcode = $_COOKIE['cookie_zipcode'];
}
if (isset($_COOKIE['$cookie_total'])) {
    $cookie_total = $_COOKIE['$cookie_total'];
} else {
    $cookie_total = '';
}

//-----------------------------------Required fields

$emailErr = $streetErr = $streetnumberErr = $cityErr = $zipcodeErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $cookie_mail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $emailErr = "";
    }

    if (empty($_POST['street'])) {
        $streetErr = "Street is required";
    } else {
        $cookie_street = $_POST['street'];
        $streetErr = "";
    }
    if (empty($_POST['streetnumber'])) {
        $streetnumberErr = "Street number is required";
    } else {
        $cookie_number = $_POST['streetnumber'];
        $streetnumberErr = "";
    }
    if (empty($_POST['city'])) {
        $cityErr = "City is required";
    } else {
        $cookie_city = $_POST['city'];
        $cityErr = "";
    }
    if (empty($_POST['zipcode'])) {
        $zipcodeErr = "Zipcode is required";
    } else {
        $cookie_zipcode = $_POST['zipcode'];
        $zipcodeErr = "";
    }

}

//-----------------------------------Checking if the format is good
$emailForm = $zipcodeForm = $streetnumberForm = "";
if (!filter_var($cookie_mail, FILTER_VALIDATE_EMAIL) && !empty($_POST["email"])) {
    $emailForm = "Email is not a valid email address";
} else {
    $emailForm = "";
}

if (isset($_POST['zipcode'])) {
    if (!is_numeric($_POST['zipcode']) && !empty($_POST['zipcode'])) {
        $zipcodeForm = "Zipcode should be a numeric value";
    } else {
        $zipcodeForm = "";
    }
}

if (isset($_POST['streetnumber'])) {
    if (!is_numeric($_POST['streetnumber']) && !empty($_POST['streetnumber'])) {
        $streetnumberForm = "Street number should be a numeric value";
    } else {
        $streetnumberForm = "";
    }
}


//-----------------------------------Delivery Time

date_default_timezone_set('Europe/Paris');
$minutes = date("i");
$hours = date("H");


if (isset($_POST['express_delivery'])) {
    $deliveryTime = '45 minutes';
    $minutes_delivery = 45;
    if ($minutes + $minutes_delivery < 60) {
        $minutes_delivered = $minutes + $minutes_delivery;
        $hours_delivered = $hours;
    } else {
        $minutes_delivered = $minutes_delivery - (60 - $minutes);
        $hours_delivered = $hours + 1;

    }

} else {
    $deliveryTime = '2 hours';
    $delivery = 2;
    $hours_delivered = $hours + 2;
    $minutes_delivered = $minutes;
}


//---------------------------- whatIsHappening

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


//---------------------------- your products with their price.


//_________________________ Create class
class Product {
    // Properties
    public $name;
    public $price;

    // Methods

    function __construct($name, $price) {
        $this->name = $name;
        $this->price = $price;
    }

    function get_name() {
        return $this->name;
    }

    function get_price() {
        return $this->price;
    }

}

//printIterable($name);

//_________________________ Create objects


//________________Sandwiches

$Club_Ham= new Product('Club Ham',3.20);
$Club_Cheese= new Product('Club Cheese',3);
$Club_Cheese_Ham= new Product('Club Cheese & Ham',4);
$Club_Chicken= new Product('Club Chicken',4);
$Club_Salmon= new Product('Club Salmon',5);

//________________Drinks

$Cola= new Product('Cola',2);
$Fanta= new Product('Fanta',2);
$Sprite= new Product('Sprite',2);
$Ice_tea= new Product('Ice-tea',3);

//_________________________ Making array of objects
$sandwich=array();
array_push($sandwich,$Club_Ham,$Club_Cheese,$Club_Cheese_Ham,$Club_Chicken,$Club_Salmon);
$drink=array();
array_push($drink,$Cola,$Fanta,$Sprite,$Ice_tea);


$products =$sandwich;
//
if (isset ($_GET['food'])){
    if ($_GET['food'] == 0){
        $products =$drink;
    }
elseif ($_GET['food'] == 1){
    $products =$sandwich;
}
}

$_SESSION['products'] = $products;

//-----------------------------------Set session variable for products
var_dump($products);
var_dump($products[0]);

if (isset($_SESSION['order'])) {
    $_SESSION['order'] = $_SESSION['order'];
} else {
    $_SESSION['order'] = array();
}

if (isset($_POST['Club Ham'])){
    echo "test2";
}




//-----------------------------------Define owner of the restaurant mail

define("restaurant_mail", "leadalibard@gmail.com");

//-----------------------------------Validation message
$alert_empty = "";
$validationMessage = "";
if (isset ($_POST['submit'])) {
        if ($emailForm == "" && $zipcodeForm == "" && $streetnumberForm == "" && $emailErr == "" && $streetErr == "" && $streetnumberErr == "" && $cityErr == "" && $zipcodeErr == "") {
            $validationMessage = "Your order has been sent. Your command will arrive at : ";
            //mail('leadalibard@gmail.com', 'test', 'test');
            session_unset();
    } else {
        $alert_empty = '<div class="alert alert-danger" role="alert">
           Your order is empty!
</div>';
    }
}



//-----------------------------------Cookies
$totalValue = $cookie_total;

setcookie('cookie_street', $cookie_street, time() + 3600, '/', $domain, false);
setcookie('cookie_mail', $cookie_mail, time() + 3600, '/', $domain, false);
setcookie('cookie_number', $cookie_number, time() + 3600, '/', $domain, false);
setcookie('cookie_zipcode', $cookie_zipcode, time() + 3600, '/', $domain, false);
setcookie('cookie_city', $cookie_city, time() + 3600, '/', $domain, false);
setcookie('cookie_total', $cookie_total, time() + 3600, '/', $domain, false);


require 'form-view-oop.php';






