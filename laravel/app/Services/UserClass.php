<?php
declare (strict_types = 1);


namespace App\Services;


use App\DTO\RegisterUserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserClass
{
    public function get()
    {
        $user['name'] = Auth::user()?->name;
        $user['authId'] = Auth::user()?->id;
        $user['auth'] =  !!Auth::user();

        return $user;
    }

    public function register(RegisterUserDTO $data): void
    {
        User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->pass),
        ]);
    }

    public function login(object $request): array|\Exception
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->pass])){
            $user = Auth::user();
            $success['name'] =  $user['name'];
            $success['authId'] = $user['id'];
            $success['auth'] =  true;
            $success['status'] = 'User login successfully.';

            $request->session()->regenerate();
            return $success;
        }

        throw new \Exception('Неверный логин или пароль.', 401);
    }

    public function logout(): void
    {
        Auth::guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
}
