<?php

$ForGradeLevel = $position->ForGradeLevel;

$grade1disabled = "";
$grade2disabled = "";
$grade3disabled = "";
$grade4disabled = "";
$grade5disabled = "";
$grade6disabled = "";

$grade2selected = "";
$grade3selected = "";
$grade4selected = "";
$grade5selected = "";

if($ForGradeLevel == 2) {
    $grade1disabled = "disabled";
    $grade3disabled = "disabled";
    $grade4disabled = "disabled";
    $grade5disabled = "disabled";
    $grade6disabled = "disabled";

    $grade2selected = "selected";
}
else if($ForGradeLevel == 3) {
    $grade1disabled = "disabled";
    $grade2disabled = "disabled";
    $grade4disabled = "disabled";
    $grade5disabled = "disabled";
    $grade6disabled = "disabled";

    $grade3selected = "selected";

} else if($ForGradeLevel == 4) {
    $grade1disabled = "disabled";
    $grade2disabled = "disabled";
    $grade3disabled = "disabled";
    $grade5disabled = "disabled";
    $grade6disabled = "disabled";

    $grade4selected = "selected";

} else if($ForGradeLevel == 5) {
    $grade1disabled = "disabled";
    $grade2disabled = "disabled";
    $grade3disabled = "disabled";
    $grade4disabled = "disabled";
    $grade6disabled = "disabled";

    $grade5selected = "selected";
}

?>



<div id="<?php echo $position->Id; ?>CandidateForm" class="modal">
    <form action="Actions/new_candidate_submit.php" method="POST">
        <div class="modal-content">

            <input type="hidden" name="ElectionId" value="<?php echo $election->Id; ?>">
            <input type="hidden" name="PositionId" value="<?php echo $position->Id; ?>">

            <div class="row">
                <h5 class="left">Candidate Position:  <?php echo $position->Description; ?></h5>
            </div>
            <div class="row">   
                <div class="input-field col s6">
                    <select name="GradeLevel" required>
                        <option value="" disabled selected>Choose Grade level</option>
                        <option value="2" <?php echo $grade2disabled. ' ' . $grade2selected; ?>>Grade 2</option>
                        <option value="3" <?php echo $grade3disabled . ' ' . $grade3selected; ?>>Grade 3</option>
                        <option value="4" <?php echo $grade4disabled . ' ' . $grade4selected; ?>>Grade 4</option>
                        <option value="5" <?php echo $grade5disabled . ' ' . $grade5selected; ?>>Grade 5</option>
                        <option value="6" <?php echo $grade6disabled; ?>>Grade 6</option>
                    </select>
                    <label>Grade Level</label>
                </div>
                <div class="input-field col s6">
                    <p class="right">
                        <input type="checkbox" class="filled-in" id="<?php echo $position->Id; ?>filler" name="<?php echo $position->Id; ?>IsFiller"/>
                        <label for="<?php echo $position->Id; ?>filler">Filler candidate only</label>
                    </p>
                </div>
            </div>  
            <div class="row">
                <div class="input-field col s8">
                    <input maxLength="18" id="Firstname" name="Firstname" type="text" class="validate" required>
                    <label for="Firstname">Firstname</label>
                </div>
                <div class="input-field col s4">
                    <input maxLength="18" id="MiddleInitial" name="MiddleInitial" type="text" class="validate" required pattern=".{1,2}"   required title="2 characters maximum">
                    <label for="MiddleInitial">Middle Initial</label>
                </div>
            </div>  

            <div class="row">
                <div class="input-field col s8">
                    <input maxLength="18" id="Lastname" name="Lastname" type="text" class="validate" required>
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