<?php

namespace IslamBzh\stringReplace;

class StringReplace
{
    use StringReplaceTrait;

    public static function replace(string $string, array $vars = []): string
    {
        return self::stringReplace($string, $vars);
    }
}