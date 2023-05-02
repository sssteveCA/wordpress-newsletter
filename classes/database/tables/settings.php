<?php

namespace Newsletter\Classes\Database\Tables;

class Settings extends Table{

    public function __construct(array $data){
        parent::__construct($data);
        $this->setSqlCreate();
    }

    public function getError(){
        if($this->errno < parent::MAX_TABLE)return parent::getError();
        else{
            switch($this->errno){
                default:
                    $this->error = null;
                    break;
            }
        }
        return $this->error;
    }

    /**
     * Set the creation query for the settings table
     */
    private function setSqlCreate(): void{
        $this->sql_create = <<<SQL
CREATE TABLE `{$this->fullTableName}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_name` varchar(100) NOT NULL,
  `setting_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`setting_value`)),
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_name` (`setting_name`)
) ENGINE=InnoDB {$this->charset}
SQL;
    }

    /**
     * Drop the settings table
     */
    public function dropTable(): bool{
        return parent::dropTable();
    }
}
?>