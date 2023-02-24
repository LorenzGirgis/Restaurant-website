<?php
session_start();
include 'database.php';

$conn = pdo_connect_mysql();

$msg = '';



if (isset($_GET['naam'])) {
    $username = $_GET['naam'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        exit('Gebruiker bestaat niet!');
    }
} else {
    exit('Geen gebruiker te vinden!');
}

if (isset($_POST['voornaam'], $_POST['achternaam'], $_POST['geboortedatum'])) {
    $firstname = $_POST['voornaam'];
    $lastname = $_POST['achternaam'];
    $geboortedatum = $_POST['geboortedatum'];
    $stmt = $conn->prepare("UPDATE users SET firstname = :firstname, lastname = :lastname, geboortedatum = :geboortedatum WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':geboortedatum', $geboortedatum);
    $stmt->execute();
    
    if (isset($_POST['gebruikersnaam'])) {
        $username = $_POST['gebruikersnaam'];
        $stmt = $conn->prepare("SELECT username FROM users WHERE username = :username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($stmt->rowCount() > 0) {
            $taken = "Gebruikersnaam is gebruikt!";
            header("Location: edit_profiel.php?naam=$username&error=usernametaken");
        } else {
            $stmt = $conn->prepare("UPDATE users SET username = :username WHERE id = :id");
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":id", $_SESSION["userid"]);
            $stmt->execute();
    
            $_SESSION["username"] = $username;
            header("Location: profiel.php?naam=$username");
        }
    }

}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
  <body class="bg-gray-200 font-sans leading-normal tracking-normal">
	<div class="container mx-auto px-4 py-8">
		<h1 class="text-2xl font-bold mb-4">Persoonlijke Gegevens Wijzigen</h1>
		<form action="" method="post" class="bg-white rounded shadow-md p-4">
        <?php
            $url = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
            if (strpos($url,"error=usernametaken") == true) {
                echo "<p class='text-red-500'>Username already taken!</p>";
            }
            ?>
			<div class="mb-4">
				<label for="gebruikersnaam" class="block text-gray-700 text-sm font-bold mb-2">Gebruikersnaam</label>
				<input type="text" required name="gebruikersnaam" value="<?=$user['username']?>" id="gebruikersnaam" class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
			</div>
            <div class="mb-4">
                <label for="firstname" class="block text-gray-700 text-sm font-bold mb-2">Voornaam</label>
                <input type="text" required name="voornaam" value="<?=$user['firstname']?>" id="voornaam" class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
            <label for="lastname" class="block text-gray-700 text-sm font-bold mb-2">Achternaam</label>
            <input type="text" required name="achternaam" value="<?=$user['lastname']?>" id="achternaam" class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
            <label for="geboortedatum" class="block text-gray-700 text-sm font-bold mb-2">Geboortedatum</label>
            <input type="date" required name="geboortedatum" value="<?=$user['geboortedatum']?>" id="geboortedatum" class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
			<div class="mb-4">
				<label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
				<input type="email" required name="email" value="<?=$user['email']?>"id="email" class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
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
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

      </body>
</div>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

      </body>
      </html>



