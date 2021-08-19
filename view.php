<?php
session_start();
require_once "pdo.php";
if ( ! isset($_SESSION['name']) ) {
    die('Not logged in');
}
if(isset($_POST['Add'])){
    header("Location: add.php");
    return;
}
if(isset($_POST['logout'])){
    session_start();
    session_destroy();
    header("Location: index.php");
    return;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Shibu kumar's Automobile Tracker</title>
<?php require_once "bootstrap.php"; ?>

</head>
<body>
<div class="container">
<h1>Tracking Autos for <?php 
if(isset($_SESSION['name'])){
    echo htmlentities($_SESSION['name'])."</h1>";
}
if ( isset($_SESSION['success']) ) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
  }
?>
</h1>

<h2>Automobiles</h2>
<?php
$stmt = $pdo->query("SELECT make, year, mileage FROM autos");
echo "<ul>";
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ){
    echo "<li>".$row['year']." ".$row['make']." / ".$row['mileage'] ;
}
echo "</ul>";
?>
<form method="post">
<input type="submit" name="Add" value="Add New">
<input type="submit" name="logout" value="Logout">
</form>
</div>
</body>
</html>