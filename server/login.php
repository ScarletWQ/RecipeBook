<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../server/db.php';
include '../server/userClass.php';
include '../server/userDAO.php';

$username = $password = "";
$loginErr = "";

//Function to sanitize input
function test_input($data){
    return htmlspecialchars(stripslashes(trim($data)));
}


if($_SERVER['REQUEST_METHOD']=='POST'){
    $username = test_input($_POST['uname']);
    $password = test_input($_POST['psw']);

$userDAO = new UserDAO($conn);
$user = $userDAO->validateUser($username, $password);

if ($user) {
    session_start();
    $_SESSION['user'] = $user->getUsername();
    $_SESSION['user_id'] = $user->getUserID();
    $_SESSION['username'] = $user->getUsername();
    $_SESSION['email'] = $user->getEmail();
    
    header('Location: ../server/recipe.php');
    exit();
} else {
    $loginErr = "Invalid username or password.";
}

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Wenqian Zhu">
    <link rel="stylesheet" href="../css/assign2.css" type="text/css">
    <title>Login</title>
</head>
<body>
<?php include '../server/navigation.php'; ?>
    <main>
        <div class="formcontainer">
            <h1>Login Form</h1>
            <hr>
            <form action="../server/login.php" method="post">
                <label for="uname">Username</label>
                <input type="text" id="uname" placeholder="Enter Username" name="uname" required>
                <label for="psw">Password</label>
                <input type="password" id="psw" placeholder="Enter Password" name="psw" required>
                <button type="submit">Login</button>
                <button type="reset">Reset</button>
                <?php if (!empty($loginErr)) { echo "<p style='color:red;'>$loginErr</p>"; } ?>

            </form>
        </div>
    </main>

    <footer>
        <p>Recipe Book, 2024 Copyright</p>
    </footer> 
 
</body>
</html>


