<?php
session_start();
include '../server/db.php'; // db connection

$username = $password = $email = "";
$receive_newsletter = $agree_terms = 0;
$usernameErr = $passwordErr = $emailErr = "";

// Function to remove blank, slashes, and protect data security
function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Server-side validation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["login"])) {
        $usernameErr = "Username is required";
    } else {
        $username = test_input($_POST["login"]);  
    }

    if (empty($_POST["pass"])) {
        $passwordErr = "Password is required";
    } else {
        $password = test_input($_POST["pass"]);
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else { 
        $email = test_input($_POST["email"]);
    }

    if (isset($_POST["newsletter"]) && $_POST["newsletter"] == 1) {
        $receive_newsletter = 1;
    } 

    if (isset($_POST["terms"]) && $_POST["terms"] == 1) {
        $agree_terms = 1;
    }
}
?>
