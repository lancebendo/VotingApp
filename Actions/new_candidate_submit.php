<?php

require('../connection.php');

$ElectionId = $_POST['ElectionId'];
$PosititionId = $_POST['PositionId'];

$Firstname = $_POST['Firstname'];
$Lastname = $_POST['Lastname'];
$MiddleInitial = $_POST['MiddleInitial'];
$GradeLevel = $_POST['GradeLevel'];

$query = 'INSERT INTO Candidate 
          (Firstname, Lastname, Middleinitial, PartyId, ElectionPositionId, GradeLevel)
          SELECT \'' . $Firstname . '\', \'' . $Lastname . '\', \'' . $MiddleInitial . '\', 0, Id, ' . $GradeLevel . ' 
          FROM ElectionPosition
          WHERE ElectionId = ' . $ElectionId . ' AND PositionId = ' . $PosititionId .' LIMIT 1';

$create_statement = $conn->prepare($query);
          
$create_statement->execute();

$back_url = 'election_info.php?Tab=1&Id=' . $ElectionId;

header('Location: ../' . $back_url);
die();
?>