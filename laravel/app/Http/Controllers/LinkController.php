<?php
declare (strict_types = 1);

namespace App\Http\Controllers;

use App\DTO\StoreLinkDTO;
use App\Helpers\ApiResponse;
use App\Http\Requests\LinkStoreRequest;
use App\Http\Requests\LinkUpdateRequest;
use App\Services\LinkClass;

class LinkController extends Controller
{
    public function useMove($alias, LinkClass $linkClass)
    {
        return ApiResponse::try(fn() => $linkClass->move(alias: $alias));
    }

    public function useGet(LinkClass $linkClass)
    {
        return ApiResponse::try(fn() => $linkClass->get());
    }

    public function useStore(LinkStoreRequest $request, LinkClass $linkClass)
    {
        return ApiResponse::try(fn() => $linkClass->store(data: StoreLinkDTO::fromRequest($request)));
    }

    public function useUpdate(LinkUpdateRequest $request, LinkClass $linkClass)
    {
        return ApiResponse::try(fn() => $linkClass->update(data: StoreLinkDTO::fromRequest($request)));
    }

    public function useDelete($alias, LinkClass $linkClass)
    {
        return ApiResponse::try(fn() => $linkClass->delete(alias: $alias));
    }
}
