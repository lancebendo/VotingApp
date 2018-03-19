<?php
  session_start();
  error_reporting(E_ALL ^ E_DEPRECATED);
  include('connection.php');

 if(isset($_POST['submit'])){         
    include('connection2.php');     
    $password = $_POST['password']; 
    $active = $_POST['active'];
    $id = $_POST['id'];

    $query = "SELECT * FROM user WHERE active = 0 and password='$password'";
    $result = mysql_query($query, $conn)or die(mysql_error());
    $num_row = mysql_num_rows($result);
    $row=mysql_fetch_array($result);


   
    if(($row['password']==$password) AND (!empty($password))){
      
      $_SESSION['active'] = $row['active'];
      mysql_query("UPDATE `user` SET active = 1 WHERE id = 1");

      echo "<script>document.location.href = 'index.php';</script>";
      
    }
      

      $query2 ="SELECT active from user";
      $result2 = mysql_query($query2, $conn)or die(mysql_error());
      $num_row2 = mysql_num_rows($result2);
      $row2=mysql_fetch_array($result2);
      

      switch(true){
        case ((empty($password)) AND $row2["active"]==0):
              echo "Input your Password!";
              break;
        case ((!empty($password)) AND $row2["active"]==0):
              echo "Incorrect Password! Redirecting after 3 seconds.";
              $_SESSION['login_error'] = true;
              $back_url = 'login_form.php';              
               header('Location: ' . $back_url);     
              break;
        case ($row2["active"]==1):
        $_SESSION['active'] = $row['active'];
              echo "Someone has logged in!";
              break;
      }
      
  }
  
?>