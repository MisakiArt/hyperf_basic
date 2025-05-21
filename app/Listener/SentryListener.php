<?php

declare(strict_types=1);

namespace App\Listener;

use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\ExceptionHandler\Formatter\FormatterInterface;
use Hyperf\Framework\Event\AfterWorkerStart;
use Hyperf\Logger\LoggerFactory;
use Psr\Container\ContainerInterface;
use Sentry\State\HubInterface;
use Throwable;

class SentryListener implements ListenerInterface
{
    protected HubInterface $sentryHub;
    protected FormatterInterface $formatter;
    protected LoggerFactory $loggerFactory;

    public function __construct(ContainerInterface $container)
    {
        $this->sentryHub = $container->get(HubInterface::class);
        $this->formatter = $container->get(FormatterInterface::class);
        $this->loggerFactory = $container->get(LoggerFactory::class);
    }

    public function listen(): array
    {
        return [
            AfterWorkerStart::class, // 监听 Hyperf 进程启动事件
        ];
    }

    public function process(object $event): void
    {
        // 绑定 Sentry 到 Hyperf 日志系统
        $logger = $this->loggerFactory->get('sentry');
        set_exception_handler(function (Throwable $exception) use ($logger) {
            $logger->error($this->formatter->format($exception));
            $this->sentryHub->captureException($exception);
        });
    }
}
