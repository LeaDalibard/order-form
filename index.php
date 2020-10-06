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


//-----------------------------------Validation message

$validationMessage = "";
if (isset ($_POST['submit'])) {
    if ($emailForm == "" && $zipcodeForm == "" && $streetnumberForm == "" && $emailErr == "" && $streetErr == "" && $streetnumberErr == "" && $cityErr == "" && $zipcodeErr == "") {
        $validationMessage = "Your order has been sent";
    }
}


//-----------------------------------Cookies

setcookie('cookie_street', $cookie_street, time() + 3600, '/', $domain, false);
setcookie('cookie_mail', $cookie_mail, time() + 3600, '/', $domain, false);
setcookie('cookie_number', $cookie_number, time() + 3600, '/', $domain, false);
setcookie('cookie_zipcode', $cookie_zipcode, time() + 3600, '/', $domain, false);
setcookie('cookie_city', $cookie_city, time() + 3600, '/', $domain, false);


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



if (isset ($_GET['food'])) {
    if ($_GET['food']==0){
        $food=0;
        $products = [
            ['name' => 'Cola', 'price' => 2],
            ['name' => 'Fanta', 'price' => 2],
            ['name' => 'Sprite', 'price' => 2],
            ['name' => 'Ice-tea', 'price' => 3],
        ];
    }
   elseif ($_GET['food']==1) {
       $food=1;
       $products = [
           ['name' => 'Club Ham', 'price' => 3.20],
           ['name' => 'Club Cheese', 'price' => 3],
           ['name' => 'Club Cheese & Ham', 'price' => 4],
           ['name' => 'Club Chicken', 'price' => 4],
           ['name' => 'Club Salmon', 'price' => 5]
       ];
   }

   }

$_SESSION['products']=$products;


//-----------------------------------Set session variable for products


$_SESSION['order'] =array();

if (isset($_POST['products'])) {
    $order=$_POST['products'];
    var_dump($order);

    $_SESSION['order']=$order;

}



//whatIsHappening();
    $totalValue = 0;


    require 'form-view.php';

// foreach($keys as $x => $val) {
//       // echo $products[$val]['price'];
//        //echo $products[$val]['name'];
//        //
//        $row = array();
//        $row['price']=$products[$val]['price'];
//        $row['name']=$products[$val]['name'];
//        $order[] = $row;
//
//       // array_push( $order,$products[$val]['name'],$products[$val]['price']);
//    }


//$keys = array_keys($_POST['products']);