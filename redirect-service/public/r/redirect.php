<?php

require_once '../../src/Controllers/RedirectController.php';

$controller = new RedirectController();

// Получаем ID канала из параметра запроса
$channelId = $_GET['id'] ?? '';

// Выполняем редирект на основе полученного идентификатора
$controller->redirect($channelId);