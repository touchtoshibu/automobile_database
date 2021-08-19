<?php
session_start();
require_once "pdo.php";
if(isset($_POST['cancel'])){
    header("Location: view.php");
    return;
}

if(isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])){
    $_SESSION['make']=$_POST['make'];
    $_SESSION['year']=$_POST['year'];
    $_SESSION['mileage']=$_POST['mileage'];
    if(strlen($_POST['make'])<1){
        $_SESSION['message']="Make is required";
        header("Location: add.php");
        return;
    }
    else if(!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])){
        $_SESSION['message']="Mileage and year must be numeric";
        header("Location: add.php");
        return;
    }
    else{
        $stmt = $pdo->prepare('INSERT INTO autos
        (make, year, mileage) VALUES ( :mk, :yr, :mi)');
        $stmt->execute(array(
        ':mk' => $_POST['make'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage'])
        );
        $_SESSION['success'] = "Record inserted";
        header("Location: view.php");
        return;
    }
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
if( isset($_SESSION['message'])) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['message'])."</p>\n");
    unset($_SESSION['message']);
}
?>

<form method="post">
<p>Make:
<input type="text" name="make" size="60"/></p>
<p>Year:
<input type="text" name="year"/></p>
<p>Mileage:
<input type="text" name="mileage"/></p>
<input type="submit" value="Add">
<input type="submit" name="cancel" value="Cancel">
</form>