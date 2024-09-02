<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

class Recipe {
    private $recipeID;
    private $title;
    private $category;
    private $ingredient;
    private $instruction;
    private $imagePath;
    private $userId;
 
    public function __construct($title, $category, $ingredient, $instruction, $imagePath, $userId, $recipeID = null) {
        $this->title = $title;
        $this->category = $category;
        $this->ingredient = $ingredient;
        $this->instruction = $instruction;
        $this->imagePath = $imagePath;
        $this->userId = $userId;
        $this->recipeID = $recipeID;
    }

   public function getRecipeID() {
    return $this->recipeID;
}

    public function getTitle() {
        return $this->title;
    }

    public function getCategory() {
        return $this->category;
    }

    public function getIngredient() {
        return $this->ingredient;
    }

    public function getImagePath() {
        return $this->imagePath;
    }

    public function getInstruction() {
        return $this->instruction;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setCategory($category) {
        $this->category = $category;
    }

    
    public function setIngredient($ingredient) {
        $this->ingredient = $ingredient;
    }

    public function setImagePath($imagePath) {
        $this->imagePath = $imagePath;
    }

    public function setInstruction($instruction) {
        $this->instruction = $instruction;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }
    
    public function setRecipeId($recipeId) {
        $this->recipeID = $recipeId;
    }
    
}
?>
