<?php

include '../server/db.php';
include '../server/userClass.php';
include '../server/userDAO.php';

$email = $username = $password = $password2 = "";
$newsletter = $terms = 0;
$usernameErr = $passwordErr = $emailErr = $termsErr = $generalErr = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    function test_input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    $email = test_input($_POST['email']);
    $username = test_input($_POST['login']);
    $password = test_input($_POST['pass']);
    $password2 = isset($_POST['pass2']) ? test_input($_POST['pass2']) : '';
    $newsletter = isset($_POST['newsletter']) ? 1 : 0;
    $terms = isset($_POST['terms']) ? 1 : 0;
    $errors = [];

    // Server-side validation
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = 'Invalid email format';
        $errors['emailErr'] = $emailErr;
    }

    if (empty($username)) {
        $usernameErr = 'Username is required';
        $errors['usernameErr'] = $usernameErr;
    }

    if (empty($password)) {
        $passwordErr = 'Password is required';
        $errors['passwordErr'] = $passwordErr;
    }

    if ($password !== $password2) {
        $passwordErr = 'Passwords do not match';
        $errors['passwordErr'] = $passwordErr;
    }

    if (empty($terms)) {
        $termsErr = 'You must agree to the terms';
        $errors['termsErr'] = $termsErr;
    }

    $userDAO = new UserDAO($conn);
    if ($userDAO->checkDuplicateEmail($email)) {
        $emailErr = 'Email is already taken';
        $errors['emailErr'] = $emailErr;
    }

    if ($userDAO->checkDuplicateUsername($username)) {
        $usernameErr = 'Username is already taken';
        $errors['usernameErr'] = $usernameErr;
    }

    // If no errors, proceed to registration
    if (empty($errors)) {
        $user = new Users($email, $username, $password, $newsletter, $terms);
        $result = $userDAO->addUser($user);

        if ($result) {
            header('Location: ../server/login.php'); // Redirect to login page after successful registration
            exit();
        } else {
            $generalErr = 'Error registering user.';
        }
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Wenqian Zhu">
        <link rel="stylesheet" href="../css/assign2.css" type="text/css">
        <title>Recipe</title>  
    </head>

    <body>
    <?php include '../server/navigation.php'; ?>
    <main>
        <div class="formcontainer">
            <h1>Registration Form</h1>
            <hr>
            <form action="registration.php" method="post" onsubmit="return validate();" onreset="clearError()">
                <div class="textfield">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" placeholder="Email" oninput="checkEmail()" required>
                    <span id="email-error" class="error-message"><?php echo $emailErr; ?></span>
                </div>

                <div class="textfield">
                    <label for="login">User Name</label>
                    <input type="text" name="login" id="login" placeholder="User name" oninput="validateLogin()" required>
                    <span id="username-error" class="error-message"><?php echo $usernameErr; ?></span>
                </div>

                <div class="textfield">
                    <label for="pass">Password</label>
                    <input type="password" name="pass" id="pass" placeholder="Password" oninput="validatePass()" required>
                    <span id="password-error" class="error-message"><?php echo $passwordErr; ?></span>
                </div>
            
                <div class="textfield">
                    <label for="pass2">Re-type Password</label>
                    <input type="password" name="pass2" id="pass2" placeholder="Retype Password" oninput="validatePass2()" required>
                    <span id="re-type-password-error" class="error-message"><?php echo $passwordErr; ?></span>
                </div>

                <div class="checkbox-r">
                    <input type="checkbox" name="newsletter" id="newsletter" value=1 onchange="return validateTerm()">
                    <label for="newsletter">I agree to receive Recipe Book newsletters</label>
                </div>

                <div class="checkbox-r">
                    <input type="checkbox" name="terms" id="terms" value=1 onclick="checkTerm()" required>
                    <label for="terms">I agree to the terms and conditions</label>
                    <span id="agree-term" class="error-message"><?php echo $termsErr; ?></span>
                </div>

                <button type="submit">Register</button>
                <button type="reset">Reset</button>
            </form>
            <p class="error-message"><?php echo $generalErr; ?></p>
        </div>
    </main>

    <footer>
        <p>Recipe Book, 2024 Copyright</p>
    </footer>
    <script src="../js/registration.js"></script>
    <script src="../js/script.js"></script>
</body>
</html>
