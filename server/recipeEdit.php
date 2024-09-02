<?php
session_start();
include '../server/db.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: ../server/index.php");
    exit();
}

$recipe = null;
if (isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT * FROM recipes WHERE RecipeID = ? AND UserID = ?");
    $stmt->bind_param("ii", $_GET['id'], $user_id);
    $stmt->execute();
    $recipe = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$recipe) {
        header("Location: ../server/recipe.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'] ?? '';
    $category = $_POST['category'] ?? '';
    $ingredient = $_POST['ingredient'] ?? '';
    $instruction = $_POST['instruction'] ?? '';
    $imagePath = $recipe['ImagePath'];

    if (isset($_FILES['image_path']) && $_FILES['image_path']['error'] == 0) {
        $targetDir = "../server/uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $targetFile = $targetDir . basename($_FILES["image_path"]["name"]);
        if (move_uploaded_file($_FILES["image_path"]["tmp_name"], $targetFile)) {
            $imagePath = basename($_FILES["image_path"]["name"]);
            echo "image uploaded succesfully";
        }
    }

    $stmt = $conn->prepare("UPDATE recipes SET Title = ?, Category = ?, Ingredient = ?, Instruction = ?, ImagePath = ? WHERE RecipeID = ? AND UserID = ?");
    $stmt->bind_param("ssssssi", $title, $category, $ingredient, $instruction, $imagePath, $_GET['id'], $user_id);
    
    if ($stmt->execute()) {
        echo "Database updated successfully."; // Debugging line
        header("Location: ../server/recipe.php?update=success");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/assign2.css" type="text/css">
    <title>Edit Recipe</title>
</head>
<body>
    <?php include 'navigation.php'; ?>
    <div class="content">
        <h1>Edit Recipe</h1>
        <form action="recipeEdit.php?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($recipe['Title']); ?>" required>
            
            <label for="category">Category:</label>
            <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($recipe['Category']); ?>" required>
            
            <label for="ingredient">Ingredients:</label>
            <textarea id="ingredient" name="ingredient" required><?php echo htmlspecialchars($recipe['Ingredient']); ?></textarea>
            
            <label for="instruction">Instruction:</label>
            <textarea id="instruction" name="instruction" required><?php echo htmlspecialchars($recipe['Instruction']); ?></textarea>
            
            <label for="image_path">Image Path:</label>
            <input type="file" id="image_path" name="image_path" accept="image/*">
            <?php if (!empty($recipe['ImagePath'])): ?>
                <p>Current image: <img src="../uploads/<?php echo htmlspecialchars($recipe['ImagePath']); ?>" alt="Recipe Image" width="100"></p>
            <?php endif; ?>
            
            <button type="submit">Update Recipe</button>
        </form>
    </div>
</body>
</html>
