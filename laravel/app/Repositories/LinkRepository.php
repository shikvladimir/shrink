<?php


namespace App\Repositories;


use App\Models\Links;
use Illuminate\Support\Facades\DB;

class LinkRepository implements Interfaces\LinkRepositoryInterface
{
    public static function getAll (): object
    {
        return Links::query()->orderByDesc(Links::FIELD_ID)->get();
    }

    public static function getByAlias(string $alias): object|null
    {
        return Links::query()->where(Links::FIELD_ALIAS, $alias)->first();
    }
}
