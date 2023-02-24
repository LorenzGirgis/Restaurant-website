<?php
session_start();
include('database.php');
$conn = pdo_connect_mysql();
$db = new DB();
$detail = $db->getDetail();
foreach ($detail as $data) {
    $product_qty = $data['quantity'];

}
error_reporting(0);
if (isset($_POST['add_to_cart'])) {

    $userid = $_SESSION['userid'];
    $pid = $_POST['p_id'];
    $p_naam = $_POST['p_naam'];
    $p_price = $_POST['p_price'];
    $p_image = $_POST['p_image'];
    $p_qty = $_POST['p_qty'];

    $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE naam = ? AND userid = ?");
    $check_cart_numbers->execute([$p_naam, $userid]);

    if ($check_cart_numbers->rowCount() > 0) {
        echo '<div class="p-4 mb-4 text-sm text-yellow-700 bg-yellow-100 rounded-lg dark:bg-yellow-200 dark:text-yellow-800" role="alert">
        <span class="font-medium"></span> Je hebt dit product al een keer toegevoegd.
      </div>';
    } else {
        $insert_cart = $conn->prepare("INSERT INTO `cart`(userid, pid, naam, price, quantity, image) VALUES(?,?,?,?,?,?)");
        $insert_cart->execute([$userid, $pid, $p_naam, $p_price, $p_qty, $p_image]);
        echo '<div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
        <span class="font-medium">Je hebt dit product succesvol toegevoegd.
      </div>';
    }
}


if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
    $delete_cart_item->execute([$delete_id]);
    header('location:winkel.php');
}

if (isset($_POST['update_qty'])) {
    if (isset($_POST['update_qty'])) {
        $winkel_id = $_POST['cart_id'];
        $p_qty = $_POST['p_qty'];
        $p_qty = filter_var($p_qty);
        $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
        $update_qty->execute([$p_qty, $winkel_id]);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Winkelwagen</title>
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
    <div class="bg-gray-300 grid place-items-center h-screen">
        <div>


            <div class="w-screen mx-auto bg-gray-100 shadow-lg rounded-lg  md:max-w-5xl">
                <div>
                    <div>

                        <div class="md:grid md:grid-cols-1 gap-2 ">

                            <div class="col-span-2 p-5">

                                <h1 class="text-xl font-medium ">Winkelwagen</h1>
                                <form action="index.php?page=winkel" method="post">
                                    <?php
                                    $grand_total = 0;
                                    $stmt = $conn->prepare("SELECT * FROM `cart` WHERE userid = :id");
                                    $stmt->bindParam(":id", $_SESSION["userid"]);
                                    $stmt->execute();
                                    if ($stmt->rowCount() > 0) {
                                        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            $id = $data['id'];
                                            $pid = $data['pid'];
                                            $naam = $data['naam'];
                                            $price = $data['price'];
                                            $quantity = $data['quantity'];
                                            $image = $data['image'];
                                    ?>
                                            <form action="" method="POST" class="box">
                                                <div class="flex justify-between items-center mt-6 pt-6">
                                                    <div class="flex items-center">
                                                        <img src="src/images/<?= $image ?>" width="60" class="rounded-full ">
                                                        <div class="flex flex-col ml-3">
                                                            <span class="md:text-md font-medium"><?= $naam ?></span>
                                                            <span class="text-xs font-light text-gray-400">&euro; <?= $price ?></span>
                                                        </div>
                                                    </div>

                                                    <div class="flex justify-center items-center">
                                                        <input type="hidden" name="cart_id" value="<?= $id ?>">
                                                        <div class="pr-8">
                                                            <input type="number" value="<?= $quantity ?>" max="<?php $qty = $conn->prepare("SELECT * FROM products WHERE id = :id");
                                                                                                                $qty->bindParam(":id", $pid);
                                                                                                                $qty->execute();
                                                                                                                $qty = $qty->fetch(PDO::FETCH_ASSOC);
                                                                                                                echo $qty["quantity"]; ?>" name="p_qty" class="w-12 text-center">
                                                            <input class="cursor-pointer" type="submit" value="update" name="update_qty">
                                                            <a href="winkel.php?delete=<?= $id ?>" class="">
                                                                <input class="cursor-pointer" type="button" value="verwijder" name="delete" class="option-btn">
                                                            </a>
                                                        </div>
                                                        <div class="pr-8 ">
                                                            <span class="text-xs font-medium">&euro;<?= $price * $quantity ?></span>
                                                        </div>
                                                        <div>
                                                            <i class="fa fa-close text-xs font-medium"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                    <?php
                                            $sub_total = ($data['price'] * $data['quantity']);
                                            $total += $sub_total;
                                        }
                                    } else {
                                        echo '<p class="empty">Winkelwagen is leeg</p>';
                                    }
                                    $verzendkosten = 2.95;
                                    $grand_total = $total * 1.08 + $verzendkosten;
                                    ?>

                                    <div class="flex justify-between items-center mt-6 pt-6 border-t">
                                        <div class="flex items-center">
                                            <i class="fa fa-arrow-left text-sm pr-2"></i>
                                            <a href="menu.php" span class="text-md  font-medium text-blue-500 mr-4">Verder winkelen</span>
                                            </a>
                                        </div>

                                        <div class="flex justify-center items-end">
                                            <div class="flex flex-col">
                                                <span class="text-m font-small text-gray-400 mr-1">Verzendkosten: <span class="text-m font-bold text-gray-800 ">&euro; <?= $verzendkosten ?> </span> </span>
                                                <span class="text-m font-small text-gray-400 mr-1">Subtotaal: <span class="text-m font-bold text-gray-800 ">&euro; <?= $total ?> </span> (excl btw & verzendkosten) </span>
                                                <span class="text-m font-small text-gray-400 mr-1">Totaal: <span class="text-m font-bold text-gray-800 ">&euro; <?= $grand_total ?></span> (incl 8% btw)</span>
                                            </div>
                                            <a href="checkout.php">
                                                <button class="group ml-12 relative h-10 w-24 overflow-hidden rounded-full bg-white text-lg shadow">
                                                    <div class="absolute inset-0 w-0 bg-red-600 transition-all duration-[250ms] ease-out group-hover:w-full"></div>
                                                    <span class="relative text-black group-hover:text-white <?= ($grand_total > 1) ? '' : 'disabled'; ?>">Afrekenen</span>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>

    <!-- Footer -->
    <section class="bg-white">
        <div class="max-w-screen-xl px-4 py-12 mx-auto space-y-8 overflow-hidden sm:px-6 lg:px-8">
            <nav class="flex flex-wrap justify-center -mx-5 -my-2">
                <div class="px-5 py-2">
                    <a href="index.php" class="text-base leading-6 text-gray-500 hover:text-gray-900">Home</a>
                </div>

                <div class="px-5 py-2">
                    <a href="menu.php" class="text-base leading-6 text-gray-500 hover:text-gray-900">Menu</a>
                </div>

                <div class="px-5 py-2">
                    <a href="about.php" class="text-base leading-6 text-gray-500 hover:text-gray-900">About</a>
                </div>

                <div class="px-5 py-2">
                    <a href="contact.php" class="text-base leading-6 text-gray-500 hover:text-gray-900">Contact</a>
                </div>
            </nav>

            <div class="flex justify-center mt-8 space-x-6">
                <a href="https://www.facebook.com/Trattorialabellavitacasto/" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Facebook</span>

                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path>
                    </svg>
                </a>

                <a href="https://www.instagram.com/labellavitacasto.nl/" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Instagram</span>

                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"></path>
                    </svg>
                </a>

                <a href="#" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Twitter</span>

                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84">
                        </path>
                    </svg>
                </a>

                <a href="#" class="text-gray-400 hover:text-gray-500">
            </div>

            <p class="mt-8 text-base leading-6 text-center text-gray-400">© 2022 La Bella Vita, Inc. All rights
                reserved.</p>
        </div>
    </section>

    <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>
</body>

</html>
