<?php
session_start();
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
</div>
    <div class="flex">
<div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
    <div class="overflow-hidden">
    <table class="min-w-full">
        <thead class="border-b">
        <tr>
        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
            #
            </th>
            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
            Naam
            </th>
            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
            Short description
            </th>
            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
            Aantal
            </th>
            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
            Prijs
            </th>
            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
            Status
            </th>
        </tr>
        </thead>
        <tbody>
        <?php
        $mirvat = $conn->prepare('SELECT * FROM products');
        $mirvat->execute();
?>
        <?php while ($row = $mirvat->fetch(PDO::FETCH_ASSOC)) { ?>
        <tr class="bg-white border-b">
            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
            <?= $row['id'] ?>
            </td>
            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
            <?= $row['naam'] ?>
            </td>
            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
            <?= $row['short_desc'] ?>
            </td>
            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
            <?= $row['quantity'] ?>
            </td>
            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
            <?= $row['price'] ?>
            </td>
            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
            <a href="edit.php?id=<?= $row['id'] ?>">
            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Edit</button>
</a>
        <a href="delete.php?id=<?= $row['id'] ?>"
           onclick="return confirm('Are you sure you want to delete this entry?')" class='bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded'>Delete
        </a>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</div>
</div>
    <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>
   </body>
</html>