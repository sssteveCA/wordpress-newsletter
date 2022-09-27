<?php

namespace Newsletter\Classes\Database\Tables;

use Newsletter\Exceptions\NotSettedException;
use Newsletter\Classes\Database\Tables\TableErrors as Te;

abstract class Table implements Te{
    private string $name;

    public function __construct(array $data){
        $ok = $this->assignValues($data);
        if(!$ok)throw new NotSettedException(Te::NOTISSET_EXC);
    }

    public function getName(){return $this->name;}

    /**
     * Assign the entry data to the proper properties
     */
    private function assignValues(array $data): bool{
        $isset = false;
        if(isset($data['name'])){
            $this->name = $data['name'];
        }//if(isset($data['name'])){
        return $isset;
    }
}

interface TableErrors{
    const NOTISSET_EXC = "Non sono stati forniti i dati richiesti";
}
?>