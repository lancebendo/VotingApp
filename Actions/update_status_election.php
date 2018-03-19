<?php

require('../connection.php');
require('../Models/index.php');

$election = new Election;

$election->Status = $_POST['Status'];
$election->Id = $_POST['Id'];

$update_query = 'UPDATE ELECTION SET Status = ' . $election->Status . ' WHERE Id = ' . $election->Id;

$update_statement = $conn->prepare($update_query);

$update_statement->execute();

$back_url = 'election_info.php?Tab=0&Id=' . $election->Id;

 header('Location: ../' . $back_url);
 die();
?>