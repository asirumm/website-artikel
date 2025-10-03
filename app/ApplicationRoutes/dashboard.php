<?php

use App\Controllers\Api\ArticleApiController;
use App\Controllers\View\DashboardController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('dashboard' ,static function ($routes) {
    $routes->get('', [DashboardController::class, 'index']);
});