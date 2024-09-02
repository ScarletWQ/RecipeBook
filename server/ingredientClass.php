<?php
class Ingredients {
    private $recipeID;
    private $name;
    private $quantity;
    private $unit;
   

    function __construct($name, $quantity, $unit, $recipeID) {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->unit = $unit;
        $this->crecipeID =  $recipeID;
    }

   // Getters and Setters
   function getName() {
    return $this->name;
}

function setName($name) {
    $this->name = $name;
}

function getQuantity() {
    return $this->quantity;
}

function setQuantity($quantity) {
    $this->quantity = $quantity;
}

function getRecipeID() {
    return $this->recipeID;
}

function setRecipeID($recipeID) {
    $this->recipeID = $recipeID;
}

function getUnit() {
    return $this->unit;
}

function setUnit($unit) {
    $this->unit = $unit;
}
}
?>