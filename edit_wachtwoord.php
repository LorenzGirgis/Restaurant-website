<?php
session_start();
include "database.php";
$conn = pdo_connect_mysql();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="src/images/favicon.ico">
</head>

<body class="bg-gray-200 font-sans leading-normal tracking-normal">


    <div class="container">
        <form action="wachtwoord_insert.php" method="POST">
            <?php
            $url = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
            if (strpos($url,"oldpassword") !== false) {
                echo $_SESSION["oldpassword"];
            } else if (strpos($url,"passwordlength") !== false) {
                echo $_SESSION["passwordlength"];
            } else if (strpos($url,"passwordmatch") !== false) {
                echo $_SESSION["passwordmatch"];
            }
            ?>
	<div class="container mx-auto px-4 py-8">
		<h1 class="text-2xl font-bold mb-4">Persoonlijke Gegevens Wijzigen</h1>
		<form action="" method="post" class="bg-white rounded shadow-md p-4">
			<div class="mb-4">
				<label for="password" class="block text-gray-700 text-sm font-bold mb-2">Oude wachtwoord</label>
				<input type="password" required name="oldpassword" id="oldpassword" class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
			</div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Nieuwe wachtwoord</label>
                <input type="password" required name="newpassword" id="newpassword" class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Herhaal wachtwoord</label>
                <input type="password" required name="repeatpassword" id="repeatpassword" class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
<div class="flex items-center justify-between">
<button type="submit" value="Update" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
					Wijzigingen Opslaan
				</button>
				<a href="profiel.php" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
					Annuleren
				</a>
			</div>
		</form>
	</div>
</div>
</div>
        </form>
    </div>
    <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>
</body>

</html>