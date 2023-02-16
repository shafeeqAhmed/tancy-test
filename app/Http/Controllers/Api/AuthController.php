<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Auth\Events\Registered;

class AuthController extends ApiController
{
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $request = $request->all();
        $user = User::where('email',  $request['email'])->first();
        if (!$user || !Hash::check($request['password'], $user->password)) {

            return $this->respondNotFound([
                'success' => false,
                'errors' => 'The provided credentials are incorrect.',
                'data' => []
            ]);
        }
        $data = $this->getAuthResponseData($user);

        return $this->respond([
            'success' => true,
            'errors' => null,
            'data' => $data
        ]);
    }
    public function register(Request $request)
    {

        $user = (new CreateNewUser())->create($request->all());

        try {

            event(new Registered($user));
            $data = $this->getAuthResponseData($user);

            return $this->respond([
                'success' => true,
                'errors' => null,
                'data' => $data
            ]);
        } catch (Exception $e) {

            return $this->respondNotFound([
                'success' => false,
                'errors' => $e->getMessage(),
                'data' => null
            ]);
        }
    }
    public function getAuthResponseData($user)
    {
        $detail = $this->getUserAttribute($user);
        $token = $user->createToken('test-code')->plainTextToken;
        $data['userData'] = $detail;
        $data['accessToken'] = $token;
        $data['refreshToken'] = $token;
        return $data;
    }

    public function getUserAttribute($user)
    {
        $data =  collect($user)->only('name',  'email');
        $data['is_verified_email'] = $user->hasVerifiedEmail();
        return $data;
    }
}
