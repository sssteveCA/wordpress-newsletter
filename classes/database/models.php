<?php

namespace Newsletter\Classes\Database;

use Newsletter\Classes\Database\Tables\Table;
use Newsletter\Classes\Database\ModelsErrors as Me;
use Newsletter\Traits\ErrorTrait;
use Newsletter\Traits\SqlTrait;

abstract class Models extends Table implements Me{
    use ErrorTrait, SqlTrait;

    public function __construct(array $data){
        parent::__construct($data);
    }

    public function getError(){
        if($this->errno < Table::MAX_ERRNO){
            return parent::getError();
        }
        else{
            switch($this->errno){
                default:
                    $this->error = null;
                    break;
            }
        }
        return $this->error;
    }
}

interface ModelsErrors{

}
?>