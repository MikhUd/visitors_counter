<?php

namespace MikhUd\VisitCounter\Engine\Database;

class DatabaseConnector {

    private $PDO;

    public function __construct()
    {
        $dbConfig['dsn'] = 'mysql:dbname=stats;host=localhost;port=3306;charset=UTF8';
        $dbConfig['username'] = 'root';
        $dbConfig['password'] = '89045781364Vbif';
        $dbConfig['options'] = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        ];

        $this->PDO = new \PDO($dbConfig['dsn'], $dbConfig['username'], $dbConfig['password'], $dbConfig['options']);
    }

    public function getPDO()
    {
        return $this->PDO;
    }
}