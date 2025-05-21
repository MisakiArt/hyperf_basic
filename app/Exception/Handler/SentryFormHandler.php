<?php

declare(strict_types=1);

namespace App\Exception\Handler;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Monolog\LogRecord;
use Sentry\Event;
use Sentry\EventHint;
use Sentry\Monolog\CompatibilityProcessingHandlerTrait;
use Sentry\Stacktrace;
use Sentry\StacktraceBuilder;
use Sentry\State\HubInterface;
use Sentry\State\Scope;

/**
 * This Monolog handler logs every message to a Sentry's server using the given
 * hub instance.
 *
 * @author Stefano Arlandini <sarlandini@alice.it>
 */
class SentryFormHandler extends AbstractProcessingHandler
{
    use CompatibilityProcessingHandlerTrait;

    private const CONTEXT_EXCEPTION_KEY = 'exception';

    /**
     * @var HubInterface
     */
    private $hub;

    /**
     * @var bool
     */
    private $fillExtraContext;

    /**
     * {@inheritdoc}
     *
     * @param HubInterface $hub The hub to which errors are reported
     */
    public function __construct(HubInterface $hub, $level = Logger::DEBUG, bool $bubble = true, bool $fillExtraContext = false)
    {
        parent::__construct($level, $bubble);

        $this->hub = $hub;
        $this->fillExtraContext = $fillExtraContext;
    }

    /**
     * @param array<string, mixed>|LogRecord $record
     */
    protected function doWrite($record): void
    {
        $event = Event::createEvent();
        $event->setLevel(self::getSeverityFromLevel($record['level']));
        $event->setMessage($this->dealMessage($record));
        $event->setLogger(\sprintf('monolog.%s', $record['channel']));

        $hint = new EventHint();

        if (isset($record['context']['exception']) && $record['context']['exception'] instanceof \Throwable) {
            $hint->exception = $record['context']['exception'];
        }
        $this->hub->withScope(function (Scope $scope) use ($record, $event, $hint): void {
            $scope->setExtra('monolog.channel', $record['channel']);
            $scope->setExtra('monolog.level', $record['level_name']);

            $monologContextData = $this->getMonologContextData($record['context']);

            if ($monologContextData !== []) {
                $scope->setExtra('monolog.context', $monologContextData);
            }

            $monologExtraData = $this->getMonologExtraData($record['extra']);

            if ($monologExtraData !== []) {
                $scope->setExtra('monolog.extra', $monologExtraData);
            }

            $this->hub->captureEvent($event, $hint);
        });
    }


    public function dealMessage($record)
    {
        $data = [
            "message" => $record['message'],
        ];
        foreach (["method","uri","body","headers"] as $v) {
            if (!empty($record['context'][$v])) {
                $data[$v] = $record['context'][$v];
            }
        }
        return json_encode($data,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);


    }

    /**
     * @param mixed[] $context
     *
     * @return mixed[]
     */
    private function getMonologContextData(array $context): array
    {
        if (!$this->fillExtraContext) {
            return [];
        }

        $contextData = [];

        foreach ($context as $key => $value) {
            // We skip the `exception` field because it goes in its own context
            if ($key === self::CONTEXT_EXCEPTION_KEY) {
                continue;
            }

            $contextData[$key] = $value;
        }

        return $contextData;
    }

    /**
     * @param mixed[] $context
     *
     * @return mixed[]
     */
    private function getMonologExtraData(array $context): array
    {
        if (!$this->fillExtraContext) {
            return [];
        }

        $extraData = [];

        foreach ($context as $key => $value) {
            $extraData[$key] = $value;
        }

        return $extraData;
    }
}
