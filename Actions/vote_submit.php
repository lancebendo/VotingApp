<?php

session_start();

include('../connection.php');
include('../models/index.php');

$Grade_Level = $_POST['GradeLevel'];

$position_query = 
"SELECT position.Id, position.Description, position.MaxCandidate, position.PositionIndex, position.MaxWinner, position.ForGradeLevel FROM ElectionPosition
INNER JOIN election on ElectionPosition.electionId = election.Id
INNER JOIN Position on ElectionPosition.positionId = position.Id
WHERE (Position.ForGradeLevel = 0 OR Position.ForGradeLevel = " . $Grade_Level . ") AND election.Id = " . $_POST['election_id'];

$position_statement = $conn->prepare($position_query);
$position_statement->execute();
$positions = $position_statement->fetchAll( PDO::FETCH_CLASS, "Position");


foreach($positions as $position) {
    $vote_data = $_POST['position' . $position->Id];

    $vote_query = "INSERT INTO Vote (CandidateId, GradeLevel) VALUES ";

    if(is_array($vote_data)) {

        $is_first = true;

        foreach($vote_data as $vote) {
            if($is_first == false) {
                $vote_query .= ", (" . $vote . ", " . $Grade_Level . ")";
            } else {
                $vote_query .= "(" . $vote . ", " . $Grade_Level . ")";
                $is_first = false;
            }
        }

    } else {
        $vote_query .= "(" . $vote_data . ", " . $Grade_Level . ")";
    }

    $vote_statement = $conn->prepare($vote_query);    
    $vote_statement->execute();

}


$_SESSION['vote_success'] = true;
$back_url = '../landing_page.php';              
 header('Location: ' . $back_url); 

?>
