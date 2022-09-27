<?php

namespace Newsletter\Classes\Database\Tables;

use Newsletter\Exceptions\NotSettedException;
use Newsletter\Classes\Database\Tables\TableErrors as Te;
use Newsletter\Traits\ErrorTrait;
use Newsletter\Traits\SqlTrait;
use wpdb;

abstract class Table implements Te{

    use SqlTrait, ErrorTrait;

    protected wpdb $wpdb;
    protected string $name;
    protected string $fullname;
    protected string $charset;
    protected string $sql_create;
    protected string $sql_drop;

    public function __construct(array $data){
        global $wpdb;
        $this->wpdb = $wpdb;
        $ok = $this->assignValues($data);
        if(!$ok)throw new NotSettedException(Te::NOTISSET_EXC);
    }

    public function getName(){return $this->name;}
    public function getFullName(){return $this->fullname;}
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
        if(isset($data['name'])){
            $this->name = $data['name'];
            $this->charset = $this->wpdb->get_charset_collate();
            $this->fullname = $this->wpdb->prefix.$this->name;
            $this->sql_drop = <<<SQL
DROP TABLE `{$this->fullname}`;
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