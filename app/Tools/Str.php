<?php
namespace Hyperf\Utils;


class Str
{
    public static function random(): string
    {
        return md5(uniqid(mt_rand(), true));
    }
    

}