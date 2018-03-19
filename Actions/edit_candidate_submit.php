<?php

require('../connection.php');

$ElectionId = $_POST['ElectionId'];

$Id = $_POST['Id'];
$Firstname = $_POST['Firstname'];
$Lastname = $_POST['Lastname'];
$MiddleInitial = $_POST['MiddleInitial'];
$GradeLevel = $_POST['GradeLevel'];

$query = 'UPDATE Candidate
          SET Firstname = \'' . $Firstname . '\',
		      Lastname = \'' . $Lastname . '\',
              MiddleInitial = \'' . $MiddleInitial . '\',
              GradeLevel = ' . $GradeLevel . '
	          WHERE Id = ' . $Id;

echo $query;

 $update_statement = $conn->prepare($query);
          
 $update_statement->execute();

 $back_url = 'election_info.php?Tab=1&Id=' . $ElectionId;

 header('Location: ../' . $back_url);
 die();
?>