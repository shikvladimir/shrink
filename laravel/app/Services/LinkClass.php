<?php


namespace App\Services;


use App\Helpers\Alias;
use App\Models\Links;
use App\Repositories\LinkRepository;

class LinkClass
{
    public function move(string $alias): string|null
    {
        $link = LinkRepository::getByAlias(alias:$alias)?->link;

        if(!$link) {
            abort(404);
        }
        return LinkRepository::getByAlias(alias:$alias)->link;
    }

    public function get(): object
    {
        return LinkRepository::getAll();
    }

    public function store(array $data): void
    {
        Links::query()->create([
            Links::FIELD_ALIAS => Alias::index(),
            Links::FIELD_LINK => $data['link'],
        ]);
    }

    public function update(array $data): void
    {
        LinkRepository::getByAlias(alias: $data['alias'])
            ->update([Links::FIELD_LINK => $data['link']]);
    }



    public function delete(string $alias): void
    {
        LinkRepository::getByAlias(alias:$alias)->delete();
    }

    public function count()
    {

    }
}
