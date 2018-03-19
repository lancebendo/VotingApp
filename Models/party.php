<?php

class Party {
    public $Id;
    public $Name;
   
    public function GetInsertParty() {
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

        $query = $query . ') values (\'' . $this->Name . '\')';
        
        return $query;
    }
}

function GetParties() {
    return 'SELECT * FROM PARTY WHERE IsActive = 1';
}

?>