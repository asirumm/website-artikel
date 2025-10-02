<?php


use App\Controllers\Api\ContentImageController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('api' ,static function ($routes) {

$routes->post('content-image', [ContentImageController::class, 'create']);

});
