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
return [
    'scan' => [
        'paths' => [
            BASE_PATH . '/app',
        ],
        'ignore_annotations' => [
            'mixin',
        ],
        'class_map'=>[
            Fan\Feishu\Oauth\OauthProvider::class => BASE_PATH . '/classmap/OauthProvider.php',
            Fan\Feishu\Message\MessageProvider::class => BASE_PATH . '/classmap/MessageProvider.php',
            Smalot\PdfParser\Font::class => BASE_PATH . '/classmap/Font.php',
        ]
    ],
];
