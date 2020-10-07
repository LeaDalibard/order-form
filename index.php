<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

//we are going to use session variables so we need to enable sessions
session_start();


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


$products = [
    ['name' => 'Club Ham', 'price' => 3.20],
    ['name' => 'Club Cheese', 'price' => 3],
    ['name' => 'Club Cheese & Ham', 'price' => 4],
    ['name' => 'Club Chicken', 'price' => 4],
    ['name' => 'Club Salmon', 'price' => 5]
];


if (isset ($_GET['food'])) {
    if ($_GET['food'] == 0) {
        $food = 0;
        $products = [
            ['name' => 'Cola', 'price' => 2],
            ['name' => 'Fanta', 'price' => 2],
            ['name' => 'Sprite', 'price' => 2],
            ['name' => 'Ice-tea', 'price' => 3],
        ];
    } elseif ($_GET['food'] == 1) {
        $food = 1;
        $products = [
            ['name' => 'Club Ham', 'price' => 3.20],
            ['name' => 'Club Cheese', 'price' => 3],
            ['name' => 'Club Cheese & Ham', 'price' => 4],
            ['name' => 'Club Chicken', 'price' => 4],
            ['name' => 'Club Salmon', 'price' => 5]
        ];
    }

}

$_SESSION['products'] = $products;


//-----------------------------------Set session variable for products


if (isset($_SESSION['order'])) {
    $_SESSION['order'] = $_SESSION['order'];
} else {
    $_SESSION['order'] = array();
}

if (isset($_POST['products'])) {
    $order = $_SESSION['order'];
    array_push($order, $_POST['products']);
    $_SESSION['order'] = $order;
}

var_dump($_SESSION['order']);
$orderRecap = '';
if (!empty($_SESSION['order'])) {
    $length = count($_SESSION['order']);
    for ($i = 0; $i < $length; $i++) {
        foreach ($_SESSION['order'] [$i] as $x => $x_value) {
            $orderRecap = $orderRecap . "Order : " . $x . ", Price=" . $x_value . "\n";
        }
    }
}
echo $orderRecap;
//-----------------------------------Total revenue counter

if (isset($_POST['express_delivery'])) {
    $delivery_price = 5;
} else {
    $delivery_price = 0;
}
$price = 0;

if (!empty($_SESSION['order'])) {
    foreach ($_SESSION['order'] [0] as $x => $val) {
        $price += $val;
    }
    echo $price;

}

$total_price = $price + $delivery_price;

//-----------------------------------SESSION VALUE
$_SESSION['price'] = $price;
//$total=$price+(float)$cookie_total;
if (isset($_COOKIE['cookie_total'])) {
    $total = (float)$_COOKIE['cookie_total'] + $total_price;
} else {
    $total = $total_price;
    $_COOKIE['cookie_total'] = strval($total);
}

$cookie_total = strval($total);

//-----------------------------------Define owner of the restaurant mail

define("restaurant_mail", "leadalibard@gmail.com");

//-----------------------------------Validation message
$alert_empty = "";
$validationMessage = "";
if (isset ($_POST['submit'])) {
    if (isset($_POST['products'])) {
        if ($emailForm == "" && $zipcodeForm == "" && $streetnumberForm == "" && $emailErr == "" && $streetErr == "" && $streetnumberErr == "" && $cityErr == "" && $zipcodeErr == "") {
            $validationMessage = "Your order has been sent. Your command will arrive at : " . $hours_delivered . ":" . $minutes_delivered . ".";
            $msg = "Thank your for your order.\n\nYour information :\nAdress : " . $cookie_street . ", " . $cookie_number . "\n" . $cookie_zipcode . " " . $cookie_city . "\n\nYour command :\n" . $orderRecap . "\n\nOrder price :" . $price . "€.\nExtra delivery cost :" . $delivery_price . "€." . "\n\nTotal  price :" . $total_price . "€." . "\n\nExpected delivery time :" . $hours_delivered . ":" . $minutes_delivered . ".";
            $msg = wordwrap($msg, 70);
            $email_to = $cookie_mail . ", " . constant("restaurant_mail");
            //mail( $email_to, "My delivery", $msg);
            //mail('leadalibard@gmail.com', 'test', 'test');
            $_SESSION['order'] = array();
        }
    } else {
        $alert_empty = '<div class="alert alert-danger" role="alert">
           Your order is empty!
</div>';
    }
}


//if (isset ($_POST['submit'])){
//    mail('leadalibard@gmail.com','My delivery','test2');
//}


//-----------------------------------Cookies
$totalValue = $cookie_total;

setcookie('cookie_street', $cookie_street, time() + 3600, '/', $domain, false);
setcookie('cookie_mail', $cookie_mail, time() + 3600, '/', $domain, false);
setcookie('cookie_number', $cookie_number, time() + 3600, '/', $domain, false);
setcookie('cookie_zipcode', $cookie_zipcode, time() + 3600, '/', $domain, false);
setcookie('cookie_city', $cookie_city, time() + 3600, '/', $domain, false);
setcookie('cookie_total', $cookie_total, time() + 3600, '/', $domain, false);


require 'form-view.php';



