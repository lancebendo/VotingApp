
<?php


    $database = "votingsystem";
    $server = "localhost";
    $username = "root";
    $password= "tmackulet";

    $conn;
    
    try {
       $conn = new PDO("mysql:host=".$server.";dbname=votingsystem", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * from user WHERE active = 1"); 
        $stmt->execute();
        $rowsec = $stmt->fetchALL(PDO::FETCH_NUM);

        
       // $conn->db=null;


        }
    catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }

  

?>