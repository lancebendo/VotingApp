<?php

abstract class Status {
    const NotStarted = 0;
    const Ongoing = 1;
    const Ended = 2;
}

class Election {
    public $Id;
    public $Status;
    public $Description;
   
    public function GetStatus() {
        if($this->Status == 0) {
            return 'Not Started';
        } else if($this->Status == 1) {
            return 'Ongoing';
        } else {
            return 'Ended';
        }

    }

    public function GetInsertElection() {
        $query = ' INSERT INTO ' . get_class($this) . ' (';
        
        $index = 0;

        foreach($this as $property => $value) {                      
            if($property == 'Id' || $property == 'Status') {
                continue;
            }

            if($index > 0) {
                $query = $query . ', ' . $property;
            } else {
                $query = $query . $property;
            }
            
            $index = $index + 1;
        } 

        $query = $query . ') values (\'' . $this->Description . '\')';
        
        return $query;
    }
}

function GetElections() {
    return 'SELECT * FROM ELECTION WHERE IsActive = 1 LIMIT 20';
}

?>