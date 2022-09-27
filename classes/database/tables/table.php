<?php

namespace Newsletter\Classes\Database\Tables;

use Newsletter\Exceptions\NotSettedException;
use Newsletter\Classes\Database\Tables\TableErrors as Te;
use wpdb;

abstract class Table implements Te{
    protected wpdb $wpdb;
    protected string $name;
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
    public function getCharset(){return $this->charset;}
    public function getSqlCreate(){return $this->sql_create;}
    public function getSqlDrop(){return $this->sql_drop;}

    /**
     * Assign the entry data to the proper properties
     */
    private function assignValues(array $data): bool{
        $isset = false;
        if(isset($data['name'])){
            $this->name = $data['name'];
            $this->charset = $this->wpdb->get_charset_collate();
        }//if(isset($data['name'])){
        return $isset;
    }
}

interface TableErrors{
    const NOTISSET_EXC = "Non sono stati forniti i dati richiesti";
}
?>