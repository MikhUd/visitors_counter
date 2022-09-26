<?php

namespace MikhUd\VisitCounter\Engine;

class Router
{
    private array $map = [];

    public function get($path, $params): void
    {
        $this->setParams($this->map['GET'][$path], $params);
    }

    private function setParams(&$currentMap, $params):void
    {
        $currentMap = ['controller' => 'MikhUd\VisitCounter\Engine\\' . $params[0], 'method' => $params[1]];
    }

    public function getCurrentParams()
    {
        $method = $_SERVER['REQUEST_METHOD'];

        return $this->map[mb_strtoupper($method)][$_SERVER['REQUEST_URI']];
    }
}