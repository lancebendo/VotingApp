<?php

echo '
<div id="ElectionForm" class="modal">
    <form action="new_election_submit.php" method="POST">
        <div class="modal-content">

            <div class="row"><h5 class="left">Enter new Election</h5></div>
            <div class="row">
                <div class="input-field col s6">
                    <input maxlength="18" id="Description" type="text" class="validate" required>
                    <label for="first_name">Election Description</label>
                </div>
            </div>                     
        </div>
        <div class="modal-footer">
            <button type="submit" name="submit" class="waves-effect waves-green btn-flat ">Submit</button>
            <button href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Cancel</button>
        </div>
</form>
</div> 
';

?>