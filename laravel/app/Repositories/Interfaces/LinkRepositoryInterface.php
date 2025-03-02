<?php


namespace App\Repositories\Interfaces;


interface LinkRepositoryInterface
{
    public static function getAll(): object;
    public static function getByAlias(string $alias): object|null;
}
