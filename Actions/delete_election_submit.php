<?php
require('../connection.php');

$Id = $_POST['Id'];
$submit = $_POST['submit'];

if($submit == 'cancel') {
    header("Location: ../index.php");
    die();
}

$query = 'UPDATE Election SET IsActive = 0 WHERE Id = ' . $Id;

$statement = $conn->prepare($query);
$statement->execute();

header("Location: ../index.php");
die();
?>