<?php

$Id = $candidate->Id;
$Firstname = $candidate->Firstname;
$Lastname = $candidate->Lastname;
$MiddleInitial = $candidate->MiddleInitial;
$GradeLevel = $candidate->GradeLevel;

$Description = $position->Description;
$ForGradeLevel = $position->ForGradeLevel;

$grade1disabled = "";
$grade2disabled = "";
$grade3disabled = "";
$grade4disabled = "";
$grade5disabled = "";
$grade6disabled = "";
if($ForGradeLevel == 2) {
    $grade1disabled = "disabled";
    $grade3disabled = "disabled";
    $grade4disabled = "disabled";
    $grade5disabled = "disabled";
    $grade6disabled = "disabled";
}else if($ForGradeLevel == 3) {
    $grade1disabled = "disabled";
    $grade2disabled = "disabled";
    $grade4disabled = "disabled";
    $grade5disabled = "disabled";
    $grade6disabled = "disabled";
} else if($ForGradeLevel == 4) {
    $grade1disabled = "disabled";
    $grade2disabled = "disabled";
    $grade3disabled = "disabled";
    $grade5disabled = "disabled";
    $grade6disabled = "disabled";
} else if($ForGradeLevel == 5) {
    $grade1disabled = "disabled";
    $grade2disabled = "disabled";
    $grade3disabled = "disabled";
    $grade4disabled = "disabled";
    $grade6disabled = "disabled";
}

$grade1selected = "";
$grade2selected = "";
$grade3selected = "";
$grade4selected = "";
$grade5selected = "";
$grade6selected = "";

if($GradeLevel == 1) {
    $grade1selected = "selected";
} else if ($GradeLevel == 2) {
    $grade2selected = "selected";
} else if ($GradeLevel == 3) {
    $grade3selected = "selected";
} else if ($GradeLevel == 4) {
    $grade4selected = "selected";
} else if ($GradeLevel == 5) {
    $grade5selected = "selected";
} else {
    $grade6selected = "selected";
}

?>



<div id="<?php echo $candidate->Id; ?>EditCandidateForm" class="modal">
    <form action="Actions/edit_candidate_submit.php" method="POST">
        <div class="modal-content">

            <input type="hidden" name="Id" value="<?php echo $Id; ?>">
            <input type="hidden" name="ElectionId" value="<?php echo $election->Id; ?>">

            <div class="row">
                <h5 class="left">Candidate Position:  <?php echo $Description; ?></h5>
                <a href="#<?php echo $Id; ?>ConfirmCandidateModal" class="modal-action waves-effect red btn right modal-trigger">Delete</a>
            </div>
            <div class="row">   
                <div class="input-field col s6">
                    <select name="GradeLevel" required>
                        <option value="" disabled>Choose Grade level</option>
                        <option value="2" <?php echo $grade2selected . ' ' . $grade2disabled; ?>>Grade 2</option>
                        <option value="3" <?php echo $grade3selected . ' ' . $grade3disabled; ?>>Grade 3</option>
                        <option value="4" <?php echo $grade4selected . ' ' . $grade4disabled; ?>>Grade 4</option>
                        <option value="5" <?php echo $grade5selected . ' ' . $grade5disabled; ?>>Grade 5</option>
                        <option value="0" <?php echo $grade6selected . ' ' . $grade6disabled; ?>>Grade 6</option>
                    </select>
                    <label>Grade Level</label>
                </div>
            </div>  
            <div class="row">
                <div class="input-field col s8">
                    <input maxLength="18" id="Firstname" name="Firstname" type="text" class="validate" value="<?php echo $Firstname; ?>" required>
                    <label for="Firstname">Firstname</label>
                </div>
                <div class="input-field col s4">
                    <input maxLength="18" id="MiddleInitial" name="MiddleInitial" type="text" class="validate" required pattern=".{1,2}" value="<?php echo $MiddleInitial; ?>"   required title="2 characters maximum">
                    <label for="MiddleInitial">Middle Initial</label>
                </div>
            </div>  

            <div class="row">
                <div class="input-field col s8">
                    <input maxLength="18" id="Lastname" name="Lastname" type="text" value="<?php echo $Lastname; ?>" class="validate" required>
                    <label for="Lastname">Lastname</label>
                </div>
            </div>
              
        </div>
        <div class="modal-footer">
            <button type="submit" name="submit" class="waves-effect waves-green btn-flat ">Submit</button>
            <button href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Cancel</button>
        </div>
    </form>
</div>


<div id="<?php echo $Id; ?>ConfirmCandidateModal" class="modal">
                <div class="modal-content">
                    <h4>Deleting Candidate</h4>
                    <p>Are you sure to proceed?</p>
                </div>
                <div class="modal-footer">
                    <form action="Actions/delete_candidate_submit.php" method="POST">

                        <input type="hidden" name="Id" value="<?php echo $Id; ?>">
                        <input type="hidden" name="ElectionId" value="<?php echo $election->Id; ?>">

                        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</a>
                        <button type="submit" name="submit" class="waves-effect waves-red btn-flat">Yes</button>
                    </form>
                </div>
</div>