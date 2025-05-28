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
use function Hyperf\Support\env;
return [
    'default' => [
        'handlers' => [
            [
                'class' => Monolog\Handler\RotatingFileHandler::class,
                'constructor' => [
                    'filename' => BASE_PATH . '/runtime/logs/hyperf.log',
                    'maxFiles' =>30,
                    'level' => env('LOGGER_LEVEL', Monolog\Logger::INFO),
                ],],
            [
                'class' => App\Exception\Handler\SentryFormHandler::class,
                'constructor' => [
                    'hub' => \Hyperf\Context\ApplicationContext::getContainer()->get(Sentry\State\HubInterface::class),
                    'level' => Monolog\Logger::ERROR,
                ],
            ],
        ],
        'formatter' => [
            'class' => \Monolog\Formatter\JsonFormatter::class,
            'constructor' => [
                'format' => null,
                'dateFormat' => null,
                'allowInlineLineBreaks' => true,
            ],
        ],
    ],
];
