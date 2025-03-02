<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinkStoreRequest;
use App\Http\Requests\LinkUpdateRequest;
use App\Services\LinkClass;

class LinkController extends Controller
{
    public function useMove($alias, LinkClass $linkClass)
    {
        try {
            return redirect($linkClass->move($alias));
        }catch (\Exception $e) {
            return redirect($linkClass->move($alias));
        }
    }

    public function useGet(LinkClass $linkClass)
    {
        try {
            return response()->json($linkClass->get());
        }catch (\Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
    }

    public function useStore(LinkStoreRequest $request, LinkClass $linkClass)
    {
        try {
            $data = $request->all();
            $linkClass->store($data);
        }catch (\Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
    }

    public function useUpdate(LinkUpdateRequest $request, LinkClass $linkClass)
    {
        try {
            $data = $request->all();
            $linkClass->update($data);
        }catch (\Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
    }

    public function useDelete($alias, LinkClass $linkClass)
    {
        try {
            $linkClass->delete(alias:$alias);
        }catch (\Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
    }

    public function useCount(LinkClass $linkClass)
    {
        try {
            return response()->json($linkClass->count());
        }catch (\Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
    }


}
