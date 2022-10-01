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

    /**
     * Delete a single row with DELETE query
     */
    protected function delete(array $where, array $where_f = []){
        $this->errno = 0;
        $delete = $this->wpdb->delete($this->fullTableName,$where,$where_f);
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
        return $result;
    }
}

interface ModelsErrors{
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