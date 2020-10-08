<?php

echo "test oop";

//_________________________ Create class
class Product
{
    // Properties
    public $name;
    public $price;

    // Methods
    function set_name($name) {
        $this->name = $name;
    }
    function get_name() {
        return $this->name;
    }

    function set_price($price) {
        $this->price = $price;
    }
    function get_price() {
        return $this->price;
    }

}

//_________________________ Create objects


//________________Sandwiches

$Club_Ham= new Product();
$Club_Ham->set_name('Club Ham');
$Club_Ham->set_price(3.20);

$Club_Cheese= new Product();
$Club_Cheese->set_name('Club Cheese');
$Club_Cheese->set_price(3);

$Club_Cheese_Ham= new Product();
$Club_Cheese_Ham->set_name('Club Cheese & Ham');
$Club_Cheese_Ham->set_price(4);

$Club_Chicken= new Product();
$Club_Chicken->set_name('Club Chicken');
$Club_Chicken->set_price(4);

$Club_Salmon= new Product();
$Club_Salmon->set_name('Club Salmon');
$Club_Salmon->set_price(5);

//________________Drinks

$Cola= new Product();
$Cola->set_name('Cola');
$Cola->set_price(2);

$Fanta= new Product();
$Fanta->set_name('Fanta');
$Fanta->set_price(2);

$Sprite= new Product();
$Sprite->set_name('Sprite');
$Sprite->set_price(2);

$Ice_tea= new Product();
$Ice_tea->set_name('Ice-tea');
$Ice_tea->set_price(3);

