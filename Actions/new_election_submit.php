<?php

require('../connection.php');
require('../Models/index.php');

$new_election = new Election;

$new_election->Description = $_POST['Description'];

$create_query = $new_election->GetInsertElection();

$create_statement = $conn->prepare($create_query);

$create_statement->execute();

header("Location: ../index.php");
die();
?>