<?php

declare(strict_types=1);

namespace App\Tools;

use Hyperf\Coroutine\Coroutine;

class CoroutineHelper
{
    /**
     * 启动一个安全的协程，并捕获异常
     * @param callable $callback 需要执行的协程逻辑
     * @param callable|null $onException 发生异常时的回调
     */
    public static function safeGo(callable $callback, ?callable $onException = null): void
    {
        Coroutine::create(function () use ($callback, $onException) {
            try {
                $callback();
            } catch (\Throwable $e) {
                self::handleException($e, $onException);
            }
        });
    }

    /**
     * 处理异常
     * @param \Throwable $e 捕获的异常
     * @param callable|null $onException 自定义异常处理回调
     */
    protected static function handleException(\Throwable $e, ?callable $onException = null): void
    {
        if ($onException) {
            $onException($e);
        } else {
            // 使用 Hyperf 容器中的日志服务
            $logger = Log::get();
            $logger->error(sprintf("Coroutine exception: %s in %s:%d", $e->getMessage(), $e->getFile(), $e->getLine()));
        }
    }
}
