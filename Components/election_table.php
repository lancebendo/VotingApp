<?php
    function CreateTable($con) {
        
        $table_tag = '<table class="striped centered responsive-table" id="Election_Table">
        <thead>
            <tr>
                <th>Election Name</th>
                <th>Election Status</th>
                <th></th>
            </tr>
        </thead>';
        
        $query = GetElections();
        
        $statement = $con->prepare($query);
        $statement->execute();
        $election_list = $statement->fetchAll( PDO::FETCH_CLASS, "Election");

        $table_tag .= PutTableBody($election_list);


        return $table_tag;
    }

    function PutTableBody($election_list) {

        $body_tag = '<tbody>';

        foreach ($election_list as $election) {

            $color = "";
            if($election->Status == 0) {
                $color = "red";
            } else if ($election->Status == 1) {
                $color = "green";
            } else {
                $color = "yellow darken-2";
            }

            $body_tag .= '<tr>
                            <td>' . $election->Description . '</td>
                            <td> <span class="'. $color .'" style="color: #fafafa;">'. $election->GetStatus() . '</span></td>
                            <td>
                            <form action="election_info.php" method="GET">
                            <input type="hidden" name="Tab" value="0">
                            <input type="hidden" name="Id" value="' . $election->Id . '">
                            <button type="submit" class="waves-effect waves-light btn">
                                View
                            </button>    
                            &nbsp&nbsp
                            <button class="waves-effect waves-light btn modal-trigger" href="#' . $election->Id . 'EditElectionForm">
                                Rename
                            </button>
                            &nbsp&nbsp
                            <button class="waves-effect waves-light btn modal-trigger red" href="#' . $election->Id . 'ConfirmModal">
                                Delete
                            </button>
                            <div id="' . $election->Id .  'ConfirmModal" class="modal">
                                <div class="modal-content">
                                    <h4>Please Confirm</h4>
                                    <p>Are you sure to proceed?</p>
                                </div>
                                <div class="modal-footer">
                                    <form action="Actions/delete_election_submit.php" method="POST">
                                        <input type="hidden" name="Id" value="' . $election->Id . '">
                                        <a class="modal-action modal-close waves-effect waves-green btn-flat ">Cancel</a>
                                        <button type="submit" name="submit" value="submit" class="waves-effect waves-green btn-flat ">Confirm</button>
                                    </form>
                                </div>
                            </div>
                            </form>
                        </td>';
                        require('edit_election.php');

            $body_tag .= '
            <div id="' . $election->Id . 'EditForm" class="modal modal-fixed-footer">
                <div class="modal-content">
                        
                    <div class="row">
                    <h5 class="left">' . $election->Description . '</h5>
                    
                    <a href="#' . $election->Id . 'ConfirmModal" class="modal-action modal-close waves-effect red btn right modal-trigger">Delete</a>
                        
                    </div>
                        
                    <hr>
                    
                </div>
                <div class="modal-footer">
                    <a href="#!" class="waves-effect waves-green btn-flat ">Submit</a>
                    <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Cancel</a>
                </div>
            </div> 
            
            <div id="' . $election->Id .  'ConfirmModal" class="modal">
                <div class="modal-content">
                    <h4>Please Confirm</h4>
                    <p>Are you sure to proceed?</p>
                </div>
                <div class="modal-footer">
                    <form action="Actions/delete_election_submit.php" method="POST">
                        <input type="hidden" name="Id" value="' . $election->Id . '">
                        <a class="modal-action modal-close waves-effect waves-green btn-flat ">Cancel</a>
                        <button type="submit" name="submit" value="submit" class="waves-effect waves-green btn-flat ">Confirm</button>
                    </form>
                </div>
            </div>

            ';
        }

        $body_tag .= '</tbody>';
        return $body_tag;
    }

?>