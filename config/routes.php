<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

use Hyperf\Context\ApplicationContext;
use Hyperf\HttpServer\Router\Router;



Router::addGroup('/api/hrsystem',function (){

    Router::addGroup('/user/',function () {
        Router::post('login', 'App\Controller\UserController@login');
        Router::post('logout', 'App\Controller\UserController@logout');
        Router::post('user', 'App\Controller\UserController@user');
    });
});


Router::addRoute(['GET'], '/health', function () {
    return 'ok';
});

Router::addRoute(['GET'], '/metrics', function () {
    $client = ApplicationContext::getContainer()->get(\Hyperf\Guzzle\ClientFactory::class)->create();
    $response = $client->request('GET', 'http://127.0.0.1:9502/metrics' , [
        'timeout' => 5,
        'headers' => [
            'Accept' => 'application/json',
        ],
    ]);

    return $response->getBody()->getContents();
//    $registry = Hyperf\Context\ApplicationContext::getContainer()->get(Prometheus\CollectorRegistry::class);
//    $renderer = new Prometheus\RenderTextFormat();
//    return $renderer->render($registry->getMetricFamilySamples());
});

Router::addRoute(['POST'], '/test', 'App\Controller\IndexController@test');


Router::get('/favicon.ico', function () {
    return '';
});
