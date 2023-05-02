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
             'lang_status' => $this->lang_status,
             'included_pages_status' => $this->included_pages_status,
             'socials_status' => $this->socials_status,
             'social_pages' => $this->social_pages,
             'contact_pages' => $this->contact_pages,
             'privacy_policy_pages' => $this->privacy_policy_pages
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