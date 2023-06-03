<?php

namespace Newsletter\Classes\Database;

use Newsletter\Classes\Database\ModelErrors as Me;
use Newsletter\Classes\Database\Tables\Table;
use Newsletter\Classes\Database\Tables\TableErrors;
use Newsletter\Traits\ErrorTrait;
use Newsletter\Traits\ModelTrait;
use Newsletter\Traits\SqlTrait;
use wpdb;

interface ModelErrors extends TableErrors{
    //Numbers
    const ERR_GET = 21;
    const ERR_DELETE = 22;
    const ERR_INSERT = 23;
    const ERR_UPDATE = 24;
    const ERR_GET_NO_RESULT = 25;

    //Messages
    const ERR_GET_MSG = "Errore durante la lettura dei dati";
    const ERR_DELETE_MSG = "Errore durante l'eliminazione dei dati";
    const ERR_INSERT_MSG = "Errore durante l'inserimento dei dati";
    const ERR_UPDATE_MSG = "Errore durante l'aggiornamento dei dati";
    const ERR_GET_NO_RESULT_MSG = "La query di lettura non ha restituito alcun risultato";
}

abstract class Model extends Table implements Me{

    use ModelTrait;

    /**
     * Max Errno number + 1 assignable to Model class
     */
    const MAX_MODEL = 40;

    public function __construct(array $data)
    {
        parent::__construct($data);
    }

    protected function getError(){
        if($this->errno < parent::MAX_TABLE){
            return parent::getError();
        }
        switch($this->errno){
            case Me::ERR_GET:
                $this->error = Me::ERR_GET_MSG;
                break;
            case Me::ERR_DELETE:
                $this->error = Me::ERR_DELETE_MSG;
                break;
            case Me::ERR_INSERT:
                $this->error = Me::ERR_INSERT_MSG;
                break;
            case Me::ERR_UPDATE:
                $this->error = Me::ERR_UPDATE_MSG;
                break;
            case Me::ERR_GET_NO_RESULT:
                $this->error = Me::ERR_GET_NO_RESULT_MSG;
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
        $this->query = $this->wpdb->prepare($sql,$values);
        $del = $this->wpdb->query($this->query);
        if(!$del)$this->errno = Me::ERR_DELETE;
        return $del;
    }

    /**
     * Get a single row with SELECT query
     */
    protected function get(string $query, array $values){
        $this->errno = 0;
        $sql = <<<SQL
SELECT * FROM `{$this->fullTableName}` {$query} LIMIT 1;
SQL;
        $this->query = $this->wpdb->prepare($sql,$values);
        //file_put_contents("log.txt","Model get query => ".var_export($this->query,true)."\r\n",FILE_APPEND);
        $this->queries[] = $this->query;
        $result = $this->wpdb->get_row($this->query,ARRAY_A);
        if(!$result)$this->errno = Me::ERR_GET; 
        if($this->wpdb->num_rows < 1)$this->errno = Me::ERR_GET_NO_RESULT;
        return $result; 
    }

    /**
     * Insert a single row with INSERT query
     */
    protected function insert(array $data, array|string $format = null){
        $this->errno = 0;
        $insert = $this->wpdb->insert($this->fullTableName,$data,$format);
        $this->query = $this->wpdb->last_query;
        //file_put_contents("log.txt","model.php insert query =>".var_export($this->query,true)."\r\n",FILE_APPEND);
        $this->queries[] = $this->query;
        if(!$insert)$this->errno = Me::ERR_INSERT;
        return $insert;
    }

    /**
     * Update a single row with UPDATE query
     */
    protected function update(array $set, array $where = []){
        $this->errno = 0;
        $values = [];
        $sets = "";
        $wheres = "";
        $setData = $this->getUpdateSetString($set);
        $sets .= $setData['string'];
        $values = $setData['values'];
        if(count($where) > 0){
            $whereData = $this->getUpdateWhereString($where);
            $wheres .= $whereData['string'];
            $values = array_merge($values, $whereData['values']);
        }//if(count($where) > 0){
        $sql = <<<SQL
UPDATE `{$this->fullTableName}` SET {$sets} {$wheres} LIMIT 1;
SQL;
        $this->query = $this->wpdb->prepare($sql,$values);
        $this->queries[] = $this->query;
        $update = $this->wpdb->query($this->query);
        if(!$update)$this->errno = Me::ERR_UPDATE;
        return $update;
    }
    
}


?>