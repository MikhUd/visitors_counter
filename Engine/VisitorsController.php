<?php

namespace MikhUd\VisitCounter\Engine;

use MikhUd\VisitCounter\Engine\Services\VisitorsService;

class VisitorsController
{
    private function getVisitorsService(): VisitorsService
    {
        return new VisitorsService();
    }

    public function index(): void
    {
        $statistic = $this->getVisitorsService()->process();
        $total_visitors = $statistic['views'];
        $unique_visitors = $statistic['hosts'];
        require('../views/index.html');
    }
}