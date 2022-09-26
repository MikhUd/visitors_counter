<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require '../vendor/autoload.php';

use MikhUd\VisitCounter\Engine\App;
use MikhUd\VisitCounter\Engine\Router;

$router = new Router();
$router->get('/', ['VisitorsController', 'index']);

$app = new App($router);
$app->run();