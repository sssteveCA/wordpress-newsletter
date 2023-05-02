<?php

namespace Newsletter\Classes\Database\Tables;

class Users extends Table{

    public function __construct(array $data)
    {
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
     * Set the creation query for the users table
     */
    private function setSqlCreate(): void{
        $this->sql_create = <<<SQL
CREATE TABLE `{$this->fullTableName}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastName` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'User language code',
  `verCode` varchar(191) DEFAULT NULL COMMENT 'Verification code ',
  `unsubscCode` varchar(191) DEFAULT NULL COMMENT 'Unsubscribe code',
  `subscribed` tinyint(1) DEFAULT 0 COMMENT '0 = email not verified\r\n1 = email verified',
  `subscDate` datetime DEFAULT NULL COMMENT 'Date which user requested the subscribe to the newsletter',
  `actDate` datetime DEFAULT NULL COMMENT 'Date which user activated his account',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB {$this->charset};
SQL;
    }

    /**
     * Drop the users table
     */
    public function dropTable(): bool{
        return parent::dropTable();
    }
}

?>