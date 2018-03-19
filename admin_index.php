<!DOCTYPE html>
<?php


include('connection.php');





     
  
?>
<html>
    <head>
        <title>Admin Home</title>
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
                            
                                <?php 
                                if($electionIsLimit) {
                                    echo '<a class="waves-effect waves-light btn modal-trigger disabled left" href="#ElectionForm">Create Election</a> <span class="red"> maximum # of elections reached. (5) </span>';
                                } else {
                                    echo '<a class="waves-effect waves-light btn modal-trigger left" href="#ElectionForm">Create Election</a>';
                                }

                                require('Components/new_election.php');
                                
                                ?>

                                <a class="waves-effect waves-light btn right modal-trigger" href="#logoutModal" type="submit" value="logout" name="logout" id="logout">Logout</a>
                                
                                <div id="logoutModal" class="modal">
                                    <div class="modal-content">
                                        <h4>Please Confirm</h4>
                                        <p>Are you want to logout?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form name="input" action="logout.php" method="post">
                                        <a class="modal-action modal-close waves-effect waves-green btn-flat ">Cancel</a>
                                        <button class="waves-effect waves-light btn right" type="submit" name="logout" id="logout"/>Logout</button>
                                        </form>  

                                        <!-- <form action="Actions/delete_election_submit.php" method="POST">
                                            <input type="hidden" name="Id" value="' . $election->Id . '">
                                            <button type="submit" name="submit" value="submit" class="waves-effect waves-green btn-flat ">Confirm</button>
                                        </form> -->
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <?php echo CreateTable($conn); ?>  
                             
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

                $( document ).ready(function() {

                    $(".modal").modal();
                    $('.collapsible').collapsible();

                });

            </script>
        </div>
    </body>


  </html>