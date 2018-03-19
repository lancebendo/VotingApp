
<?php
error_reporting(E_ALL ^ E_DEPRECATED);
include('connection2.php');
$query = "SELECT active FROM user";
$result = mysql_query($query, $conn)or die(mysql_error());
$num_row = mysql_num_rows($result);
$row=mysql_fetch_array($result);

session_start();
include('connection.php');

  if(array_key_exists('active', $_SESSION) && $_SESSION['active']!=null){
    header("Refresh:0; url=index.php");              
  }

  $login_error = false;

  if(isset($_SESSION['login_error']) && $_SESSION['login_error'] == true) {
    $login_error = true;
    unset($_SESSION['login_error']);
  }

?>


<html>
  <head>
    <title>Login</title>
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

  <body>
    <main>
      <div class="container">
        <div class="row">
          <div class="col s6 offset-s4">
            <div class="my-wrapper valign-wrapper">
              <div class="card-panel">
                <div class="card-title">Admin login</div>
                <div class="card-content">
                  <form name="input" action="login.php" method="post">
                    <label for="id"></label><input type="text" value="" id="id" name="id" hidden />
                    <label for="password">Enter Passcode:</label><input maxlength="18" type="password" value="" id="password" name="password" />
                    <label for="active"></label><input type="int" hidden value=" <?php  echo $row["active"];  ?> " id="active" name="active" />
                    <div class=" center-align">
                      <button type="submit" name="submit" id="submit" class="waves-effect waves-light btn">Login</button>
                    </div>
                  </form>
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
                <a class="grey-text text-lighten-4 right" href="landing_page.php">Back to Voting Page</a>
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

        <?php 
        if($login_error == true) {
          echo "Materialize.toast('Wrong Password!', 3000)"; 
        } 
        ?>

        });

      </script>
    </div>
  </body>

</html>