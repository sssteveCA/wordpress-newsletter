<?php

namespace Newsletter\Classes\Database;

abstract class Table{
    private string $name;

    public function __construct(array $data){
        $this->assignValues($data);
    }

    public function getName(): string{return $this->name;}

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
?>