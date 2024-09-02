<?php


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "recipe_book";

$conn = new mysqli($servername, $username, $password, $dbname);

//check connection
if ($conn->connect_error){
    die("Connection failed:" .$conn->connect_error);
    
}
echo "Connected successfully";
?>