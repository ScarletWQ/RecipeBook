<?php

class UserDAO {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Method to add a new user
    public function addUser(Users $user) {
        $email = $this->conn->real_escape_string($user->getEmail());
        $username = $this->conn->real_escape_string($user->getUsername());
        $password = password_hash($this->conn->real_escape_string($user->getPassword()), PASSWORD_BCRYPT);
        $newsletter = $this->conn->real_escape_string($user->getNewsletter());
        $terms = $this->conn->real_escape_string($user->getTerms());

        $sql = "INSERT INTO users (Email, Username, Password, Newsletter, Terms)
                VALUES ('$email', '$username', '$password', '$newsletter', '$terms')";

        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function checkDuplicateEmail($email){
        $email = $this->conn->real_escape_string($email);
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $this->conn->query($sql);
        return $result->num_rows > 0;
    }

    public function checkDuplicateUsername($username){
        $username = $this->conn->real_escape_string($username);
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $this->conn->query($sql);
        return $result->num_rows >0;
    }

    public function validateUser($username, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE Username = ?");
        $stmt->bind_param('s', $username);
    
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
    
            // Debugging output
            echo "<pre>";
            print_r($user);
            echo "</pre>";
    
            // Check password before verification
            echo "Password entered: $password <br>";
            echo "Password in DB: " . $user['Password'] . "<br>";
            echo "Full hash length: " . strlen($user['Password']) . "<br>";
    
            if (password_verify($password, $user['Password'])) {
                return new Users(
                    $user['Email'],
                    $user['Username'],
                    $user['Password'],
                    $user['Newsletter'],
                    $user['Terms'],
                    $user['UserID'] // Pass UserID to the Users object
                );
            } else {
                echo "Password verification failed.";
                return false;
            }
        } else {
            echo "No user found.";
            return false;
        }
    }
}
?>