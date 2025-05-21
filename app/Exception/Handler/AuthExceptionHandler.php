<?php

declare(strict_types=1);
/**
 * This file is part of qbhy/hyperf-auth.
 *
 * @link     https://github.com/qbhy/hyperf-auth
 * @document https://github.com/qbhy/hyperf-auth/blob/master/README.md
 * @contact  qbhy0715@qq.com
 * @license  https://github.com/qbhy/hyperf-auth/blob/master/LICENSE
 */
namespace App\Exception\Handler;

use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Qbhy\HyperfAuth\Exception\UnauthorizedException;
use Throwable;

class AuthExceptionHandler extends \Qbhy\HyperfAuth\AuthExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->stopPropagation();
        return $response->withStatus($throwable->getStatusCode())
            ->addHeader('content-type', 'application/json; charset=utf-8')
            ->withBody(new SwooleStream(json_encode([
            'code' => -1,
            'msg' => 'Unauthorized.'.$throwable->getMessage(),
            'data' => []
        ])));
    }
}
