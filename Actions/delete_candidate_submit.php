<?php
require('../connection.php');

$Id = $_POST['Id'];
$ElectionId = $_POST['ElectionId'];

$submit = $_POST['submit'];

$query = 'DELETE FROM Candidate
          WHERE Id = ' . $Id;

echo $query;

$statement = $conn->prepare($query);
$statement->execute();

$back_url = 'election_info.php?Tab=1&Id=' . $ElectionId;

header('Location: ../' . $back_url);
die();
?>