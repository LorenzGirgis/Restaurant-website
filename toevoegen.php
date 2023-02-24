<?php
session_start();
include 'database.php';
$conn = pdo_connect_mysql();
if (isset($_SESSION["username"])) {
    if ($_SESSION["username"] == "Admin") {
        $_SESSION["username"];
    } else {
        header("Location: index.php");
    }
} else {
    header("Location: index.php");
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

<body>
    <!-- Navbar -->
    <nav class="bg-white px-2 sm:px-4 py-2.5 light:bg-gray-900 relative w-full z-20 top-0 left-0">
        <div class="container flex flex-wrap justify-between items-center mx-auto">
            <div class="flex items-center"></div>

            <div class="flex md:order-2">
                <button data-collapse-toggle="navbar" type="button" class="inline-flex items-center p-2 text-sm text-gray 800 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 light:text-gray-400 light:hover:bg-gray-700 light:focus:ring-gray-600" aria-controls="navbar-" aria-expanded="false">
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
                                $present_time = date("H:i:s-m/d/y");
                                $expiry = 60 * 24 * 60 * 60 + time();
                                setcookie("last_visit", $present_time, $expiry);
                                if (isset($_COOKIE["last_visit"])) {
                                    $last_visit = $_COOKIE["last_visit"];
                                    $last_seen = $conn->prepare("UPDATE users SET last_seen = ? WHERE id = ?");
                                    $last_seen->execute([$last_visit, $_SESSION["userid"]]);
                                }
                        ?>
                                <a href="admin.php" class="mr-4">Admin</a>
                                <a href="includes/logout.inc.php">Logout</a>
                            <?php
                            } else {
                                $present_time = date("H:i:s-m/d/y");
                                $expiry = 60 * 24 * 60 * 60 + time();
                                setcookie("last_visit", $present_time, $expiry);
                                if (isset($_COOKIE["last_visit"])) {
                                    $last_visit = $_COOKIE["last_visit"];
                                    $last_seen = $conn->prepare("UPDATE users SET last_seen = ? WHERE id = ?");
                                    $last_seen->execute([$last_visit, $_SESSION["userid"]]);
                                }
                            ?>
                                <a class="mr-4" href="profiel.php?naam=<?= $_SESSION["username"] ?>"><?= $_SESSION["username"] ?></a>
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

    </nav>

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
        <br>
        <h1 class="flex justify-center">Producten voegen </h1>
        <br>
        <div class="mx-auto w-11/12">
            <form action="" method="post">
                <div class="grid gap-6 mb-6 md:grid-cols-">
                    <div>
                        <label for="naam" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Naam</label>
                        <input type="text" name="naam" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Naam" required>
                    </div>
                    <div>
                        <label for="short_desc" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Short_desc</label>
                        <input type="text" name="short_desc" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Short description" required>
                    </div>
                    <div>
                        <label for="desc" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Desc</label>
                        <input type="text" name="desc" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Description" required>
                    </div>
                    <div>
                        <label for="p_qty" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Voorraad</label>
                        <input type="number" name="p_qty" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Voorraad" required>
                    </div>
                    <div>
                        <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">image</label>
                        <input type="file" name="image" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required>
                    </div>
                    <div>
                        <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prijs</label>
                        <input type="number" name="price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Prijs" required>
                    </div>
                    <div>
                        <label for="cars">Kies een categorie</label>
                        <select id="categorie" name="categorie" size="3" required>
                            <option value="1">Menu</option>
                            <option value="2">Sales</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" name="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-7">Toevoegen</button>
                    </div>
                </div>
        </div>
        </form>
        <br>
        <?php
        if (isset($_POST['submit'])) {
            $naam = $_POST['naam'];
            $short_desc = $_POST['short_desc'];
            $desc = $_POST['desc'];
            $quantity = $_POST['p_qty'];
            $image = $_POST['image'];
            $price = $_POST['price'];
            $categorie = $_POST['categorie'];

            $pdoQuery = "INSERT INTO `products`(`naam`, `short_desc`, `desc`, `quantity`,`image`, `price`) VALUES (:naam, :short_desc, :desc, :quantity, :image, :price)";
            $pdoQuery_run = $conn->prepare($pdoQuery);
            $pdoQuery_execc = $pdoQuery_run->execute(array(":naam" => $naam, ":short_desc" => $short_desc, ":desc" => $desc, ":quantity" => $quantity, ":image" => $image, ":price" => $price));

            $select = "SELECT * FROM `products` WHERE `naam` = :naam";
            $select_run = $conn->prepare($select);
            $select_run->execute(array(":naam" => $naam));
            $select_row = $select_run->fetch(PDO::FETCH_ASSOC);
            $product_id = $select_row['id'];
            $query = "INSERT INTO `product_categorie`(`product_id`, `categorie_id`) VALUES (:product_id, :categorie_id)";
            $query_run = $conn->prepare($query);
            $query_execc = $query_run->execute(array(":product_id" => $product_id, ":categorie_id" => $categorie));

            if ($pdoQuery_execc) {
                echo "<p><center>Product is toegevoegd</center></p>";
            } else {
                echo "<p><center>Product is niet toegevoegd</center></p>";
            }
        }
        ?>
        <br>
</body>

</html>
<style>
    h1 {
        display: flex;
        justify-content: center;

    }

    .center {
        display: flex;
        justify-content: center;
    }
</style>