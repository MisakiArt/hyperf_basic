<?php

declare(strict_types=1);

namespace App\Tools;

use Hyperf\Context\Context;
use Hyperf\Engine\Coroutine;

class CoroutineHelper
{

    protected static array $defaultExcludedContextKeyPre = [
        "ResponseInterface",
        "database.connection",
        "redis",
        "http_client",
        "stream"
    ];


    /**
     * 启动一个安全的协程，并捕获异常
     * @param callable $callback 需要执行的协程逻辑
     * @param callable|null $onException 发生异常时的回调
     */
    public static function safeGo(callable $callback, ?callable $onException = null): void
    {
        $safeContextKey = self::getSafeContextKey();
        $current_coroutine_id = Coroutine::id();
        Coroutine::create(function () use ($callback, $onException,$current_coroutine_id,$safeContextKey) {
            Context::copy($current_coroutine_id,$safeContextKey);
            try {
                $callback();
            } catch (\Throwable $e) {
                self::handleException($e, $onException);
            }
        });
    }



    public static function getSafeContextKey() :array{
        $currentCoroutineId = Coroutine::id();
        $context  = Coroutine::getContextFor($currentCoroutineId);
        $safeContext = [];
        foreach ($context as $key =>$v) {
            foreach (self::$defaultExcludedContextKeyPre as $keyPre) {
                if (str_contains($key, $keyPre)) {
                    continue 2;
                }
            }
            $safeContext[] = $key;
        }
        return $safeContext;
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
