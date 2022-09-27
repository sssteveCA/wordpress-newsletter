<?php

namespace Newsletter\Classes\Database\Tables;

class Users extends Table{

    private string $sql_create;
    private string $sql_drop;

    public function __construct(array $data)
    {
        parent::__construct($data);
    }

    public function getSqlCreate(){return $this->sql_create;}
    public function getSqlDrop(){return $this->sql_drop;}
}

?>