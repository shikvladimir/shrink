<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegistrRequest;
use App\Services\UserClass;

class UserController extends Controller
{
    public function useGet(UserClass $userClass)
    {
        try {
            return response()->json($userClass->get());
        }catch (\Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
    }

    public function useRegistr(UserRegistrRequest $request, UserClass $userClass)
    {
        try {
            $data = $request->all();
            $userClass->register(data:$data);
        }catch (\Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
    }

    public function useLogin(UserLoginRequest $request, UserClass $userClass)
    {
        try {
            return response()->json($userClass->login($request));
        }catch (\Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
    }

    public function useLogout(UserClass $userClass)
    {
        try {
            $userClass->logout();
        }catch (\Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
    }


}
