<?php

namespace Newsletter\Classes\Database\Tables;

class Settings extends Table{

    public function __construct(array $data){
        parent::__construct($data);
    }

    public function getError(){
        if($this->errno < parent::MAX_TABLE)return parent::getError();
        else{
            switch($this->errno){
                default:
                    $this->error = null;
                    break;
            }
        }
        return $this->error;
    }

    /**
     * Drop the settings table
     */
    public function dropTable(): bool{
        return parent::dropTable();
    }
}
?>