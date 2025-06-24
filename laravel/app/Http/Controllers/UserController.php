<?php
declare (strict_types = 1);

namespace App\Http\Controllers;

use App\DTO\RegisterUserDTO;
use App\Helpers\ApiResponse;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegistrRequest;
use App\Services\UserClass;

class UserController extends Controller
{
    public function useGet(UserClass $userClass)
    {
        return ApiResponse::try(fn() => $userClass->get());
    }

    public function useRegistr(UserRegistrRequest $request, UserClass $userClass)
    {
        return ApiResponse::try(fn() => $userClass->register(data:RegisterUserDTO::fromRequest($request)));
    }

    public function useLogin(UserLoginRequest $request, UserClass $userClass)
    {
        return ApiResponse::try(fn() => $userClass->login(request:$request));
    }

    public function useLogout(UserClass $userClass)
    {
        return ApiResponse::try(fn() => $userClass->logout());
    }
}
