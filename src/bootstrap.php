<?php

use App\Controllers\AnalyticsController;
use App\Controllers\ParentController;
use App\Database\Connection;
use App\Repositories\NotificationRepository;
use App\Repositories\ParentRepository;
use App\Repositories\StudentRepository;
use App\Services\Analytics\ParentEngagementService;
use App\Services\Communication\NotificationService;

require __DIR__ . '/autoload.php';

$config = require __DIR__ . '/../config/config.php';
$pdo = Connection::make($config['db']);

$parentRepository = new ParentRepository($pdo);
$studentRepository = new StudentRepository($pdo);
$notificationRepository = new NotificationRepository($pdo);
$notificationService = new NotificationService($notificationRepository);
$parentAnalytics = new ParentEngagementService($parentRepository, $studentRepository);

return [
    ParentController::class => new ParentController(
        $parentRepository,
        $studentRepository,
        $parentAnalytics,
        $notificationService
    ),
    AnalyticsController::class => new AnalyticsController($parentAnalytics),
];
