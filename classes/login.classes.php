<?php

class Login extends DB {

    protected function getUser($email, $password) {
        $stmt = $this->connect()->prepare("SELECT password FROM users WHERE email = ? OR email = ?");

        if (!$stmt->execute(array($email, $password))) {
            $stmt = null;
            header("Location: ../index.php?error=sqlerror");
            exit();
        }

        if ($stmt->rowCount() == 0) {
            $stmt = null;
            session_start();
            $_SESSION["accountnotfound"] = "Account not found!";
            header("Location: ../login.php?error=accountnotfound");
            exit();
        }

        $hashedPassword = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $checkPassword = password_verify($password, $hashedPassword[0]['password']);

        if ($checkPassword == false) {
            $stmt = null;
            session_start();
            $_SESSION["wrongpassword"] = "Wrong Password!";
            header("Location: ../login.php?error=wrongpassword");
            exit();
        } else if ($checkPassword == true) {
            $stmt = $this->connect()->prepare("SELECT * FROM users WHERE email = ? OR email = ? AND password = ?");

            if (!$stmt->execute(array($email, $email, $password))) {
                $stmt = null;
                header("Location: ../index.php?error=sqlerror");
                exit();
            }

            if ($stmt->rowCount() == 0) {
                $stmt = null;
                header("Location: ../index.php?error=accountnotfound");
                exit();
            }

            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

            session_start();
            $_SESSION['userid'] = $user[0]['id'];
            $_SESSION['email'] = $user[0]['email'];
            $_SESSION['username'] = $user[0]['username'];
            $_SESSION['password'] = $user[0]['password'];

            $stmt = null;
        }

        $stmt = null;
    }

}

?>