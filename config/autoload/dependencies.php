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

use Sentry\ClientBuilder;
use Sentry\State\Hub;
use Sentry\State\HubInterface;
use Psr\Container\ContainerInterface;
use function Hyperf\Support\env;

return [
    Hyperf\HttpServer\CoreMiddleware::class => App\Middleware\CoreMiddleware::class,
    HubInterface::class => static function (ContainerInterface $container) {
        // 配置 Sentry 客户端
        $client = ClientBuilder::create([
            'dsn' => env('SENTRY_DSN'),
            'environment' => env('APP_ENV','production'),
            'release' => env('APP_VERSION','1.0.0'),
            'traces_sample_rate' => 1.0,
            'http_connect_timeout'=>1,
            'sample_rate'=>  (int)env('SENTRY_SAMPLE_RATE',0),
        ])->getClient();
        return new Hub($client);  // 返回 Hub 实例
    },
];
