<?php

namespace App\Tools;

use Hyperf\Context\ApplicationContext;
use Hyperf\Logger\LoggerFactory;
use Hyperf\Redis\RedisFactory;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class Redis
{
    /**
     * @param string $name
     * @return \Hyperf\Redis\RedisProxy
     */
    public static function get(string $name = 'default'): \Hyperf\Redis\RedisProxy | null
    {
        $container = ApplicationContext::getContainer();
        try {
            $redis = $container->get(RedisFactory::class)->get($name);
        } catch (\Exception $e) {
            Log::get()->error($e->getMessage());
            return null;
        }
        return $redis;
    }





}
