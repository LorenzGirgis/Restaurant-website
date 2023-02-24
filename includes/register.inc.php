<?php
if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $repeatpassword = $_POST["repeatpassword"];
    $geboortedatum = $_POST["geboortedatum"];

    include "../database.php";
    include "../classes/register.classes.php";
    include "../classes/register-controller.classes.php";
    $register = new RegisterController($username, $firstname, $lastname, $email, $password, $repeatpassword, $geboortedatum);

    $register->registerUser();

    header("Location: ../login.php");
}
?>
