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
            case Mi::ERR_DELETE:
                $this->error = Mi::ERR_DELETE_MSG;
            default:
                $this->error = null;
                break;
        }
        return $this->error = null;
    }

    /**
     * Delete a single row with DELETE query
     */
    protected function delete(string $query, array $values){
        $this->errno = 0;
        $sql = <<<SQL
DELETE FROM {$this->fullTableName} {$query} LIMIT 1;
SQL;
        $this->query = $this->wpdb->prepare($query,$values);
        $del = $this->wpdb->query($this->query);
        if(!$del)$this->errno = Mi::ERR_DELETE;
        return $del;
    }

    /**
     * Get a single row with SELECT query
     */
    protected function get(string $query, array $values){
        $this->errno = 0;
        $sql = <<<SQL
SELECT * FROM {$this->fullTableName} {$query} LIMIT 1;
SQL;
        $this->query = $this->wpdb->prepare($sql);
        $this->queries[] = $this->query;
        $result = $this->wpdb->get_row($this->query,ARRAY_A);
        if(!$result)$this->errno = Mi::ERR_GET; 
        return $result; 
    }
    
}

interface ModelInterface{
    //Numbers
    const ERR_GET = 21;
    const ERR_DELETE = 22;

    //Messages
    const ERR_GET_MSG = "Errore durante la lettura dei dati";
    const ERR_DELETE_MSG = "Errore durante l'eliminazione dei dati";
}
?>