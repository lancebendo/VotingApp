<?php 
session_start();
require('connection.php');
require('Models/index.php');

$Id = $_GET['Id'];
$Tab = $_GET['Tab'];

$theres_other_ongoing = false;
$incomplete_candidates = false;

$start_election_query = "SELECT * FROM ELECTION WHERE IsActive = 1 AND STATUS = 1";
$start_election_statement = $conn->prepare($start_election_query);
$start_election_statement->execute();
$start_elections = $start_election_statement->fetchAll( PDO::FETCH_CLASS, "Election");
$start_election = null;
if(count($start_elections) > 0) {
    $start_election = $start_elections[0];    
}

$election_query = 'SELECT * FROM ELECTION WHERE IsActive = 1 AND Id = ' . $Id;
$election_statement = $conn->prepare($election_query);
$election_statement->execute();
$elections = $election_statement->fetchAll( PDO::FETCH_CLASS, "Election");
$election = $elections[0];

if(count($start_elections) > 0 && $election->Id != $start_election->Id) {
    $theres_other_ongoing = true;
}

$position_query = "SELECT Position.Id, Position.Description, Position.MaxCandidate,
                          Position.PositionIndex, Position.MaxWinner, Position.ForGradeLevel  FROM Position 
                        INNER JOIN ElectionPosition ON Position.Id = ElectionPosition.PositionId
                        INNER JOIN Election ON ElectionPosition.ElectionId = Election.Id
                        WHERE Election.Id = " . $Id . 
                        " ORDER BY Position.PositionIndex";

$position_statement = $conn->prepare($position_query);
$position_statement->execute();
$positions = $position_statement->fetchAll( PDO::FETCH_CLASS, "Position");



function GetCandidates($electionId, $positionId, $conn) {
    $candidate_query = "SELECT Candidate.Id, Candidate.Firstname, Candidate.Lastname, Candidate.MiddleInitial, Candidate.ElectionPositionId, Candidate.GradeLevel, Candidate.PartyId 
    FROM Candidate 
    INNER JOIN ElectionPosition ON Candidate.ElectionPositionId = ElectionPosition.Id
    WHERE ElectionPosition.ElectionId = " . $electionId . " AND ElectionPosition.PositionId = " . $positionId;

    $candidates_statement = $conn->prepare($candidate_query);
    $candidates_statement->execute();

    $candidates = $candidates_statement->fetchAll( PDO::FETCH_CLASS, "Candidate");
    
    return $candidates;
}

function GetVoteCount($candidateId, $conn) {
    
        $vote_count_query = 'SELECT COUNT(*) FROM VOTE WHERE CandidateId = ' . $candidateId;
    
        $count_statement = $conn->prepare($vote_count_query);
        $count_statement->execute();
    
        $voteCount = $count_statement->fetchColumn();
        
        return $voteCount;
}

function GetWinnerCandidate($electionId, $positionId, $conn) {
    
}

foreach($positions as $_position) {
    $_candidates = GetCandidates($election->Id, $_position->Id, $conn);
    if(count($_candidates) < $_position->MaxCandidate) {
        $incomplete_candidates = true;
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $election->Description; ?> Info </title>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    
        <style>
        
            html {
                background-color: #F0F0F0;
            }
            
            body {
                display: flex;
                min-height: 100px;
                flex-direction: column;
                min-width: 850px;
            }

            main {
                flex: 1 0 auto;
            }
            
            .page-footer {
                background-color: #f5f5f5 !important;
                color: #212121 !important;
            }
            
            #BtnStart, #BtnEnd {
                min-width: 110px;
            }

            .tabs {
            overflow-x: hidden;
            }

        </style>
    
    </head>

    <body>
        
        <div class="container">
        
            <div class="row">
                
                    
                    <div class="card-panel">

                        <div class="main">
                        
                            <div class="row">
                            
                                <div class="col s12">
                                
                                    <h6 class="left">Election Name: <?php echo $election->Description ?></h6>
                                    
                                    <div class="right">
                                        
                                        <?php 
                                            $disable_start = "";

                                            if($incomplete_candidates == true || $theres_other_ongoing == true) {
                                                $disable_start = "disabled";
                                            }

                                            if($election->Status == 0) {
                                                echo '<a class="modal-action modal-close waves-effect btn modal-trigger" href="#' . $election->Id . 'StartModal" id="BtnStart" ' . $disable_start . '>Start</a>';

                                                echo '           
                                                    <div id="' . $election->Id .  'StartModal" class="modal">
                                                        <div class="modal-content">
                                                            <h4>Start the election</h4>
                                                            <p>Are you sure to proceed?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="Actions/update_status_election.php" method="POST">
                                                                <input type="hidden" name="Id" value="' . $election->Id . '">
                                                                <input type="hidden" name="Status" value="1">

                                                                <a class="modal-action modal-close waves-effect waves-green btn-flat ">Cancel</a>
                                                                <button type="submit" name="submit" value="submit" class="waves-effect waves-green btn-flat ">Confirm</button>
                                                            </form>
                                                        </div>
                                                    </div>';

                                            } else if ($election->Status == 1) {
                                                echo '<a class="modal-action modal-close waves-effect btn modal-trigger" href="#' . $election->Id . 'EndModal" id="BtnEnd">End</a>';
                                                
                                                echo '           
                                                    <div id="' . $election->Id .  'EndModal" class="modal">
                                                        <div class="modal-content">
                                                            <h4>End the election</h4>
                                                            <p>Are you sure to proceed?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="Actions/update_status_election.php" method="POST">
                                                                <input type="hidden" name="Id" value="' . $election->Id . '">
                                                                <input type="hidden" name="Status" value="2">

                                                                <a class="modal-action modal-close waves-effect waves-green btn-flat ">Cancel</a>
                                                                <button type="submit" name="submit" value="submit" class="waves-effect waves-green btn-flat ">Confirm</button>
                                                            </form>
                                                        </div>
                                                    </div>';
                                            }
                                        ?>
                                        <a class="modal-action waves-effect btn" href="index.php" id="BtnBack">Back to List</a> 
                                    </div>
                                </div>
                                    <?php 
                                            //for warnings add if not yet ready here
                                            echo '<div class="col right">';
                                            if($incomplete_candidates == true && $election->Status == 0) {
                                                echo '<p class="red"> WARNING! Not yet ready. Please add more candidates.</p>';
                                            }

                                            if($theres_other_ongoing == true && $election->Status == 0) {
                                                echo '<p class="red">WARNING! You cannot start this election. There is another ongoing election.</p>';
                                            }
                                            echo '</div>';
                                    ?>
                            </div>
                            
                            <div class="divider"></div>
                            
                            <div class="row">
                                <div class="col s12">
                                    <ul class="tabs">
                                    <?php 

                                        $disable_result = "";

                                        if($election->Status != 2) {
                                            $disable_result = "disabled";
                                        }

                                        if($Tab == 0) {
                                            echo '<li class="tab col s4"><a class="active" href="#Summary">Summary</a></li>
                                                  <li class="tab col s4"><a href="#Candidates">Candidates</a></li>
                                                  <li class="tab col s4 ' . $disable_result .'"><a href="#Result">Results</a></li>';
                                        } else if ($Tab == 1) {
                                            echo '<li class="tab col s4"><a href="#Summary">Summary</a></li>
                                                  <li class="tab col s4"><a class="active" href="#Candidates">Candidates</a></li>
                                                  <li class="tab col s4 ' . $disable_result .'"><a href="#Result">Results</a></li>';

                                        } else if ($Tab == 2) {
                                            echo '<li class="tab col s4"><a href="#Summary">Summary</a></li>
                                                  <li class="tab col s4"><a href="#Candidates">Candidates</a></li>
                                                  <li class="tab col s4 ' . $disable_result .'"><a class="active" href="#Result">Results</a></li>';
                                        }
                                    
                                    ?>
                                    </ul>
                                </div>
                            </div>
                            
                            
                            <div id="Summary">
                            <div class="row">
                                
                                <div class="col s12">
                                
                                    <div class="divider"></div>
                                    <div class="section">
                                        <h5>Status:</h5>
                                        <p style="padding-left: 5em;"><?php echo $election->GetStatus(); ?>.</p>
                                    </div>                                    
                                    <div class="divider"></div>
                                    <div class="section">
                                        <h5>Total voters:</h5>
                                        <p style="padding-left: 5em;"><?php echo $election->GetStatus(); ?></p>
                                    </div>                                    
                                    <div class="divider"></div>
                                    <div class="section">
                                        <h5>Total voters:</h5>
                                        <p style="padding-left: 5em;"><?php echo $election->GetStatus(); ?></p>
                                    </div>
                                </div>
                                
                            </div>    

                                
                            </div>
                            
                            <div id="Candidates" class="col s12">                    
                                <div class="col s12">
                                    <?php                                
                                        foreach($positions as $position) {

                                            $candidates = GetCandidates($election->Id, $position->Id, $conn);
                                            $candidateCount = 0;  
                                            

                                            $disabled = "";
                                            if($election->Status == 1) {                   
                                                $disabled = "disabled";
                                            }
                                            else if(count($candidates) >= $position->MaxCandidate) {
                                                $disabled = "disabled";
                                            }

                                            require('Components/new_candidate.php');
                                            echo '
                                            <div class="divider"></div>
                                                <div class="section">
                                                <div class="row">
                                                    <h5 class="left">Candidates for ' . $position->Description .'</h5>
                                                    <a class="waves-effect btn right modal-trigger" href="#' . $position->Id . 'CandidateForm" ' . $disabled . '>Add Candidate</a>
                                                </div>
                                                <div class="row">
                                                    <h6> Max Candidate: ' . $position->MaxCandidate . ' </h6>
                                                </div>
                                                ';
                                                  

                                                echo '<div class="collection">';
                                            foreach($candidates as $candidate) {
                                                $candidateCount = $candidateCount + 1;
                                                $editUrl = '"';
                                                
                                                $editBadge = '';

                                                if($election->Status == 0) {
                                                    $editUrl =  $candidate->Id . 'EditCandidateForm"';
                                                    $editBadge = '<span class="badge"> Edit </span>';
                                                }
                                                //echo '<p><b>' . $candidateCount . '. ' . $candidate->Firstname . ' ' . $candidate->Lastname . '</b> - Grade ' . $candidate->GradeLevel . '<p>';
                                                echo '<a href="#' . $editUrl . ' class="collection-item modal-trigger">' . $editBadge . $candidateCount . '. ' . $candidate->Firstname . ' ' . $candidate->Lastname . ' - Grade ' . $candidate->GradeLevel . '</a>';
                                                if($election->Status == 0) {
                                                    require('Components/edit_candidate.php');
                                                }
                                            }

                                            echo '</div>';

                                            if($candidateCount == 0) {
                                                echo '<p> --</p>';
                                            }
                                            echo '</div>';
                                        }



                                    ?>     
                                </div>
                            
                            </div>
                            
                            <div id="Result" class="col s12">
                                <div class="col s12">
                                    <?php 

                                    foreach($positions as $__position) {
                                        $position = $__position;
                                        require('Components/result.php'); 
                                    }

                                    ?>
                                </div>
                            </div>
                            
                            &nbsp;

                        </div>

                    </div>
            
                </div>
                    
            
        </div>
        
       <!-- modals -->
        <div>
        
        </div>
        
        
        
       <!-- Main Body scripts -->
        <div>
            <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script> 
            <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>

            <script>

                $( document ).ready(function() {

                    $(".modal").modal();
                    $('ul.tabs').tabs();
                    $('select').material_select();

                    $("select[required]").css({display: "block", height: 0, padding: 0, width: 0, position: 'absolute'});

                    $('#start').on('change', function() {
    if ($(this).is(':checked')) {
      console.log('Start is checked');
    }
  });

                });

            </script>
        </div>
    </body>
  </html>
