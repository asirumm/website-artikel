<?php

namespace App\Helpers;

class RandomString
{
    public static function randomString(int $length)
    {
        return bin2hex(random_bytes($length));
    }
}