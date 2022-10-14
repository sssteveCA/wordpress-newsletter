<?php

namespace Newsletter\Traits;

/**
 * Trait used by Model class
 */
trait ModelTrait{

    /**
     * Get the update query SET data ready for prepare
     */
    private function getUpdateSetString(array $setArray): array{
        $sets = "";
        $values = [];
        $setArrayMap = array_map(function($item){
            if($item == NULL)return 'NULL';
            else return $item;
        },$setArray);
        foreach($setArrayMap as $col => $val){
            if(is_numeric($val))$format = "%d";
            else $format = "%s";
            $sets .= "`{$col}` = {$format}"; 
            array_push($values,$val);
            if($val != end($setArrayMap)){
                //If is not last loop
                $sets .= ",";
            }
        }
        return [
            'string' => $sets,
            'values' => $values
        ];
    }

    /**
     * Get the update query WHERE data ready for prepare
     */
    private function getUpdateWhereString(array $whereArray): array{
        $wheres = "WHERE ";
        $values = [];
        $whereArrayMap = array_map(function($item){
            if($item == NULL)return "NULL";
            else return $item;
        },$whereArray);
        foreach($whereArrayMap as $col => $val){
            if(is_numeric($val))$format = "%d";
            else $format = "%s";
            $wheres .= "`{$col}` = {$format} ";
            array_push($values, $val);
            if($val != end($whereArrayMap)){
                $wheres .= "AND ";
            }
        }//foreach($where as $col => $val){
        return [
            'string' => $wheres,
            'values' => $values
        ];
    }
}
?>