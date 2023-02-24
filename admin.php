<?php
session_start();
include 'database.php';
if (isset($_SESSION["username"])) {
    if ($_SESSION["username"] == "Admin") {
        $_SESSION["username"];
    } else {
        header("Location: index.php");
    }
} else {
    header("Location: index.php");
}

$dsn = "mysql:dbname=restaurant;host=localhost";
$servername = "localhost";
$username = "bit_academy";
$password = "bit_academy";
try {
    $conn = new PDO("mysql:host=$servername;dbname=restaurant", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}
$db = new DB();
$conn = pdo_connect_mysql();
$details = $db->dashboardGetProduct();
$bestellingen = $db->dashboardGetOrders();
$bezoekers = $db->dashboardGetUsers();

$prepare = $conn->prepare("SELECT * FROM omzet ORDER BY id");
$prepare->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                                <a class="mr-4" href="profiel.php?=<?= $_SESSION["username"] ?>"><?= $_SESSION["username"] ?></a>
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
        <ul class="flex justify-center flex-wrap">
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
        <div class="bg-gray-100">
            <div class="p-5">
                <form action="dashboard_ext.php" method="POST">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <div class="bg-white space-y-3 p-4 rounded-lg shadow">

                            <h1 class="text-xl font-bold italic">Voorraad</h1>
                            <a href="dashboard_ext.php"><button class="text-base leading-6 text-gray-500 hover:text-gray-900" name="voorraad">Meer</button></a>
                            <table class="w-full">
                                <thead class="bg-white border-b-2 border-gray-200">
                                    <tr>
                                        <th class="p-3 text-sm font-semibold tracking-wide text-left">Product</th>
                                        <th class="p-3 text-sm font-semibold tracking-wide text-left">Aantal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <?php foreach ($details as $data) {
                                        $naam = $data["naam"];
                                        $aantal = $data["quantity"];
                                    ?>
                                        <tr class="bg-white">
                                            <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                                <?= $naam ?>
                                            </td>
                                            <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                                <?= $aantal ?>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="bg-white space-y-3 p-4 rounded-lg shadow">
                            <h1 class="text-xl font-bold italic">Recente bestellingen</h1>
                            <a href="dashboard_ext.php"><button class="text-base leading-6 text-gray-500 hover:text-gray-900" name="bestellingen">Meer</button></a>
                            <table class="w-full">
                                <thead class="bg-white border-b-2 border-gray-200">
                                    <tr>
                                        <th class="p-3 text-sm font-semibold tracking-wide text-left">Naam</th>
                                        <th class="p-3 text-sm font-semibold tracking-wide text-left">Totale kosten</th>
                                        <th class="p-3 text-sm font-semibold tracking-wide text-left">Datum</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <?php foreach ($bestellingen as $data) {
                                        $naam = $data["naam"];
                                        $kosten = $data["price"];
                                        $datum = $data["placed_on"];
                                    ?>
                                        <tr class="bg-white">
                                            <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                                <?= $naam ?>
                                            </td>
                                            <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                                &euro;<?= $kosten ?>
                                            </td>
                                            <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                                <?= $datum ?>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        </a>
                        <div class="bg-white space-y-3 p-4 rounded-lg shadow">
                            <h1 class="text-xl font-bold italic">Recente bezoekers</h1>
                            <table class="w-full">
                                <a href="dashboard_ext.php"><button class="text-base leading-6 text-gray-500 hover:text-gray-900" name="recent">Meer</button></a>

                                <thead class="bg-white border-b-2 border-gray-200">
                                    <tr>
                                        <th class="p-3 text-sm font-semibold tracking-wide text-left">Gebruikersnaam</th>
                                        <th class="p-3 text-sm font-semibold tracking-wide text-left">Laatst gezien</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <?php foreach ($bezoekers as $data) {
                                        $username = $data["username"];
                                        $datum = $data["last_seen"];
                                    ?>
                                        <tr class="bg-white">
                                            <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                                <?= $username ?>
                                            </td>
                                            <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                                <?= $datum ?>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        </a>
                </form>

                <div class="bg-white space-y-3 p-4 rounded-lg shadow lg:col-span-3">
                <h1 class="text-xl font-bold italic">Omzet per maand</h1>
                            <a href="dashboard_ext.php"><button class="text-base leading-6 text-gray-500 hover:text-gray-900" name="omzet">verwijzig</button></a>
                    <canvas id="chartLine"></canvas>
                </div>
            </div>
        </div>

        <script>
            const database = <?php echo json_encode($prepare->fetchAll(PDO::FETCH_ASSOC)); ?>;
            const data = {
                labels: database.map((item) => item.maand),
                datasets: [{
                    label: "Omzet",
                    data: database.map((item) => item.omzet),
                    backgroundColor: "rgba(255, 99, 132, 0.2)",
                    borderColor: "rgba(255, 99, 132, 1)",
                    borderWidth: 1,
                }, ],
            };

            const configLineChart = {
                type: "line",
                data,
                options: {},
            };

            var chartLine = new Chart(
                document.getElementById("chartLine"),
                configLineChart
            );
        </script>
</body>

</html>