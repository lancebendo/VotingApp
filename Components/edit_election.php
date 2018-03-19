<?php


echo 
'<div id="' . $election->Id . 'EditElectionForm" class="modal">
    <form action="Actions/edit_election_submit.php" method="POST">
        <div class="modal-content">

            <div class="row"><h5 class="left">Edit Election</h5></div>
            <div class="row">
                <div class="input-field col s6">
                    <input type="hidden" name="Id" value="' . $election->Id . '">
                    <input maxLength="18" id="Description" name="Description" type="text" class="validate" value="' . $election->Description .'" required>
                    <label for="Description">Election Name</label>
                </div>
            </div>                     
        </div>
        <div class="modal-footer">
            <button type="submit" name="submit" class="waves-effect waves-green btn-flat ">Submit</button>
            <button href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Cancel</button>
        </div>
</form>
</div>';

?>