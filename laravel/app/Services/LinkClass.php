<?php
declare (strict_types = 1);

namespace App\Services;


use App\DTO\StoreLinkDTO;
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
            throw new \Exception('Ссылка не найдена',404);
        }

        $link = $getLink->link;
        $getLink->increment('clicks');
        return $link;
    }

    public function get(): object
    {
        return LinkRepository::getAll();
    }

    public function store(StoreLinkDTO $data): void
    {
        Links::query()->create([
            Links::FIELD_USER_ID => Auth::id(),
            Links::FIELD_ALIAS => Alias::index(),
            Links::FIELD_LINK => $data->link,
            Links::FIELD_NAME => $data->name,
        ]);
    }

    public function update(StoreLinkDTO $data): void
    {
        LinkRepository::getByAlias(alias: $data->alias)
            ->update(
                    [Links::FIELD_LINK => $data->link,
                    Links::FIELD_NAME => $data->name
                ]);
    }

    public function delete(string $alias): void
    {
        LinkRepository::getByAlias(alias:$alias)->delete();
    }
}
