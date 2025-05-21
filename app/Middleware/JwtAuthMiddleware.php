<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Annotation\JwtIgnore;
use Hyperf\Context\Context;
use Hyperf\Di\Annotation\AnnotationCollector;
use Hyperf\HttpServer\Router\Dispatched;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Qbhy\HyperfAuth\Authenticatable;
use Qbhy\HyperfAuth\AuthMiddleware;
use Qbhy\HyperfAuth\Exception\UnauthorizedException;

class JwtAuthMiddleware extends AuthMiddleware
{
    protected array $guards = ['jwt'];

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var Dispatched $dispatched */
        $dispatched = $request->getAttribute(Dispatched::class);
        $handlerStr = $dispatched?->handler;
        if(empty($handlerStr->callback) || $handlerStr->callback instanceof \Closure) {
            return $handler->handle($request);
        }

        $handlerStr = explode('@', $handlerStr->callback?:"");

        if (!empty($handlerStr)&& is_array($handlerStr)) {
            [$controller, $method] = $handlerStr;

            // 判断控制器类或方法上是否存在 JwtIgnore 注解
            $classAnnotations = AnnotationCollector::getClassAnnotations($controller);
            $methodAnnotations = AnnotationCollector::getClassMethodAnnotation($controller, $method);
            $shouldIgnore = false;

            foreach (($classAnnotations ?? []) as $annotation) {
                if ($annotation instanceof JwtIgnore) {
                    $shouldIgnore = true;
                    break;
                }
            }

            if (! $shouldIgnore) {
                foreach (($methodAnnotations ?? []) as $annotation) {
                    if ($annotation instanceof JwtIgnore) {
                        $shouldIgnore = true;
                        break;
                    }
                }
            }

            if ($shouldIgnore) {
                return $handler->handle($request);
            }
        }


        foreach ($this->guards as $name) {
            $guard = $this->auth->guard($name);

            if (! $guard->user() instanceof Authenticatable) {
                throw new UnauthorizedException("Without authorization from {$guard->getName()} guard", $guard);
            }
        }

        return $handler->handle($request);
    }

}
