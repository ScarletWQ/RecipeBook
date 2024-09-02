<?php
include 'db.php';
include 'recipeDAO.php';
include 'recipeClass.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$recipeDAO = new RecipeDAO($conn);
$action = isset($_POST['action']) ? $_POST['action'] : ''; // Check if action is set
$userId = $_SESSION['user_id'] ?? null;

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

$recipes = [];

if ($userId) {
    // Fetch recipes based on search or filter
    if ($keyword || $category) {
        $recipes = $recipeDAO->searchRecipes($keyword, $category);
    } else {
        $recipes = $recipeDAO->getRecipesByUserId($userId);
    }

    // Handle form submissions
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'] ?? '';
        $category = $_POST['category'] ?? '';
        $ingredient = $_POST['ingredient'] ?? '';
        $instruction = $_POST['instruction'] ?? '';
        $imagePath = '';
        // handle upload image
        if (isset($_FILES["image_path"]) && $_FILES["image_path"]["error"] == UPLOAD_ERR_OK) {
            $targetDir = "uploads/";
            $uniqueFileName = uniqid() . '-' . basename($_FILES["image_path"]["name"]);
            $targetFilePath = $targetDir . $uniqueFileName;

            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            if (move_uploaded_file($_FILES["image_path"]["tmp_name"], $targetFilePath)) {
                $imagePath = $uniqueFileName;
            } else {
                $imagePath = "";
            }
        }

        if ($action == 'add') {
            $recipe = new Recipe($title, $category, $ingredient, $instruction, $imagePath, $userId);
            if ($recipeDAO->addRecipe($recipe)) {
                header("Location: recipe.php");
                exit();
            } else {
                echo "Failed to add recipe.<br>";
            }
        } elseif ($action == 'edit') {
            //$recipeId = $_POST['recipe_id'] ?? 0;
            //$recipe = new Recipe($title, $category, $ingredient, $instruction, $imagePath, $userId);
            //$recipe->setRecipeId($recipeId);
            //if ($recipeDAO->updateRecipe($recipe)) {
                header("Location: recipe.php");
                exit();
           // } else {
                echo "Failed to update recipe.<br>";
           // }
        } elseif ($action == 'delete') {
            $recipeId = $_POST['recipe_id'] ?? 0;
            if ($recipeDAO->deleteRecipe($recipeId)) {
                header("Location: recipe.php");
                exit();
            } else {
                echo "Failed to delete recipe.<br>";
            }
        }
    }

    // Display form and recipes
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/assign2.css" type="text/css">
        <title>Manage Recipes</title>
    </head>
    <body>
        <?php include 'navigation.php'; ?>

        <div class="content">
            <!-- Filter and Search Form -->
            <div class="recipe-search">
                <h2>Search Your Recipes</h2><hr>
                <form method="GET" action="recipe.php">
                    <label for="keyword">Search by Keyword:</label>
                    <input type="text" id="keyword" name="keyword" value="<?php echo htmlspecialchars($keyword); ?>">
        
                    <label for="category">Filter by Category:</label>
                    <select id="category" name="category">
                        <option value="">All Categories</option>
                        <option value="Breakfast & Brunch" <?php echo ($category == 'Breakfast & Brunch') ? 'selected' : ''; ?>>Breakfast & Brunch</option>
                        <option value="Lunch" <?php echo ($category == 'Lunch') ? 'selected' : ''; ?>>Lunch</option>
                        <option value="Appetizers & Snacks" <?php echo ($category == 'Appetizers & Snacks') ? 'selected' : ''; ?>>Appetizers & Snacks</option>
                        <option value="Salads" <?php echo ($category == 'Salads') ? 'selected' : ''; ?>>Salads</option>
                        <option value="Side Dishes" <?php echo ($category == 'Side Dishes') ? 'selected' : ''; ?>>Side Dishes</option>
                        <option value="Soups" <?php echo ($category == 'Soups') ? 'selected' : ''; ?>>Soups</option>
                        <option value="Bread" <?php echo ($category == 'Bread') ? 'selected' : ''; ?>>Bread</option>
                        <option value="Drinks" <?php echo ($category == 'Drinks') ? 'selected' : ''; ?>>Drinks</option>
                        <option value="Desserts" <?php echo ($category == 'Desserts') ? 'selected' : ''; ?>>Desserts</option>
                    </select>

                    <p><button type="submit">Search</button></p>
                </form>
            </div>
            <div class="recipe-list">
                <h2>Your Recipes</h2>
                <ul >
                    <?php foreach ($recipes as $recipe): ?>
                        <li class="recipe-item">
                            <h3><?php echo htmlspecialchars($recipe->getTitle()); ?></h3>
                            <?php if ($recipe->getImagePath()): ?>
                                <img src="uploads/<?php echo htmlspecialchars($recipe->getImagePath()); ?>" alt="Recipe Image" width="100">
                            <p>Category: <?php echo htmlspecialchars($recipe->getCategory()); ?></p>
                            <p>Ingredients: </p>
                            <p><?php echo nl2br(htmlspecialchars($recipe->getIngredient())); ?></p>
                            <p>Instructions: <?php echo nl2br(htmlspecialchars($recipe->getInstruction())); ?></p>
                           
                            <?php endif; ?>
                            <div class="button-container">
                                <form method="GET" action="recipeEdit.php" class="inline-form">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($recipe->getRecipeId()); ?>">
                                    <button class="edit-button" type="submit">Edit</button>
                                </form>
                                <form method="POST" action="recipe.php" class="inline-form">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="recipe_id" value="<?php echo htmlspecialchars($recipe->getRecipeId()); ?>">
                                    <button class="delete-button" type="submit" onclick="return confirm('Are you sure you want to delete this recipe?');">Delete</button>
                                </form>
                            </div>
                            
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="recipe-form">
                <h2><?php echo $action == 'edit' ? 'Edit Recipe' : 'Add New Recipe'; ?></h2>
                <hr>
                <form method="POST" action="recipe.php" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="<?php echo $action == 'edit' ? 'edit' : 'add'; ?>">
                    <?php if ($action == 'edit' && isset($recipeData)): ?>
                        <input type="hidden" name="recipe_id" value="<?php echo htmlspecialchars($recipeData->getRecipeId()); ?>">
                        <label for="title">Title:</label>
                        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($recipeData->getTitle()); ?>" required>

                        <label for="category">Category:</label>
                        <select id="category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="Breakfast & Brunch" <?php echo ($recipeData->getCategory() == 'Breakfast & Brunch') ? 'selected' : ''; ?>>Breakfast & Brunch</option>
                            <option value="Lunch" <?php echo ($recipeData->getCategory() == 'Lunch') ? 'selected' : ''; ?>>Lunch</option>
                            <option value="Appetizers & Snacks" <?php echo ($recipeData->getCategory() == 'Appetizers & Snacks') ? 'selected' : ''; ?>>Appetizers & Snacks</option>
                            <option value="Salads" <?php echo ($recipeData->getCategory() == 'Salads') ? 'selected' : ''; ?>>Salads</option>
                            <option value="Side Dishes" <?php echo ($recipeData->getCategory() == 'Side Dishes') ? 'selected' : ''; ?>>Side Dishes</option>
                            <option value="Soups" <?php echo ($recipeData->getCategory() == 'Soups') ? 'selected' : ''; ?>>Soups</option>
                            <option value="Bread" <?php echo ($recipeData->getCategory() == 'Bread') ? 'selected' : ''; ?>>Bread</option>
                            <option value="Drinks" <?php echo ($recipeData->getCategory() == 'Drinks') ? 'selected' : ''; ?>>Drinks</option>
                            <option value="Desserts" <?php echo ($recipeData->getCategory() == 'Desserts') ? 'selected' : ''; ?>>Desserts</option>
                        </select>

                        <label for="ingredient">Ingredients:</label>
                        <textarea id="ingredient" name="ingredient" required><?php echo htmlspecialchars($recipeData->getIngredient()); ?></textarea>

                        <label for="instruction">Instructions:</label>
                        <textarea id="instruction" name="instruction" required><?php echo htmlspecialchars($recipeData->getInstruction()); ?></textarea>

                        <label for="image_path">Image:</label>
                        <input type="file" id="image_path" name="image_path">
                        <?php if ($recipeData->getImagePath()): ?>
                            <p>Current Image: <?php echo htmlspecialchars($recipeData->getImagePath()); ?></p>
                        <?php endif; ?>
                    <?php else: ?>
                        <label for="title">Title:</label>
                        <input type="text" id="title" name="title" required>

                        <label for="category">Category:</label>
                        <select id="category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="Breakfast & Brunch">Breakfast & Brunch</option>
                            <option value="Lunch">Lunch</option>
                            <option value="Appetizers & Snacks">Appetizers & Snacks</option>
                            <option value="Salads">Salads</option>
                            <option value="Side Dishes">Side Dishes</option>
                            <option value="Soups">Soups</option>
                            <option value="Bread">Bread</option>
                            <option value="Drinks">Drinks</option>
                            <option value="Desserts">Desserts</option>
                        </select>

                        <label for="ingredient">Ingredients:</label>
                        <textarea id="ingredient" name="ingredient" required></textarea>

                        <label for="instruction">Instructions:</label>
                        <textarea id="instruction" name="instruction" required></textarea>

                        <label for="image_path">Image:</label>
                        <input type="file" id="image_path" name="image_path">
                    <?php endif; ?>
                    <br><br>
                    <button type="submit"><?php echo $action == 'edit' ? 'Update Recipe' : 'Add Recipe'; ?></button>
                </form>
            </div>
        </div>
    </body>
    </html>
    <?php
} else {
    header('Location: login.php');
    exit();
}
?>
