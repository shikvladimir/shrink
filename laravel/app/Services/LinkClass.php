<?php


namespace App\Services;


use App\Helpers\Alias;
use App\Models\Links;
use App\Repositories\LinkRepository;
use Illuminate\Support\Facades\Auth;

class LinkClass
{
    public function move(string $alias): string|null
    {
        $getLink = LinkRepository::getByAlias(alias:$alias);

        if(!$getLink) {
            abort(404);
        }

        $link = $getLink->link;
        $getLink->increment('clicks');
        return $link;
    }

    public function get(): object
    {
//        dd(LinkRepository::getAll());
        return LinkRepository::getAll();
    }

    public function store(array $data): void
    {
        Links::query()->create([
            Links::FIELD_USER_ID => Auth::id(),
            Links::FIELD_ALIAS => Alias::index(),
            Links::FIELD_LINK => $data['link'],
            Links::FIELD_NAME => $data['name'],
        ]);
    }

    public function update(array $data): void
    {
        LinkRepository::getByAlias(alias: $data['alias'])
            ->update(
                    [Links::FIELD_LINK => $data['link'],
                    Links::FIELD_NAME => $data['name']
                ]);
    }



    public function delete(string $alias): void
    {
        LinkRepository::getByAlias(alias:$alias)->delete();
    }

    public function count()
    {

    }
}
