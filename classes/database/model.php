<?php

namespace Newsletter\Classes\Database;

use Newsletter\Classes\Database\ModelInterface as Mi;
use Newsletter\Classes\Database\Tables\Table;
use Newsletter\Traits\ErrorTrait;
use Newsletter\Traits\SqlTrait;
use wpdb;

abstract class Model extends Table implements Mi{

    use ErrorTrait, SqlTrait;

    public function __construct(array $data)
    {
        parent::__construct($data);
    }

    public function getError(){
        if($this->errno < 20){
            return parent::getError();
        }
        switch($this->errno){
            case Mi::ERR_GET:
                $this->error = Mi::ERR_GET_MSG;
                break;
            default:
                $this->error = null;
                break;
        }
        return $this->error = null;
    }

    /**
     * Get a single row from SELECT query
     */
    protected function get(string $query){
        $this->errno = 0;
        $this->query = <<<SQL
        SELECT * FROM {$this->tableName} {$query}
SQL;
        $this->queries[] = $this->query;
        $result = $this->wpdb->get_row($this->query,ARRAY_A);
        if(!$result)$this->errno = Mi::ERR_GET; 
        return $result; 
    }
    
}

interface ModelInterface{
    //Numbers
    const ERR_GET = 21;

    //Messages
    const ERR_GET_MSG = "Errore durante la lettura dei dati";
}
?>