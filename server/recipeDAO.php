<?php


class RecipeDAO {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addRecipe(Recipe $recipe) {
        // Escape all inputs to prevent SQL injection
        $title = $this->conn->real_escape_string($recipe->getTitle());
        $category = $this->conn->real_escape_string($recipe->getCategory());
        $ingredient = $this->conn->real_escape_string($recipe->getIngredient());
        $instruction = $this->conn->real_escape_string($recipe->getInstruction());
        $imagePath = $this->conn->real_escape_string($recipe->getImagePath());
        $userId = $this->conn->real_escape_string($recipe->getUserId());
        
        // Debugging output
        echo "Title: $title<br>";
        echo "Category: $category<br>";
        echo "Ingredient: $ingredient<br>";
        echo "Instruction: $instruction<br>";
        echo "ImagePath: $imagePath<br>";
        echo "UserId: $userId<br>";
        
        // Construct the SQL query
        $sql = "INSERT INTO recipes (Title, Category, Ingredient, Instruction, ImagePath, UserID)
                VALUES ('$title', '$category', '$ingredient', '$instruction', '$imagePath', '$userId')";
        
        // Debugging output for SQL query
        echo "SQL Query: $sql<br>";
        
        // Execute the query and check for success
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            echo "Error: " . $this->conn->error;
            return false;
        }
    }


    public function getRecipeById($recipeId) {
        $stmt = $this->conn->prepare("SELECT * FROM recipes WHERE RecipeID = ?");
        $stmt->bind_param("i", $recipeId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            return new Recipe($data['Title'], $data['Category'], $data['Ingredient'], $data['Instruction'], $data['ImagePath'], $data['UserID'], $data['RecipeID']);
        }
        return null;
    }

    public function updateRecipe(Recipe $recipe) {
        $stmt = $this->conn->prepare("UPDATE recipes SET Title = ?, Category = ?, Ingredient = ?, Instruction = ?, ImagePath = ? WHERE RecipeID = ?");
        $stmt->bind_param("sssssi", $recipe->getTitle(), $recipe->getCategory(), $recipe->getIngredient(), $recipe->getInstruction(), $recipe->getImagePath(), $recipe->getRecipeId());
        return $stmt->execute();
    }

    public function deleteRecipe($recipeId) {
        $sql = "DELETE FROM recipes WHERE RecipeID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $recipeId);
        return $stmt->execute();
    }


    public function searchRecipes($keyword, $category) {
        $sql = "SELECT * FROM recipes WHERE (Title LIKE ? OR Ingredient LIKE ? OR Instruction LIKE ?) AND Category LIKE ?";
        $stmt = $this->conn->prepare($sql);

        $likeKeyword = '%' . $keyword . '%';
        $likeCategory = '%' . $category . '%';

        $stmt->bind_param("ssss", $likeKeyword, $likeKeyword, $likeKeyword, $likeCategory);
        $stmt->execute();

        $result = $stmt->get_result();
        $recipes = [];
        while ($row = $result->fetch_assoc()) {
            $recipes[] = new Recipe(
                $row['Title'],
                $row['Category'],
                $row['Ingredient'],
                $row['Instruction'],
                $row['ImagePath'],
                $row['UserID'],
                $row['RecipeID']
            );
        }
        return $recipes;
    }

    public function filterRecipeByCategory($category) {
        $sql = "SELECT * FROM recipes WHERE Category = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $category);
        $stmt->execute();

        $result = $stmt->get_result();
        $recipes = [];
        while ($row = $result->fetch_assoc()) {
            $recipes[] = new Recipe(
                $row['Title'],
                $row['Category'],
                $row['Ingredient'],
                $row['Instruction'],
                $row['ImagePath'],
                $row['UserID'],
                $row['RecipeID']
            );
        }

        return $recipes;
    }

    public function getRecipesByUserId($userId) {
        $sql = "SELECT * FROM recipes WHERE UserID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $recipes = [];
        while ($row = $result->fetch_assoc()) {
            $recipe = new Recipe(
                $row['Title'],
                $row['Category'],
                $row['Ingredient'],
                $row['Instruction'],
                $row['ImagePath'],
                $row['UserID']
            );
            $recipe->setRecipeId($row['RecipeID']);
            $recipes[] = $recipe;
        }

        $stmt->close();
        return $recipes;
    }
}
?>