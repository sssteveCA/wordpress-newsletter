<?php

namespace Newsletter\Classes\Database;

use Newsletter\Classes\Database\Tables\Table;
use Newsletter\Classes\Database\ModelsErrors as Me;
use Newsletter\Classes\Database\Tables\TableErrors;
use Newsletter\Traits\ErrorTrait;
use Newsletter\Traits\SqlTrait;

abstract class Models extends Table implements Me{

    /**
     * Max error code + 1 assignable to Models class
     */
    const MAX_MODELS = 40;

    public function __construct(array $data){
        parent::__construct($data);
    }

    protected function getError(){
        if($this->errno < parent::MAX_TABLE){
            return parent::getError();
        }
        else{
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
        }
        return $this->error;
    }

    /**
     * Delete a single or multiple rows with DELETE query
     */
    protected function delete(array $where, array $where_f = []){
        $this->errno = 0;
        $delete = $this->wpdb->delete($this->fullTableName,$where,$where_f);
        $this->query = $this->wpdb->last_query;
        $this->queries[] = $this->query;
        if(!$delete)$this->errno = Me::ERR_DELETE;
        return $delete;
    }

    /**
     * Get a single or multiple rows with SELECT query
     */
    protected function get(string $query, array $values){
        $this->errno = 0;
        $sql = <<<SQL
SELECT * FROM {$this->fullTableName} {$query};
SQL;
        $this->query = $this->wpdb->prepare($sql,$values);
        $this->queries[] = $this->query;
        $result = $this->wpdb->get_results($this->query, ARRAY_A);
        if(!$result)$this->errno = Me::ERR_GET;
        if($this->wpdb->num_rows < 1)$this->errno = Me::ERR_GET_NO_RESULT;
        return $result;
    }

    /**
     * Insert a single or multiple rows with INSERT query
     */
    protected function insert(string $sql, array $values){
        $this->errno = 0;
        $this->query = $this->wpdb->prepare($sql, $values);
        $insert = $this->wpdb->query($this->query);
        $this->queries[] = $this->query;
        if(!$insert)$this->errno = Me::ERR_INSERT;
        return $insert;
    }

    /**
     * Update a single or multiple rows with UPDATE query
     */
    protected function update(array $data, array $where, array $format = [], array $where_f){
        $this->errno = 0;
        $update = $this->wpdb->update($this->fullTableName,$data,$where,$format,$where_f);
        $this->query = $this->wpdb->last_query;
        $this->queries[] = $this->query;
        if(!$update)$this->errno = Me::ERR_UPDATE;
        return $update;
    }
}

interface ModelsErrors extends TableErrors{
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
?>