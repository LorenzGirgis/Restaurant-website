<?php
class DB {

    protected function connect() {
          $server = "localhost";
          $username = "root"; // bit_academy
          $password = ""; // bit_academy
          $dbname = "restaurant";
          
          try {
               $conn = new PDO(
                    "mysql:host=$server; dbname=$dbname",
                    "$username", "$password"
               );
               
               $conn->setAttribute(
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
               );
               return $conn;
          }
          catch(PDOException $e) {
               die('Unable to connect with the database');
          }
          
     }

    public function getDetail() {
     $stmt = $this->connect()->prepare("SELECT * FROM products WHERE id = :id");
     $stmt->bindParam(":id", $_GET["id"]);
     $stmt->execute();
     return $stmt;
    }

    public function getProduct() {
     $stmt = $this->connect()->prepare("SELECT a.*, b.* 
     from product_categorie as c 
     inner join  products as a on a.id = c.product_id
     inner join categorie as b on b.cid = c.categorie_id
     order by c.id");
     $stmt->execute();
     
     return $stmt;
    }

public function getRegistered() {
     $stmt = $this->connect()->prepare('SELECT COUNT(`username`) FROM `users` LIMIT 3 OFFSET 0');
     $stmt->execute();
     return $stmt;
}
public function getKlanten() {
     $stmt = $this->connect()->prepare('SELECT * FROM `users` ORDER BY `id` DESC LIMIT 3 OFFSET 0');
     $stmt->execute();
     return $stmt;
}

public function profiel() {
     $stmt = $this->connect()->prepare('SELECT * FROM `users` WHERE `username` = :username');
     $stmt->bindParam(":username", $_SESSION["username"]);
     $stmt->execute();
     return $stmt;
}
public function GetKlantenDetail() {
     $stmt = $this->connect()->prepare("SELECT * FROM users WHERE id = :id");
     $stmt->bindParam(":id", $_GET["id"]);
     $stmt->execute();
     return $stmt;
    }

public function dashboardGetOrders() {
     $stmt = $this->connect()->prepare('SELECT * FROM `orders` ORDER BY `placed_on` DESC LIMIT 5 OFFSET 0');
     $stmt->execute();
     return $stmt;
}

public function dashboardGetUsers() {
     $stmt = $this->connect()->prepare('SELECT * FROM `users` ORDER BY `last_seen` DESC LIMIT 5 OFFSET 0');
     $stmt->execute();
     return $stmt;
}

public function dashboardGetProduct() {
     $stmt = $this->connect()->prepare("SELECT a.*, b.* 
     from product_categorie as c 
     inner join  products as a on a.id = c.product_id
     inner join categorie as b on b.cid = c.categorie_id
     order by a.quantity desc limit 5");
     $stmt->execute();
     
     return $stmt;
    }

    public function extGetOrders() {
     $stmt = $this->connect()->prepare('SELECT * FROM `orders` ORDER BY `placed_on`');
     $stmt->execute();
     return $stmt;
}

public function extGetOmzet() {
     $stmt = $this->connect()->prepare('SELECT * FROM `omzet` ORDER BY `id`');
     $stmt->execute();
     return $stmt;
}

public function extGetUsers() {
     $stmt = $this->connect()->prepare('SELECT * FROM `users` ORDER BY CAST(last_seen AS INTEGER) DESC');
     $stmt->execute();
     return $stmt;
}

public function extGetProduct() {
     $stmt = $this->connect()->prepare("SELECT a.*, b.* 
     from product_categorie as c 
     inner join  products as a on a.id = c.product_id
     inner join categorie as b on b.cid = c.categorie_id
     order by CAST(a.quantity AS INTEGER) DESC");
     $stmt->execute();
     
     return $stmt;
    }

    public function insertUpdatedPassword() {
     session_start();
     $stmt = $this->connect()->prepare("SELECT password FROM users WHERE username = :username");
     $stmt->bindParam(":username", $_SESSION['username']);
     $stmt->execute();

     $oldpassword = $_POST['oldpassword'];
     $hashedPassword = $stmt->fetchAll(PDO::FETCH_ASSOC);
     $checkPassword = password_verify("$oldpassword", $hashedPassword[0]['password']);

     if ($checkPassword == false) {
         $_SESSION["oldpassword"] = "<p class='text-red-500'>Incorrecte oude wachtwoord!</p>";
         header("Location: edit_wachtwoord.php?error=oldpassword");
     } else if ($checkPassword == true) {
         if (strlen($_POST["newpassword"]) < 8) {
             $_SESSION["passwordlength"] = "<p class='text-red-500'> Wachtwoord moet minimaal 8 karakters bevatten! </p>";
             header("Location: edit_wachtwoord.php?error=passwordlength");
         } else {
             if ($_POST["newpassword"] == $_POST["repeatpassword"]) {
                 $newpassword = $_POST['newpassword'];
                 $hashedPassword = password_hash($newpassword, PASSWORD_DEFAULT);

                 $stmt = $this->connect()->prepare("UPDATE users SET password = :password WHERE username = :username");
                 $stmt->bindParam(":password", $hashedPassword);
                 $stmt->bindParam(":username", $_SESSION['username']);
                 $stmt->execute();
                 header("Location: profiel.php?success=passwordchanged");
             } else {
                 $_SESSION["passwordmatch"] = "<p class='text-red-500'> Wachtwoorden komen niet overeen! </p>";
                 header("Location: edit_wachtwoord.php?error=passwordmatch");
             }
         }
     }

     return $stmt;
 }

}

function pdo_connect_mysql() {
     $DATABASE_HOST = 'localhost';
     $DATABASE_USER = 'root';
     $DATABASE_PASS = '';
     $DATABASE_NAME = 'restaurant';
     try {
          return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
     } catch (PDOException $exception) {
          exit('Failed to connect to database!');
     }
 }

 
?>
