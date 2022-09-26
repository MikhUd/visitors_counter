<?php

namespace MikhUd\VisitCounter\Engine\Database;

class DatabaseRepository
{
    const TABLES = [
        'visits' => 'visits',
        'ips' => 'ips'
    ];

    public function __construct(
        private $databaseConnector = new DatabaseConnector()
    ) {}

    private function truncateTables($PDO): void
    {
        foreach (self::TABLES as $table) {
            $stmt = $PDO->prepare("TRUNCATE TABLE " . $table);
            $stmt->execute();
        }
    }

    public function updateForFirstDailyVisitor(array $data): void
    {
        $PDO = $this->databaseConnector->getPDO();
        $this->truncateTables($PDO);
        [$ip, $date] = $data;
        $stmt = $PDO->prepare("INSERT INTO `ips` SET `ip_address` = '$ip'");
        $stmt->execute();
        $stmt = $PDO->prepare("INSERT INTO `visits` SET `date` = '$date', `hosts` = 1, `views` = 1");
        $stmt->execute();
    }

    public function updateCountWithUniqueIP(array $data): void
    {
        $PDO = $this->databaseConnector->getPDO();
        [$ip, $date] = $data;
        $stmt = $PDO->prepare("INSERT INTO `ips` SET `ip_address` = '$ip'");
        $stmt->execute();
        $stmt = $PDO->prepare("UPDATE `visits` SET `hosts`=`hosts`+1, `views`=`views`+1 WHERE `date`='$date'");
        $stmt->execute();
    }

    public function updateCountWithExistsIP(string $date): void
    {
        $PDO = $this->databaseConnector->getPDO();
        $stmt = $PDO->prepare("UPDATE `visits` SET `views`=`views`+1 WHERE `date`='$date'");
        $stmt->execute();
    }

    public function isAnyVisitsToday(string $date): bool
    {
        $PDO = $this->databaseConnector->getPDO();
        $stmt = $PDO->query("SELECT `id` FROM  `visits` WHERE `date` = '$date'");

        return !empty($stmt->fetchAll());
    }

    public function isCurrentIPInDB(string $ip): bool
    {
        $PDO = $this->databaseConnector->getPDO();
        $stmt = $PDO->query("SELECT `id` FROM  `ips` WHERE `ip_address` = '$ip'");

        return !empty($stmt->fetchAll());
    }

    public function getDailyStatistic(string $date): array
    {
        $PDO = $this->databaseConnector->getPDO();
        $stmt = $PDO->query("SELECT `views`, `hosts` FROM  `visits` WHERE `date` = '$date'");

        return $stmt->fetchAll();
    }
}