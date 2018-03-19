 
<div class="divider"></div>
<div class="section">
    <h5><?php echo $position->Description; ?></h5>

<?php 

$winnerCount = $position->MaxWinner;

$voteCountQuery = 
          "SELECT DISTINCT COUNT(vote.candidateId) FROM electionPosition
          INNER JOIN candidate ON candidate.electionPositionId = electionPosition.Id
          LEFT JOIN vote ON vote.candidateId = candidate.Id
          WHERE electionPosition.positionId = " . $position->Id . " AND electionPosition.electionId = " . $election->Id . " 
          GROUP BY candidate.Id, electionPosition.Id
          ORDER BY COUNT(vote.CandidateId) DESC";

$voteCount_statement = $conn->prepare($voteCountQuery);
$voteCount_statement->execute();
$voteCounts = $voteCount_statement->fetchAll(PDO::FETCH_COLUMN);

foreach($voteCounts as $voteCount) {

  $candidateVoteCountQuery = 
          "SELECT * FROM (
          SELECT candidate.Id, candidate.Firstname, candidate.Lastname, candidate.MiddleInitial, candidate.GradeLevel, count(vote.candidateId) as voteCount FROM electionposition
          INNER JOIN candidate ON candidate.electionpositionid = electionposition.id
          LEFT JOIN vote on vote.candidateid = candidate.id
          WHERE electionposition.positionid = " . $position->Id ." AND electionposition.electionid = " . $election->Id ."
          GROUP BY candidate.id, electionposition.id
          ) x WHERE x.voteCount = " . $voteCount;
  
  $candidate_voteCount_statement = $conn->prepare($candidateVoteCountQuery);
  $candidate_voteCount_statement->execute();
  $candidate_voteCounts = $candidate_voteCount_statement->fetchAll( PDO::FETCH_CLASS, "Candidate");

  $result_label = '<span class="red">Out</span>';

  

  if(count($candidate_voteCounts) <= $winnerCount) {
    $result_label = '<span class="green">Winner</span>';
    $winnerCount = $winnerCount - count($candidate_voteCounts);
  } else if($winnerCount > 0 && count($candidate_voteCounts) > $winnerCount) {
    $result_label = '<span class="yellow">Tie</span>';
    $winnerCount = $winnerCount - count($candidate_voteCounts);
  }

  foreach($candidate_voteCounts as $candidate_vote_count) {
    
    echo ' <p style="margin-left: 50px">' . $candidate_vote_count->Firstname . ' ' . $candidate_vote_count->Lastname . ' - ' . GetVoteCount($candidate_vote_count->Id, $conn) . ' votes ' . $result_label . '</p> ';

  }



}







        //  $_candidates_position = GetCandidates($election->Id, $position->Id, $conn);

        //  foreach($_candidates_position as $candidate_position) {
        //      echo ' <p style="margin-left: 50px">' . $candidate_position->Firstname . ' ' . $candidate_position->Lastname . ' - ' . GetVoteCount($candidate_position->Id, $conn) . ' votes</p> ';
        //  }

?> 
<!-- 
  <p class='green'>Michael Jordan - 51 vote(s) - Winner</p>
  <p>Kobe Bryant - 49 vote(s)</p> -->
</div>




<!-- 
<div class="divider"></div>
<div class="section">
  <h5>President: </h5> 
  <form action="#" style="margin-left: 50px">
  <p>
    <input class="with-gap" name="1vote" type="radio" id="test1" />
    <label for="test1"><b>Michael Jordan - Grade 6</b></label>
  </p>
  <p>
    <input class="with-gap" name="1vote" type="radio" id="test3"  />
    <label for="test3"><b>Kobe Bryant - Grade 5</b></label>
  </p>
  </form>
</div>
<div class="divider"></div>
<div class="section">
  <h5>Secretary: </h5>
  <form action="#" style="margin-left: 50px">
  <p>
    <input class="with-gap" name="2vote" type="radio" id="test11" />
    <label for="test11"><b>Michael Jordan - Grade 6</b></label>
  </p>
  <p>
    <input class="with-gap" name="2vote" type="radio" id="test33"  />
    <label for="test33"><b>Kobe Bryant - Grade 5</b></label>
  </p>
  </form>
</div> -->