<?php


namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserClass
{
    public function register(array $data): void
    {
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['pass']),
        ]);
    }

    public function login(array $data)
    {
        if(Auth::attempt(['email' => $data['email'], 'password' => $data['pass']])){

            $user = Auth::user();
            $success['token'] =  $user->createToken('test')->plainTextToken;
            $success['name'] =  $user['name'];
            $success['auth'] =  true;
            $success['status'] = 'User login successfully.';

            return $success;
        }
        throw new \Exception('Unauthorised.');
    }

    public function logout(): void
    {
//        throw new \Exception(auth()->user(), 400);
//        dd(auth()->user());
//        auth()->user()->tokens()->delete();

        $user = Auth::user();

        dd($user);

        if (!$user) {
            throw new \Exception('Пользователь не аутентифицирован.');
        }

        // Удаляем только текущий токен
        $user->currentAccessToken()->delete();

    }
}
