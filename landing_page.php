
<?php
error_reporting(E_ALL ^ E_DEPRECATED);
include('connection2.php');
include('Models/index.php');
$query = "SELECT active FROM user";
$result = mysql_query($query, $conn)or die(mysql_error());
$num_row = mysql_num_rows($result);
$row=mysql_fetch_array($result);

session_start();
include('connection.php');

  if(array_key_exists('active', $_SESSION) && $_SESSION['active']!=null){
    header("Refresh:0; url=index.php");              
  }

  $ongoing_election_query = "SELECT * FROM Election WHERE Status = 1 AND IsActive = 1";
  $statement = $conn->prepare($ongoing_election_query);
  $statement->execute();
  $elections = $statement->fetchAll( PDO::FETCH_CLASS, "Election");
  $ongoing_election;

  $has_ongoing_election = false;

  if(isset($elections[0])) {
    $has_ongoing_election = true;
    $ongoing_election = $elections[0];
  }

  $vote_success = false;

  if(isset($_SESSION['vote_success']) && $_SESSION['vote_success'] == true) {
    $vote_success = true;
  }

?>


<html>
  <head>
    <title>Welcome to BMCCo's voting app</title>
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
            
      a {
          text-decoration: underline;
          color: white;
      }
    </style>
    
  </head>

  <body>              <p class="right">
                        <input type="checkbox" class="filled-in" id="10filler" name="10IsFiller"/>
                        <label for="10filler">Filler candidate only</label>
                    </p>

    <main>
      <div class="container">
        <div class="row">
          <div class="col s6 offset-s4">
            <div class="my-wrapper valign-wrapper">
              <div class="card-panel" style="width: 70%;">
                <div class="card-title">
                  <?php 
                    if($vote_success == true) {
                      echo 'Last vote is submitted successfully. <br>Please call the admin to unlock this computer if you\'re a new voter.';
                    }else if($has_ongoing_election == true) {
                      echo'Select your grade level before proceeding to voting page.'; 
                    } else {
                    }
                  ?>
                </div>
                <div class="card-content">
                
                <?php

                  if($vote_success == true) {
                    echo '
                      <form name="input" action="Actions/unlock_submit.php" method="post">
                        <label for="id"></label><input type="text" value="" id="id" name="id" hidden />
                        <label for="password">Enter Passcode:</label><input maxlength="18" type="password" value="" id="password" name="password" />
                        <label for="active"></label>
                        <div class=" center-align">
                          <button type="submit" name="submit" id="submit" class="waves-effect waves-light btn">Unlock</button>
                        </div>
                      </form>
                    ';
                  } else if($has_ongoing_election == true) {
                    echo '<form action="Components/vote.php" method="post">
                            <input type="hidden" name="election_id" value=" ' . $ongoing_election->Id . '"/>
                            <div class="input-field">
                              <select name="GradeLevel" required>
                                <option value="" disabled selected>Grade Level</option>
                                <option value="2">Grade 2</option>
                                <option value="3">Grade 3</option>
                                <option value="4">Grade 4</option>
                                <option value="5">Grade 5</option>
                                <option value="0">Grade 6</option>
                              </select>
                            </div>
                            <div class=" center-align">
                              <button type="submit" name="submit" id="submit" class="waves-effect waves-light btn">Proceed</button>
                            </div>
                          </form>';
                      } else {
                        echo "<h5>There's no ongoing election as of now. <br> Please contact the admin.</h5>";
                      }


                    ?>

                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <footer class="page-footer" style="background: #f0f0f0;">

        <div class="footer-copyright teal">
            <div class="container">
                BMCCo Voting App &copy; 2018 Developed by 
                <a href="https://www.facebook.com/lancebendo">Lance Bendo</a> & 
                <a href="https://www.facebook.com/raaamski">Ramon Ba&#241;es</a>
                <a class="grey-text text-lighten-4 right" href="login_form.php">Login as Admin</a>
            <div>
                <a href="mailto:lunchbendo@gmail.com">Send Message</a></div>
            </div>
        </div>

    </footer>

               <!-- Main Body scripts -->
    <div>
      <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script> 
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>

      <script>


      $( document ).ready(function() {

        $(".modal").modal();
        $('.collapsible').collapsible();       
        $('select').material_select();
        $("select[required]").css({display: "block", height: 0, padding: 0, width: 0, position: 'absolute'});


        <?php


        if(isset($_SESSION['unlock_success'])) {
          echo '
          Materialize.toast(\'Unlocked successfully!\', 3000, \'rounded\');
          ';
          unset($_SESSION['unlock_success']);
          unset($_SESSION['vote_success']);
          unset($_SESSION['unlock_error']);
          $back_url = 'landing_page.php';              
           header('Location: ' . $back_url);     
        }
        
        if(isset($_SESSION['unlock_error'])) {
          echo '
                Materialize.toast(\'Invalid Passcode!\', 3000);
          ';
          
          unset($_SESSION['unlock_error']);
        }

      ?>

        });

      </script>
    </div>
  </body>

</html>