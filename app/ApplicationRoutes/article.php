<?php

use App\Controllers\Api\ArticleApiController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('api/article' ,static function ($routes) {

    $routes->get('', [ArticleApiController::class, 'index']);
    $routes->post('', [ArticleApiController::class, 'create']);
    $routes->get('(:any)', [ArticleApiController::class, 'show']);
    $routes->delete('(:any)', [ArticleApiController::class, 'delete']);

    // CI put tidak bisa form multipart
    $routes->post('(:any)', [ArticleApiController::class, 'update']);

});