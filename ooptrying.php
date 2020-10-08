<?php

echo "test oop";

//_________________________ Create class
class Product
{
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



