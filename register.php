<?php
session_start();

if (isset($_SESSION["userid"])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Register</title>
</head>

<body class="bg-gray-300">
    <div class="h-screen flex justify-center items-center w-full">
        <div class="bg-white px-14 py-16 rounded-xl w-screen shadow-md max-w-sm">
            <div class="space-y-8">
                <img class="" src="src/images/labello.png">

                <div class="space-y-3">
                    <div class="container">
                        <div class="container">
                            <form action="includes/register.inc.php" method="POST">
                                <?php
                                    $url = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
                                    if (strpos($url,"checkusername") !== false) {
                                        echo $_SESSION["checkusername"];
                                    } else if (strpos($url,"invalidusername") !== false) {
                                        echo $_SESSION["invalidusername"];
                                    } else if (strpos($url,"passwordlength") !== false) {
                                        echo $_SESSION["passwordlength"];
                                    } else if (strpos($url,"passwordmatch") !== false) {
                                        echo $_SESSION["passwordmatch"];
                                    }
                                    ?>
                        </div>

                        <input type="text" name="username" placeholder="Gebruikersnaam" required
                            class="bg-indigo-50 px-4 py-2 outline-none rounded-md w-full" />
                    </div>

                    <div class="space-y-0">
                        <input type="text" name="firstname" placeholder="Voornaam" required
                            class="bg-indigo-50 px-4 py-2 outline-none rounded-md w-full" />
                    </div>

                    <div class="space-y-0">
                    <input type="text" name="lastname" placeholder="Achternaam" required                            
                    class="bg-indigo-50 px-4 py-2 outline-none rounded-md w-full" />
                    </div>

                    <div class="space-y-1">
                        <input type="text" name="email" placeholder="Email" required
                            class="bg-indigo-50 px-4 py-2 outline-none rounded-md w-full" />
                    </div>

                    <div class="space-y-0">
                        <input type="password" name="password" placeholder="Wachtwoord" required
                            class="bg-indigo-50 px-4 py-2 outline-none rounded-md w-full" />
                    </div>

                    <div class="space-y-0">
                        <input type="password" name="repeatpassword" placeholder="Herhaal Wachtwoord" required
                            class="bg-indigo-50 px-4 py-2 outline-none rounded-md w-full" />
                    </div>

                    <div class="space-y-0">
                        <input type="date" name="geboortedatum" placeholder="04-08-2005" required
                            class="bg-indigo-50 px-4 py-2 outline-none rounded-md w-full" />
                    </div>
                </div>
                <input type="submit" value="Maak account" name="submit"
                    class="mt-9 w-full bg-green-600  text-black-800 py-2 rounded-md text-lg tracking-wide cursor-pointer"></input>
                <div class="mt-13 text-grey-dark">
                    <p>Al een account? <a class="text-blue-600 hover:underline" href="login.php">Log in</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

