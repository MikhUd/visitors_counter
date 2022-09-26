<?php

namespace MikhUd\VisitCounter\Engine\Services;

use MikhUd\VisitCounter\Engine\Database\DatabaseRepository;

class VisitorsService
{
    public function __construct(
        private $databaseRepository = new DatabaseRepository()
    ) {}

    public function process()
    {
        $visitorIP = $_SERVER['REMOTE_ADDR'];
        $date = date("Y-m-d");
        $isAnyVisitsToday = $this->databaseRepository->isAnyVisitsToday($date);
        if (!$isAnyVisitsToday) {
            $this->databaseRepository->updateForFirstDailyVisitor([$_SERVER['REMOTE_ADDR'], $date]);
        }
        $isCurrentIPInDB = $this->databaseRepository->isCurrentIPInDB($_SERVER['REMOTE_ADDR']);
        if ($isCurrentIPInDB) {
            $this->databaseRepository->updateCountWithExistsIP($date);
        } else {
           $this->databaseRepository->updateCountWithUniqueIP([$_SERVER['REMOTE_ADDR'], $date]); 
        }
        
        return $this->databaseRepository->getDailyStatistic($date)[0];
    }
}