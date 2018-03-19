<?php
include('../connection.php');
include('../Models/index.php');

session_start();
if(isset($_SESSION['vote_success'])) {
    $back_url = 'landing_page.php';              
     header('Location: ../' . $back_url);     
}
$voter_grade_level = $_POST['GradeLevel'];

$position_query = 
        "SELECT position.Id, position.Description, position.MaxCandidate, position.PositionIndex, position.MaxWinner, position.ForGradeLevel FROM ElectionPosition
        INNER JOIN election on ElectionPosition.electionId = election.Id
        INNER JOIN Position on ElectionPosition.positionId = position.Id
        WHERE (Position.ForGradeLevel = 0 OR Position.ForGradeLevel = " . $voter_grade_level . ") AND election.Id = " . $_POST['election_id'];

$position_statement = $conn->prepare($position_query);
$position_statement->execute();
$positions = $position_statement->fetchAll( PDO::FETCH_CLASS, "Position");


?>


<html>
    <head>
        <title>Vote</title>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <style>
      body {
        display: flex;
        min-height: 100vh;
        flex-direction: column;
      }

      .my-wrapper {
          margin-top: 100px;
      }

      html {
        background-color: #F0F0F0;
      }
              
      body {
        display: flex;
        min-height: 100vh;
        flex-direction: column;
        min-width: 850px;
      }

      main {
        flex: 1 0 auto;
      }
          
    </style>
    
    </head>

    <body>

    <main>
        <div class="container">
            <div class="row">               
                    <div class="card-panel">
                                         
                        <!-- Main body -->
                        <div class="main">
                        
                            <div class="row">
                            
                            <h5><b>Please vote wisely!</b></h5>

                            <hr>

                                <form name="vote" action="../Actions/vote_submit.php" method="post">

                                    <input type="hidden" name="election_id" value="<?php echo $_POST['election_id']; ?>"/>
                                    <input type="hidden" name="GradeLevel" value="<?php echo $voter_grade_level; ?>"/>

                                    <?php 
                                        foreach($positions as $position) {

                                            $is_radio = true;

                                            if($position->MaxWinner > 1) {
                                                $is_radio = false;
                                            }

                                            $candidate_query = 
                                                "SELECT * FROM ElectionPosition
                                                INNER JOIN election on ElectionPosition.electionId = election.Id
                                                INNER JOIN Position on ElectionPosition.positionId = position.Id
                                                INNER JOIN Candidate on Candidate.ElectionPositionId = ElectionPosition.Id
                                                WHERE election.Id = " . $_POST['election_id'] ." AND Position.Id = " . $position->Id;
                                            
                                                $candidates_statement = $conn->prepare($candidate_query);
                                                $candidates_statement->execute();

                                                $candidates = $candidates_statement->fetchAll( PDO::FETCH_CLASS, "Candidate");

                                                $multiple_candidate = "";

                                                if($position->MaxWinner > 1) {
                                                    $multiple_candidate = "Please choose " . $position->MaxWinner . " candidates";
                                                }

                                                //var_dump($candidates);

                                                echo '
                                                    <div class="col s12">         
                                                        <div class="section">
                                                            <h5> ' . $position->PositionIndex . '. ' . $position->Description . '</h5>
                                                            <h6 style="padding-left: 2em; color: #ff6f00;"> ' . $multiple_candidate . '</h6>
                                                        </div>            
                                                    </div>
                                                ';

                                                if($is_radio == false) {

                                                }

                                                foreach($candidates as $candidate) {
                                                    if($is_radio) {
                                                        echo '
                                                            <p style="padding-left: 5em;">

                                                                <input class="with-gap" name="position' . $position->Id . '" type="radio" value="' . $candidate->Id .'" id="candidate' . $candidate->Id .'" required/>
                                                                <label for="candidate' . $candidate->Id .'">' . $candidate->Firstname . ' ' . $candidate->Lastname .'</label>

                                                            </p>
                                                        ';
                                                    } else {
                                                        echo '
                                                            <p style="padding-left: 5em;">

                                                                <input onClick="return checkVoteLimit(\'position' . $position->Id .'[]\', ' . $position->MaxWinner .')" class="filled-in" name="position' . $position->Id . '[]" type="checkbox" value="' . $candidate->Id .'" id="candidate' . $candidate->Id .'" data-validation-minchecked-minchecked="' . $position->MaxWinner . '"/>
                                                                <label for="candidate' . $candidate->Id .'">' . $candidate->Firstname . ' ' . $candidate->Lastname .'</label>

                                                            </p>
                                                            ';
                                                    }
        
                                                }

                                                echo '<div class="divider"></div>';
                                        }
                                    
                                    ?>


                                    <div class="section">
                                        <button type="submit" name="submit" id="submit" class="waves-effect waves-light btn" onclick="return validate();">Submit</button>
                                    </div>
                                </form>  

                            </div>


                             
                        </div>
            
                    </div>                    
            </div>  
        </div>
    </main>




       <!-- Main Body scripts -->
        <div>
            <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script> 
            <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>

            <script>

                function validate() {
                    
                    <?php 
                    
                        foreach($positions as $validate_position) {
                            if($validate_position->MaxWinner > 1) {

                                echo '
                                var MaxWinner = ' . $validate_position->MaxWinner .';
                                var checkboxes = document.getElementsByName(\'position' . $validate_position->Id . '[]\');
                                var checkboxesChecked = [];
                                
                                for (var i=0; i<checkboxes.length; i++) {
                                    if (checkboxes[i].checked) {
                                        checkboxesChecked.push(checkboxes[i]);
                                    }
                                }
                                console.log(MaxWinner + \' \' + checkboxesChecked.length + \'' . $validate_position->Description . '\');
                                if(MaxWinner > checkboxesChecked.length) {
                                    Materialize.toast(\'Cannot submit, please select more candidates.\', 2000);
                                    return false;
                                }
                                ';


                            }                  
                        }

                    ?>

                    return true;
                }

                function checkVoteLimit(checkboxName, MaxWinner) {


                    var checkboxes = document.getElementsByName(checkboxName);
                    var checkboxesChecked = [];

                    for (var i=0; i<checkboxes.length; i++) {
                        
                        if (checkboxes[i].checked) {
                            checkboxesChecked.push(checkboxes[i]);
                        }
                    }

                    if(MaxWinner < checkboxesChecked.length) {
                        Materialize.toast('You can vote up to ' + MaxWinner + ' candidates for this position.', 2000);
                        return false;
                    } else {
                        return true;
                    }
                    
                } 


                $( document ).ready(function() {

                    $(".modal").modal();


                });

            </script>
        </div>
    </body>


  </html>