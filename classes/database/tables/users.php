<?php

namespace Newsletter\Classes\Database\Tables;

class Users extends Table{

    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->setSqlCreate();
    }

    /**
     * Set the creation query for this table
     */
    private function setSqlCreate(): void{
        $this->sql_create = <<<SQL
CREATE TABLE `{$this->name}` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
    `lang` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'User language code',
    `codVer` varchar(191) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT 'Verification code ',
    `codDis` varchar(191) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT 'Unsubscribe code',
    `subscribed` tinyint(1) DEFAULT NULL COMMENT '0 = email not verified\r\n1 = email verified',
    `subscDate` datetime DEFAULT NULL COMMENT 'Date which user requested the subscribe to the newsletter',
    `ActDate` datetime DEFAULT NULL COMMENT 'Date which user activated his account',
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`),
    UNIQUE KEY `codVer` (`codVer`),
    UNIQUE KEY `codDis` (`codDis`)
) ENGINE=InnoDB {$this->charset};
SQL;
    }
}

?>