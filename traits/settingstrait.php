<?php

namespace Newsletter\Traits;

/**
 * Trait used by Settings class
 */
trait SettingsTrait{

    /**
     * Create the insert query for settings table
     */
    private function setInsertQuery(): array{
        $array_values = [
             'lang_status' => json_encode($this->lang_status,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE),
             'included_pages_status' => json_encode($this->included_pages_status,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE),
             'socials_status' => json_encode($this->socials_status,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE),
             'social_pages' => json_encode($this->social_pages,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE),
             'contact_pages' => json_encode($this->contact_pages,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE),
             'privacy_policy_pages' => json_encode($this->privacy_policy_pages,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)        
        ];
        $columns = "(";
        $values = [];
        $value_formats = "(";
        foreach($array_values as $column => $value){
            $columns .= "`{$column}`";
            array_push($values,$value);
            $value_formats .= "%s";
            if(array_key_last($array_values) != $column){
                $columns .= ",";
                $value_formats .= ",";
            }
        }
        $columns .= ")";
        $value_formats .= ")";
        $sql = <<<SQL
INSERT INTO `{$this->fullTableName}` {$columns} VALUES {$value_formats} ;
SQL;
        return [ 'sql' => $sql, 'values' => $values ];
    }
}
?>