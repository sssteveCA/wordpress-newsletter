<?php

namespace Newsletter\Traits;

trait SqlTrait{

    /**
     * Last DB Query executed
     */
    protected string $query;

    /**
     * List of DB Queries executed
     */
    protected array $queries;

    public function getQuery(){return $this->query;}
    public function getQueries(){return $this->queries;}
}
?>