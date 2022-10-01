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
        if($this->errno < Table::MAX_ERRNO){
            return parent::getError();
        }
        switch($this->errno){
            case Mi::ERR_GET:
                $this->error = Mi::ERR_GET_MSG;
                break;
            case Mi::ERR_DELETE:
                $this->error = Mi::ERR_DELETE_MSG;
                break;
            case Mi::ERR_INSERT:
                $this->error = Mi::ERR_INSERT_MSG;
                break;
            case Mi::ERR_UPDATE:
                $this->error = Mi::ERR_UPDATE_MSG;
                break;
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

    /**
     * Insert a single row with INSERT query
     */
    protected function insert(array $data,$format = null){
        $this->errno = 0;
        $insert = $this->wpdb->insert($this->tableName,$data,$format);
        $this->query = $this->wpdb->last_query;
        $this->queries[] = $this->query;
        if(!$insert)$this->errno = Mi::ERR_INSERT;
        return $insert;
    }

    /**
     * Update a single row with UPDATE query
     */
    protected function update(string $set,string $filter,array $values){
        $this->errno = 0;
        $sql = <<<SQL
UPDATE {$this->fullTableName} SET {$set} {$filter} LIMIT 1;
SQL;
        $this->query = $this->wpdb->prepare($sql,$values);
        $this->queries[] = $this->query;
        $update = $this->wpdb->query($this->query);
        if(!$update)$this->errno = Mi::ERR_UPDATE;
        return $update;
    }
    
}

interface ModelInterface{
    //Numbers
    const ERR_GET = 21;
    const ERR_DELETE = 22;
    const ERR_INSERT = 23;
    const ERR_UPDATE = 24;

    //Messages
    const ERR_GET_MSG = "Errore durante la lettura dei dati";
    const ERR_DELETE_MSG = "Errore durante l'eliminazione dei dati";
    const ERR_INSERT_MSG = "Errore durante l'inserimento dei dati";
    const ERR_UPDATE_MSG = "Errore durante l'aggiornamento dei dati";
}
?>