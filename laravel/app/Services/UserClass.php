<?php


namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserClass
{
    public function get()
    {
        $user['name'] = Auth::user()->name;
        $user['authId'] = Auth::user()->id;
        $user['auth'] =  true;

        return $user;
    }

    public function register(array $data): void
    {
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['pass']),
        ]);
    }

    public function login(object $request)
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
        throw new \Exception('Unauthorised.');
    }

    public function logout(): void
    {
        Auth::guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
}
