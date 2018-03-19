<?php
  session_start();
  error_reporting(E_ALL ^ E_DEPRECATED);
  include('../connection.php');

 if(isset($_POST['submit'])){         
    include('../connection2.php');     
    $password = $_POST['password']; 
    
    $query = "SELECT * FROM user WHERE password='$password'";
    $result = mysql_query($query, $conn)or die(mysql_error());
    $num_row = mysql_num_rows($result);
    $row=mysql_fetch_array($result);
   
    if(($row['password']==$password) AND (!empty($password))){
      
      $_SESSION['unlock_success'] = true;
      if(isset($_SESSION['unlock_error'])) {
          unset($_SESSION['unlock_error']);
          unset($_SESSION['vote_success']);
      }
      $back_url = 'landing_page.php';              
       header('Location: ../' . $back_url);     
      
    }

      

      switch(true){
        case ((!empty($password)) AND $row2["active"]==0):
              echo "Incorrect Password! Redirecting after 3 seconds.";
              $_SESSION['unlock_error'] = true;
              $back_url = 'landing_page.php';              
               header('Location: ../' . $back_url);     
              break;
      }
      
  }
  
?>