<?php

namespace MikhUd\VisitCounter\Engine;

class App
{
    public function __construct(
        private Router $router
    ) {}

    public function run(): void
    {
        $currentRequestParams = $this->router->getCurrentParams();
        $controller = $currentRequestParams['controller'];
        $method = $currentRequestParams['method'];
        (new $controller)->{$method}();
    }
}