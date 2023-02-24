<?php

class RegisterController extends Register {

    private $username;
    private $firstname; 
    private $lastname;
    private $email;
    private $password;
    private $repeatpassword;
    private $geboortedatum;

    public function __construct($username, $firstname, $lastname, $email, $password, $repeatpassword, $geboortedatum) {
        $this->username = $username;
        $this ->firstname = $firstname;
        $this ->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->repeatpassword = $repeatpassword;
        $this->geboortedatum = $geboortedatum;
    }

    public function registerUser() {
        session_start();
        if ($this->emptyInput() == false) {
            header("Location: ../register.php?error=emptyinput");
            exit();
        } else if ($this->passwordLength() == false) {
            $_SESSION["passwordlength"] = "Passwords should have a minimum of 8 characters!";
            header("Location: ../register.php?error=passwordlength");
            exit();
        }else if ($this->invalidUsername() == false) {
            $_SESSION["invalidusername"] = "Username is invalid!";
            header("Location: ../register.php?error=invalidusername");
            exit();
        } else if ($this->invalidEmail() == false) {
            header("Location: ../register.php");
            exit();
        } else if ($this->passwordMatch() == false) {
            $_SESSION["passwordmatch"] = "Password must match!";
            header("Location: ../register.php?error=passwordmatch");
            exit();
        } else if ($this->checkUsername() == false) {
            $_SESSION["checkusername"] = "Username already exists!";
            header("Location: ../register.php?error=checkusername");
            exit();
        }

        $this->setUser($this->username, $this->firstname, $this->lastname, $this->email, $this->password, $this->geboortedatum);
    }

    private function emptyInput() {
        $result;
        if (empty($this->username) || empty($this->firstname) || empty($this->lastname) || empty($this->email) || empty($this->password) || empty($this->repeatpassword) || empty($this->geboortedatum)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function passwordLength() {
        $result;
        if (strlen($this->password) < 8) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function invalidUsername() {
        $result;
        if (!preg_match("/^[a-zA-Z0-9]*$/", $this->username)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function invalidEmail() {
        $result;
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function passwordMatch() {
        $result;
        if ($this->password !== $this->repeatpassword) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function checkUsername() {
        $result;
        if (!$this->checkUser($this->username, $this->email)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

}

?>
