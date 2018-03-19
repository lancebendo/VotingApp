<?php

require('../connection.php');
require('../Models/index.php');

$election = new Election;

$election->Description = $_POST['Description'];
$election->Id = $_POST['Id'];
$create_query = "UPDATE ELECTION SET Description = '" . $election->Description . "' WHERE Id = " . $election->Id;

$create_statement = $conn->prepare($create_query);

$create_statement->execute();

header("Location: ../index.php");
die();
?>