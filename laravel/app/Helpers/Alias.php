<?php


namespace App\Helpers;


final class Alias
{
    public static function index(): string
    {
        return str_replace(['+', '/', '='], '', base64_encode(random_bytes(12)));
    }
}
