<?php

use App\Controllers\AnalyticsController;
use App\Controllers\ParentController;
use App\Core\Request;
use App\Core\Response;

return static function (\App\Core\Router $router, array $container): void {
    /** @var ParentController $parentController */
    $parentController = $container[ParentController::class];
    /** @var AnalyticsController $analyticsController */
    $analyticsController = $container[AnalyticsController::class];

    $router->get('/api/parents', function (Request $request, array $params = []) use ($parentController): Response {
        return $parentController->index();
    });

    $router->get('/api/parents/{id}', function (Request $request, array $params = []) use ($parentController): Response {
        return $parentController->show($params);
    });

    $router->post('/api/parents/{id}/feedback', function (Request $request, array $params = []) use ($parentController): Response {
        return $parentController->feedback($request, $params);
    });

    $router->get('/api/parents/{studentId}/student', function (Request $request, array $params = []) use ($parentController): Response {
        return $parentController->studentSnapshot($params);
    });

    $router->get('/api/analytics/parent-engagement', function (Request $request, array $params = []) use ($analyticsController): Response {
        return $analyticsController->parentEngagement($request);
    });
};
