<?php

namespace Newsletter\Classes\Database\Tables;

use Newsletter\Exceptions\NotSettedException;
use Newsletter\Classes\Database\Tables\TableErrors as Te;
use Newsletter\Traits\ErrorTrait;
use Newsletter\Traits\SqlTrait;
use wpdb;

abstract class Table implements Te{

    use SqlTrait, ErrorTrait;

    /**
     * Wordpress database object
     */
    protected wpdb $wpdb;
    /**
     * Table name (no prefix)
     */
    protected string $tableName;
    /**
     * Table name (with prefix)
     */
    protected string $fullTableName;
    /**
     * The charset used by the table
     */
    protected string $charset;
    /**
     * SQL to create the table
     */
    protected string $sql_create;
    /**
     * SQL to drop the table
     */
    protected string $sql_drop;

    /**
     * Max Errno number + 1 assignable to Table class
     */
    const MAX_TABLE = 20;

    public function __construct(array $data){
        global $wpdb;
        $this->wpdb = $wpdb;
        $ok = $this->assignValues($data);
        if(!$ok)throw new NotSettedException(Te::NOTISSET_EXC);
    }

    public function getTableName(){return $this->name;}
    public function getFullTableName(){return $this->fullTableName;}
    public function getCharset(){return $this->charset;}
    public function getSqlCreate(){return $this->sql_create;}
    public function getSqlDrop(){return $this->sql_drop;}

    protected function getError(){
        switch($this->errno){
            case Te::NOT_DROPPED:
                $this->error = Te::NOT_DROPPED_MSG;
                break;
            default:
                $this->error = null;
                break;
        }
        return $this->error;
    }

    /**
     * Assign the entry data to the proper properties
     */
    private function assignValues(array $data): bool{
        $isset = false;
        if(isset($data['tableName'])){
            $this->tableName = $data['tableName'];
            $this->charset = $this->wpdb->get_charset_collate();
            $this->fullTableame = $this->wpdb->prefix.$this->tableName;
            $this->sql_drop = <<<SQL
DROP TABLE `{$this->fullTableName}`;
SQL;
        }//if(isset($data['name'])){
        return $isset;
    }

    /**
     * Drop an existing table in database
     */
    protected function dropTable(): bool{
        $this->errno = 0;
        $deleted = false;
        $this->query = $this->sql_drop;
        if($this->wpdb->query($this->query) === true)$deleted = true;
        else $this->errno = Te::NOT_DROPPED;
        return $deleted;
    }
}

interface TableErrors{
    //Exceptions
    const NOTISSET_EXC = "Non sono stati forniti i dati richiesti";

    //Codes
    const NOT_DROPPED = 1;

    //Messages
    const NOT_DROPPED_MSG = "La tabella non è stata rimossa";

}
?>