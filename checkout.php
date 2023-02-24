<?php

include('database.php');
$conn = pdo_connect_mysql();
session_start();
$userid = $_SESSION['userid'];
if (isset($_POST['order'])) {
    $naam = $_POST['naam'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $address = $_POST['straat'] . ' ' . $_POST['stad'] .  ' - ' . $_POST['zip'];
    $placed_on = date('Y-m-d');
    $cart_total = 0;
    $cart_products[] = '';

    $cart_query = $conn->prepare("SELECT * FROM `cart` WHERE userid = ?");
    $cart_query->execute([$userid]);
    if ($cart_query->rowCount() > 0) {
        while ($cart_item = $cart_query->fetch(PDO::FETCH_ASSOC)) {
            $product_naam = $cart_item['naam'];
            $product_price = $cart_item['price'];
            $product_qty = $cart_item['quantity'];
            $cart_products[] = $product_naam . ' ( ' . $product_qty . ' )';                        
            $sub_total = ($product_price * $product_qty);
            $grand_total += $sub_total;
            $verzendkosten = 2.95;
            $cart_total = $grand_total * 1.08 + $verzendkosten;
        };
    };
    $total_products = implode(` `, $cart_products);

    $order_query = $conn->prepare("SELECT * FROM `orders` WHERE naam = ? AND number = ? AND email = ? AND address = ? AND total_products = ? AND price = ?");
    $order_query->execute([$naam, $number, $email, $address, $total_products, $cart_total]);

    if ($cart_total == 0) {
        echo 'your cart is empty';
    } elseif ($order_query->rowCount() > 0) {
        echo 'order placed already!';
    } else {
        $insert_order = $conn->prepare("INSERT INTO `orders`(userid, naam, number, email, address, total_products, price, placed_on) VALUES(?,?,?,?,?,?,?,?)");
        $insert_order->execute([$userid, $naam, $number, $email, $address, $total_products, $cart_total, $placed_on]);

        $select = "SELECT * FROM `orders` WHERE `naam` = :naam";
        $select_run = $conn->prepare($select);
        $select_run->execute(array(":naam" => $naam));
        $select_row = $select_run->fetch(PDO::FETCH_ASSOC);
        $order_id = $select_row['id'];
        $query = "INSERT INTO `copy_orders`(`bid`) VALUES (:bid)";
        $query_run = $conn->prepare($query);
        $query_execc = $query_run->execute(array(":bid" => $order_id));

        $query = "UPDATE products SET quantity = quantity - :quantity WHERE naam = :naam";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':quantity', $product_qty);
        $stmt->bindParam(':naam', $product_naam);
        $stmt->execute();

        $cart_query = $conn->prepare("SELECT * FROM `cart` WHERE userid = ?");
        $cart_query->execute([$userid]);
        $test = $cart_query->fetch(PDO::FETCH_ASSOC);

        $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE userid = ?");
        $delete_cart->execute([$userid]);
    }
    header('Location: winkel.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Home</title>
</head>

<body class="bg-gray-300">
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
                        <a href="index.php" class="block py-2 pr-4 pl-3 text-white bg-red-700 rounded md:bg-transparent md:text-red-700 md:p-0 light:text-white" aria-current="page">Home</a>
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
                    <a href="index.php?page=winkel" class="object-right block py-2 pr-4 pl-3 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-red-700 md:p-0 md:light:hover:text-white light:text-gray-400 light:hover:bg-gray-700 light:hover:text-white md:light:hover:bg-transparent light:border-gray-700"><img src="src/images/winkel.png" height="10px" width="20px"></a>
                </div>
            </div>
        </div>
    </nav>

    <body>

        <div class="grid place-items-center h-screen">
            <div>
                <div class="w-screen mx-auto bg-white shadow-lg rounded-lg md:max-w-xl mx-2">
                    <div class="md:flex ">
                        <div class="w-full p-4 px-5 py-5">
                            <div class="flex flex-row">
                                <h2 class="text-3xl font-semibold">Afrekenen</h2>

                            </div>
                            <form action="" method="POST">
                                <div class="flex flex-row pt-2 text-xs pt-6 pb-5"> <span class="font-bold">Informatie</span> <small class="text-gray-400 ml-1">></small> <span class="text-gray-400 ml-1">Shoppen</span> <small class="text-gray-400 ml-1">></small> <span class="text-gray-400 ml-1">Betalen</span> </div> <span></span>
                                <span>Klant informatie</span>
                                <input type="text" name="naam" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Volledige naam">
                                <input type="text" name="email" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Email">
                                <input type="text" name="straat" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="straat">
                                <div class="grid md:grid-cols-3 md:gap-2">
                                    <input type="text" name="straat" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Huisnummer"> <input type="text" name="stad" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="stad"> <input type="text" name="zip" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="postcode">
                                </div>
                                <input type="text" name="number" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Telefonnummer">
                                <div class="flex justify-between items-center pt-2"> <a href="winkel.php"> <button type="button" class="h-12 w-24 text-blue-500 text-xs font-medium">Terug naar winkelwagen</button></a> <a href="" class="rounded-md px-3.5 py-2 m-1 overflow-hidden relative group cursor-pointer border-2 font-medium border-red-600 text-red-600 text-white">
                                        <span class="absolute w-64 h-0 transition-all duration-300 origin-center rotate-45 -translate-x-20 bg-red-600 top-1/2 group-hover:h-64 group-hover:-translate-y-32 ease"></span>
                                        <input type="submit" name="order" class="<?= ($cart_grand_total > 1) ? '' : 'disabled'; ?> relative text-red-600 transition duration-300 group-hover:text-white ease" value="plaats bestelling">
                                    </a> </div>
                            </form </div>
                        </div>
                    </div>
                </div>
            </div>



    </body>

</html>