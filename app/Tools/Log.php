<?php

namespace App\Tools;

use Hyperf\Context\ApplicationContext;
use Hyperf\Logger\LoggerFactory;

class Log
{
    public static function get(string $name = 'app')
    {
        return ApplicationContext::getContainer()->get(LoggerFactory::class)->get($name);
    }
}
