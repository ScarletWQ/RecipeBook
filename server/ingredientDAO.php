class IngredientDAO {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addIngredient($name, $quantity, $recipeId, $unit) {
        $sql = "INSERT INTO ingredients (name, quantity, recipe_id, unit) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssis", $name, $quantity, $recipeId, $unit);
        if ($stmt->execute()) {
            return true;
        } else {
            echo "<pre>Error adding ingredient: " . $stmt->error . "</pre>";
            return false;
        }
    }

    public function updateIngredient($ingredientId, $name, $quantity, $unit) {
        $sql = "UPDATE ingredients SET name=?, quantity=?, unit=? WHERE ingredient_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssii", $name, $quantity, $unit, $ingredientId);
        if ($stmt->execute()) {
            return true;
        } else {
            echo "<pre>Error updating ingredient: " . $stmt->error . "</pre>";
            return false;
        }
    }

    public function deleteIngredient($ingredientId) {
        $sql = "DELETE FROM ingredients WHERE ingredient_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $ingredientId);
        if ($stmt->execute()) {
            return true;
        } else {
            echo "<pre>Error deleting ingredient: " . $stmt->error . "</pre>";
            return false;
        }
    }

    public function getIngredientsByRecipe($recipeId) {
        $sql = "SELECT * FROM ingredients WHERE recipe_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $recipeId);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC); // Fetch as associative array
        } else {
            echo "<pre>Error fetching ingredients: " . $stmt->error . "</pre>";
            return [];
        }
    }
}
