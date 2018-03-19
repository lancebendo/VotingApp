<?php 

error_reporting(E_ALL ^ E_DEPRECATED);
 include('connection2.php');
session_start();

if(isset($_POST['logout'])) {
    mysql_query("UPDATE user SET active = 0 WHERE id = 1");
    session_destroy();
    echo "<script>document.location.href = 'login_form.php'</script>;";
}

?> 