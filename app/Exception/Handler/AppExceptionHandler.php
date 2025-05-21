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

namespace App\Exception\Handler;

use App\Tools\Log;
use Hyperf\Context\Context;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

class AppExceptionHandler extends ExceptionHandler
{
    public function __construct(protected StdoutLoggerInterface $logger)
    {
    }

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->logger->error(sprintf('%s[%s] in %s', $throwable->getMessage(), $throwable->getLine(), $throwable->getFile()));
        $this->logger->error($throwable->getTraceAsString());
        Log::get()->error(sprintf('%s[%s] in %s', $throwable->getMessage(), $throwable->getLine(), $throwable->getFile()),$this->buildErrorMessage($throwable));
        return $response->withHeader('Server', 'Hyperf')
            ->addHeader('content-type', 'application/json; charset=utf-8')
            ->withStatus(500)->withBody(new SwooleStream(
        json_encode([
            'code' => -1,
            'msg' => '系统异常，请稍后再试。',
            'data' => []
        ])
        ));
    }

    function getFullUrl($request): string
    {
        $scheme = $request->getUri()->getScheme();  // 获取协议 (http/https)
        $host = $request->getUri()->getHost();      // 获取域名
        $port = $request->getUri()->getPort();      // 获取端口
        $path = $request->getUri()->getPath();      // 获取路径
        $query = $request->getUri()->getQuery();    // 获取查询参数

        // 组合 URL（处理默认端口）
        $portPart = ($port && !in_array($port, [80, 443])) ? ":$port" : '';
        $queryPart = $query ? "?$query" : '';

        return "{$scheme}://{$host}{$portPart}{$path}{$queryPart}";
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }


    public function buildErrorMessage(Throwable $throwable): array
    {
        $request = Context::get(ServerRequestInterface::class);
        return   [
            "method"=>$request->getMethod(),
            "uri"=>$this->getFullUrl($request),
            'body'=>$request->getParsedBody(),
            "headers"=>$request->getHeaders(),
            "exception"=>$throwable,
        ];
    }
}
