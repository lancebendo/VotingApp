<?php

class Candidate {

    public $Id;
    public $Firstname;
    public $Lastname;
    public $MiddleInitial;
    public $PartyId;
    public $ElectionId;
    public $GradeLevel;
    public $voteCount;

   
    public function GetInsertCandidate() {
        $query = ' INSERT INTO ' . get_class($this) . ' (';
        
        $index = 0;

        foreach($this as $property => $value) {                   
            if($property == 'Id') {
                continue;
            }

            if($index > 0) {
                $query = $query . ', ' . $property;
            } else {
                $query = $query . $property;
            }
            
            $index = $index + 1;
        } 

        $query = $query . ') values (\'' . $this->Firstname . '\', \'' . $this->Lastname . '\', \'' . $this->MiddleInitial . '\', ' . $this->PartyId . ', ' . $this->ElectionId . ', ' . $this->GradeLevel . ')';
        
        return $query;
    }
}


// function GetCandidates($electionId) {
//     return 'SELECT * FROM Candidate INNER JOIN ElectionPosition on Candidate.ElectionPositionId = ElectionPosition.Id WHERE ElectionPosition.ElectionId = ' . $electionId;
// }

?>