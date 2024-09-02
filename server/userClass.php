<?php

Class Users {
    private $email;
    private $username;
    private $password;
    private $newsletter;
    private $terms;
    private $userID;

    //constructor
    public function __construct($email, $username, $password, $newsletter, $terms, $userID = null) {
        $this->email =  $email;
        $this->username = $username;
        $this->password = $password;
        $this->newsletter = $newsletter;
        $this->terms = $terms;
        $this->userID = $userID; // Initialize UserID
    }

    public function getUserID() {
        return $this->userID;
    }
    
    public function getUsername() {
        return $this->username;
    }
    public function setUsername($username){
        $this->username = $username;
    }
  

    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
        $this->email =  $email;
    }


    public function getPassword(){
        return $this->password;
    }
    public function setPassword($password){
        $this->password = $password;
    }


    public function getNewsletter(){
        return $this->newsletter;
    }
    public function setNewsletter($newsletter){
        $this->newsletter = $newsletter;
    }

  

    public function getTerms(){
        return $this->terms;
    }

    public function setTerms($terms){
        $this->terms = $terms;
    }

}

?>