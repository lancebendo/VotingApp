<?php
    
    session_start();
    require('connection.php');
    require('Models/index.php');
    require('Components/election_table.php');
    
   

   
    $query = GetElections();

    $statement = $conn->prepare($query);

    $statement->execute();
    $result = $statement->fetchAll( PDO::FETCH_CLASS, "Election");

    
    
    $electionIsLimit = false;

    if(count($result) > 19) {
        $electionIsLimit = true;
    }


 
if(array_key_exists('active', $_SESSION) && $_SESSION['active']!=null){
    


    require('admin_index.php');


                 
} else{
    header("Refresh:0; url=landing_page.php");
    //require('login_form.php');
}


?>
