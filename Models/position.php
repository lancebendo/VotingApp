<?php

abstract class ForGradeLevel {
    const Any = 0;
    const GradeThree = 3;
    const GradeFour = 4;
    const GradeTive = 5;
}

class Position {
    public $Id;
    public $Description;
    public $MaxCandidate;
    public $PositionIndex;
    public $MaxWinner;
    public $ForGradeLevel;

    public function GetInsertPosition() {
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

        $query = $query . ') values (\'' . $this->Description . '\', ' . $this->MaxCandidate . ', ' . $this->PositionIndex . ', ' . $this->MaxWinner . ', ' . $this->ForGradeLevel . ')';

        
        return $query;
    }
    
}

function GetPositions() {
    return 'SELECT * FROM POSITION WHERE IsActive = 1 order by PositionIndex';
}

?>