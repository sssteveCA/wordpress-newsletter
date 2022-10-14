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
        foreach($setArray as $col => $val){
            if(is_numeric($val))$format = "%d";
            else $format = "%s";
            $sets .= "`{$col}` = {$format}"; 
            array_push($values,$val);
            if($val != end($set)){
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
        foreach($whereArray as $col => $val){
            if(is_numeric($val))$format = "%d";
            else $format = "%s";
            $wheres .= "`{$col}` = {$format} ";
            array_push($values, $val);
            if($val != end($where)){
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