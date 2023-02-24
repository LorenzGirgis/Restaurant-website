<?php
session_start();
include 'database.php';
if (isset($_SESSION["username"])) {
    if ($_SESSION["username"] === "Admin") {
    }
} else {
    header("Location: index.php");
}

$conn = pdo_connect_mysql();
$msg = '';
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        $id = $_GET['id'];
        $username = $_POST['username'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $stmt = $conn->prepare("UPDATE users SET username = :username, firstname = :firstname, lastname = :lastname, email = :email WHERE id = :id");
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":firstname", $firstname);
        $stmt->bindParam(":lastname", $lastname);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        header("Location: klanten.php");
       $msg = 'Succes!';
    }
    $stmt = $conn->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$product) {
        exit('Klant bestaat niet!');
    }
} else {
    exit('Geen klant');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bewerk klantfen</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <nav class="bg-white px-2 sm:px-4 py-2.5 light:bg-gray-900 relative w-full z-20 top-0 left-0">
        <div class="container flex flex-wrap justify-between items-center mx-auto">
            <div class="flex items-center"></div>

            <div class="flex md:order-2">
                <button data-collapse-toggle="navbar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 light:text-gray-400 light:hover:bg-gray-700 light:focus:ring-gray-600" aria-controls="navbar-" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>

                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>

            <div class="hidden justify-between items-center w-full md:flex md:w-auto md:order-1" id="navbar">
                <a href="index.php"><img src="src/images/logo.png" class="max-w-full h-8"></a>

                <ul class="flex flex-col p-4 mt-4 bg-gray-50 rounded-lg border border-gray-100 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium md:border-0 md:bg-white light:bg-gray-800 md:light:bg-gray-900 light:border-gray-700">
                    <li>
                        <a href="index.php" class="block py-2 pr-4 pl-3 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-red-700 md:p-0 md:light:hover:text-white light:text-gray-400 light:hover:bg-gray-700 light:hover:text-white md:light:hover:bg-transparent light:border-gray-700">Home</a>
                    </li>

                    <li>
                        <a href="menu.php" class="block py-2 pr-4 pl-3 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-red-700 md:p-0 md:light:hover:text-white light:text-gray-400 light:hover:bg-gray-700 light:hover:text-white md:light:hover:bg-transparent light:border-gray-700">Menu</a>
                    </li>

                    <li>
                        <a href="about.php" class="block py-2 pr-4 pl-3 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-red-700 md:p-0 md:light:hover:text-white light:text-gray-400 light:hover:bg-gray-700 light:hover:text-white md:light:hover:bg-transparent light:border-gray-700">About</a>
                    </li>

                    <li>
                        <a href="contact.php" class="block py-2 pr-4 pl-3 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-red-700 md:p-0 md:light:hover:text-white light:text-gray-400 light:hover:bg-gray-700 light:hover:text-white md:light:hover:bg-transparent light:border-gray-700">Contact</a>
                    </li>

                    <div class="form">
                        <?php
                        if (isset($_SESSION["userid"])) {
                            if ($_SESSION["username"] === "Admin") {
                        ?>
                                <a href="admin.php" class="md:text-red-700 mr-4">Admin</a>
                                <a href="includes/logout.inc.php">Logout</a>
                            <?php
                            } else {
                            ?>
                                <a class="mr-4"><?= $_SESSION["username"] ?></a>
                                <a href="includes/logout.inc.php">Logout</a>
                            <?php
                            }
                        } else {
                            ?>
                            <a href="login.php" class="block py-2 pr-4 pl-3 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-red-700 md:p-0 md:light:hover:text-white light:text-gray-400 light:hover:bg-gray-700 light:hover:text-white md:light:hover:bg-transparent light:border-gray-700">inloggen</a>
                        <?php
                        }
                        ?>
                        </li>
                    </div>
                </ul>

                <div>
                    <a href="winkel.php" class="object-right block py-2 pr-4 pl-3 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-red-700 md:p-0 md:light:hover:text-white light:text-gray-400 light:hover:bg-gray-700 light:hover:text-white md:light:hover:bg-transparent light:border-gray-700"><img src="src/images/winkel.png" height="10px" width="20px"></a>
                </div>
            </div>
        </div>

        <div class="div">
            <ul class="flex justify-center">
                <li class="mr-6">
                    <a class="text-red 800 hover:text-red-500" href="admin.php">Dashboard</a>
                </li>
                <li class="mr-6">
                    <a class="text-red 800 hover:text-red-500" href="producten.php">Producten</a>
                </li>
                <li class="mr-6">
                    <a class="text-red 800 hover:text-red-500" href="toevoegen.php">Producten voegen</a>
                </li>
                <li class="mr-6">
                    <a class="text-red 800 hover:text-red-500" href="bestellingen.php">Bestellingen</a>
                </li>
                <li class="mr-6">
                    <a class="text-red 800 hover:text-red-500" href="klanten.php">Klanten</a>
                </li>
            </ul>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <?php
                if (isset($_SESSION['status'])) {
                ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong></strong> <?php echo $_SESSION['status']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                    unset($_SESSION['status']);
                }
                ?>
    <div class="flex justify-center place-items-center justify-evenly flex-col p-16 ">
                    <div class="bg-white px-10 py-16 rounded-xl w-screen shadow-md max-w-sm">
                        <form action="" method="POST">

                            <div class=" flex flex-col place-items-center ">
                                <label for="">ID #<?= $product['id'] ?></label>
                            </div>
                            <div class=" flex flex-col place-items-center">
                                <label for="">Gebruikersnaam</label>
                                <input type="text" name="username" class="bg-gray-100 border-2 rounded-md border-black p-2" value="<?= $product['username'] ?>" id="username" required>
                            </div>
                            <div class=" flex flex-col place-items-center">
                                <label for="">Voornaam</label>
                                <input type="text" name="firstname" class="bg-gray-100 border-2 rounded-md border-black p-2" value="<?= $product['firstname'] ?>" id="firstname" required>
                            </div>

                            <div class=" flex flex-col place-items-center">
                                <label for="">Achternaam</label>
                                <input type="text" name="lastname" class="bg-gray-100 border-2 rounded-md border-black p-2"value="<?= $product['lastname'] ?>" id="lastname" required>
                            </div>

                            <div class=" flex flex-col place-items-center">
                                <label for="">Email</label>
                                <input type="text" name="email" class="bg-gray-100 border-2 rounded-md border-black p-2" value="<?= $product['email'] ?>" id="email" required>
                            </div>
                            <div class="flex flex-col place-items-center p-2">
                                <a href="klanten.php">
                                <button type="submit" name="update_stud_data" class=" block uppercase mx-auto shadow bg-indigo-800 hover:bg-indigo-700 focus:shadow-outline focus:outline-none 
                                text-white text-xs py-3 px-10 rounded">Update</button>
                                </a>
                            </div>
                        </form>

                    </div>
                    <?php if ($msg) : ?>
            <p><?= $msg ?></p>
        <?php endif; ?>
                </div>
</body>
</html>