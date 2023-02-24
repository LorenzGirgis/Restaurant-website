<?php

class Register extends DB {

    protected function setUser($username, $firstname, $lastname, $email, $password, $geboortedatum) {
        $stmt = $this->connect()->prepare("INSERT INTO `users` (`username`, `firstname`, `lastname`, `email`, `password`, `geboortedatum`) VALUES (:username, :firstname, :lastname, :email, :password, :geboortedatum)");

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if (!$stmt->execute(array(':username' => $username, ':firstname' => $firstname, ':lastname' => $lastname, ':email' => $email, ':password' => $hashedPassword, ':geboortedatum' => $geboortedatum))) {
            $stmt = null;
            header("Location: ../index.php?error=sqlerror");
            exit();
        }


        $stmt = null;
    }

    protected function checkUser($username, $email) {
        $stmt = $this->connect()->prepare("SELECT username FROM users WHERE username = ? OR email = ?");

        if (!$stmt->execute(array($username, $email))) {
            $stmt = null;
            header("Location: ../index.php?error=sqlerror");
            exit();
        }

        $resultCheck;
        if ($stmt->rowCount() > 0) {
            $resultCheck = false;
        } else {
            $resultCheck = true;
        }
        return $resultCheck;
    }

}

?>
