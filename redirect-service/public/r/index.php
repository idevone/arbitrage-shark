<?php

require_once __DIR__ . '/../../src/Controllers/RedirectController.php';
require_once __DIR__ . '/../../src/Router.php';

$router = new Router();
$controller = new RedirectController();

$router->add('/r/id(\d+)', [$controller, 'redirect']); // Динамический маршрут для перенаправления с ID
$router->add('/r', [$controller, 'index']); // Маршрут для главной страницы

$router->dispatch();
