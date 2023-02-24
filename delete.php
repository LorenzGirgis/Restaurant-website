<?php
$dsn = 'mysql:host=localhost;dbname=restaurant';
$username = 'root';
$password = '';
$options = [];
try {
$connection = new PDO($dsn, $username, $password, $options);
} catch(PDOException $e) {

}
$id = $_GET['id'];
$query = 'SELECT * from product_categorie where product_id = :id';
$statement = $connection->prepare($query);
$statement->execute([':id' => $id]);
$categories = $statement->fetchAll(PDO::FETCH_OBJ);

foreach($categories as $category) {
  $sql = 'DELETE FROM product_categorie WHERE id=:id';
  $statement = $connection->prepare($sql);
  $statement->execute([':id' => $category->id]);
}

$sql = 'DELETE FROM products WHERE id=:id';
$statement = $connection->prepare($sql);
if ($statement->execute([':id' => $id])) {
  header("Location: producten.php");
}