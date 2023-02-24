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
<?php
    $conn = pdo_connect_mysql();
    $stmt1 = $conn->prepare("SELECT a.* 
    from copy_orders as b 
    inner join orders as a on a.id = b.bid ");
    $stmt1->execute();

    $stmt2 = $conn->prepare("SELECT a.* 
    from copy_orders as b 
    inner join orders as a on a.id = b.bid ");
    $stmt2->execute();

    $stmt3 = $conn->prepare("SELECT a.* 
    from copy_orders as b 
    inner join orders as a on a.id = b.bid ");
    $stmt3->execute();

    if (isset($_GET["completed"])) {

        $select = "SELECT * FROM `orders` WHERE `id` = :id";
        $select_run = $conn->prepare($select);
        $select_run->execute(array(":id"=>$_GET['completed']));
        $select_row = $select_run->fetch(PDO::FETCH_ASSOC);
        $order_id = $select_row['id'];
        $query = "INSERT INTO `completed_orders`(`bid`) VALUES (:bid)";
        $query_run = $conn->prepare($query);
        $query_execc = $query_run->execute(array(":bid"=>$order_id));


        $stmt5 = $conn->prepare("DELETE FROM copy_orders where bid = :bid");
        $stmt5->bindParam(':bid', $_GET['completed']);
        $stmt5->execute();

        header("Location: bestellingen.php");
    }

    $stmt6 = $conn->prepare("SELECT a.* 
    from completed_orders as b 
    inner join orders as a on a.id = b.bid ");;
    $stmt6->execute();

    $stmt7 = $conn->prepare("SELECT a.* 
    from completed_orders as b 
    inner join orders as a on a.id = b.bid ");;
    $stmt7->execute();

    $stmt8 = $conn->prepare("SELECT a.* 
    from completed_orders as b 
    inner join orders as a on a.id = b.bid ");;
    $stmt8->execute();

    if (isset($_GET["delete"])) {
        $stmt9 = $conn->prepare("DELETE FROM completed_orders where bid = :bid");
        $stmt9->bindParam(':bid', $_GET['delete']);
        $stmt9->execute();

        header("Location: bestellingen.php");
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
        </div>
        <br>

        <h1 class="text-lg font-bold flex justify-center mb-2">Orders</h1>

        <?php
        if ($stmt1->fetch() > 0) {
        ?>
            <div class="overflow-auto rounded-lg shadow hidden lg:block">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                    <tr>
                        <th class="w-20 p-3 text-sm font-semibold tracking-wide text-left">Naam</th>
                        <th class="p-3 text-sm font-semibold tracking-wide text-left">Adres</th>
                        <th class="w-24 p-3 text-sm font-semibold tracking-wide text-left">Producten</th>
                        <th class="w-24 p-3 text-sm font-semibold tracking-wide text-left">Totale kosten</th>
                        <th class="w-24 p-3 text-sm font-semibold tracking-wide text-left">Besteld op</th>
                        <th class="w-32 p-3 text-sm font-semibold tracking-wide text-left">Status</th>
                    </tr>

                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php
                        while ($row = $stmt2->fetch()) {
                            $id = $row['id'];
                            $naam = $row['naam'];
                            $number = $row['number'];
                            $address = $row['address'];
                            $amount = $row['total_products'];
                            $price = $row['price'];
                            $placed = $row['placed_on'];
                        ?>
    
                            <tr class="bg-white">
                                <td class="p-3 text-sm text-gray-700 flex flex-col">
                                    <?= $naam ?>
                                    <?= $number ?>
                                    </td>
                        <td class="p-3 text-sm text-gray-700 whitespace-nowrap"><?= $address ?></td>
                        <td class="p-3 text-sm text-gray-700 whitespace-nowrap"><?= $amount ?></td>
                        <td class="p-3 text-sm text-gray-700 whitespace-nowrap"><?= $price ?></td>
                        <td class="p-3 text-sm text-gray-700 whitespace-nowrap"><?= $placed ?></td>
                        <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">
                                <a href="bestellingen.php?completed=<?= $id ?>">Completed</a>
                            </button>
                        </td>

                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:hidden">
                <?php
                while ($row = $stmt3->fetch()) {
                    $id = $row['id'];
                    $naam = $row['naam'];
                    $number = $row['number'];
                    $address = $row['address'];
                    $price = $row['price'];
                    $placed = $row['placed_on'];
                ?>
                    <div class="bg-white space-y-3 p-4 rounded-lg shadow">
                        <div class="flex items-center space-x-2 text-sm">
                            <div class="font-bold"><?= $naam ?></div>

                            <div class="text-gray-500"><?= $placed ?></div>

                        </div>

                        <div class="text-sm text-gray-700 flex flex-col">
                            <?= $number ?>
                            <br>
                            <?= $address ?>
                        </div>

                        <div class="font-medium text-black"><?= $price ?></div>

                        <div class="flex justify-center">
                            <div>
                                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">
                                    <a href="bestellingen.php?completed=<?= $id ?>">Completed</a>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        <?php
        } else {
        ?>
            <p class="flex justify-center">No orders.</p>
        <?php
        }
        ?>

        <h1 class="text-lg font-bold flex justify-center mt-5 mb-2">Completed</h1>

        <?php
        if ($stmt6->fetch() > 0) {
        ?>
            <div class="overflow-auto rounded-lg shadow hidden lg:block">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                        <th class="w-20 p-3 text-sm font-semibold tracking-wide text-left">Naam</th>
                        <th class="p-3 text-sm font-semibold tracking-wide text-left">Adres</th>
                        <th class="w-24 p-3 text-sm font-semibold tracking-wide text-left">Producten</th>
                        <th class="w-24 p-3 text-sm font-semibold tracking-wide text-left">Totale kosten</th>
                        <th class="w-24 p-3 text-sm font-semibold tracking-wide text-left">Besteld op</th>
                        <th class="w-32 p-3 text-sm font-semibold tracking-wide text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php
                        while ($row = $stmt7->fetch()) {
                            $id = $row['id'];
                            $naam = $row['naam'];
                            $number = $row['number'];
                            $address = $row['address'];
                            $amount = $row['total_products'];
                            $price = $row['price'];
                            $placed = $row['placed_on'];
                        ?>
                            <tr class="bg-white">
                                <td class="p-3 text-sm text-gray-700 flex flex-col">
                                    <?= $naam ?>
                                    <?= $number ?>
                                </td>
                                <td class="p-3 text-sm text-gray-700 whitespace-nowrap"><?= $address ?></td>
                                <td class="p-3 text-sm text-gray-700 whitespace-nowrap"><?= $amount ?></td>
                                <td class="p-3 text-sm text-gray-700 whitespace-nowrap"><?= $price ?></td>
                                <td class="p-3 text-sm text-gray-700 whitespace-nowrap"><?= $placed ?></td>
                                <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        <a href="bestellingen.php?delete=<?= $id ?>">Delete</a>
                                    </button>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:hidden">
                <?php
                while ($row = $stmt8->fetch()) {
                    $id = $row['id'];
                    $naam = $row['naam'];
                    $number = $row['number'];
                    $address = $row['address'];
                    $price = $row['price'];
                    $placed = $row['placed_on'];
                ?>
                    <div class="bg-white space-y-3 p-4 rounded-lg shadow">
                        <div class="flex items-center space-x-2 text-sm">
                            <div class="font-bold"><?= $naam ?></div>

                            <div class="text-gray-500"><?= $placed ?></div>

                        </div>

                        <div class="text-sm text-gray-700 flex flex-col">
                            <?= $number ?>
                            <br>
                            <?= $address ?>
                        </div>

                        <div class="font-medium text-black"><?= $price ?></div>

                        <div class="flex justify-center">
                            <div>
                                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    <a href="bestellingen.php.php?delete=<?= $id ?>">Delete</a>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        <?php
        } else {
        ?>
            <p class="flex justify-center">No completed orders.</p>
        <?php
        }

        ?>
        </div>
        <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>
    </body>

    </html>