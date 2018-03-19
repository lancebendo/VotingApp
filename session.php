<?php 
include('connection.php');
session_start();
$password = $_SESSION['password'];
  
 $account_type = mysql_query("SELECT * from user WHERE password='$password' AND active = 1")or die(mysql_error());
$account_row    = mysql_fetch_array($account_type);
  
//$user_type = $account_row['user_type'];

?>