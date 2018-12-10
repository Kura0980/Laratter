<?php

namespace App\Http\Controllers;

use JWTAuth;

use App\Http\Controllers;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function authnication (Request $request)
    {
        $authInfo = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($authInfo)) {
                return response()->json(['error' => '認証失敗'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => '認証失敗'], 500);
        }
        
        $user = User::where('email', '=', $authInfo['email'])->first();

        return ['user' => $user, 'token' => $token];
    }

    /**
     * ユーザを登録する
     * @param Request $request
     * 
     * @return array
     */
    public function register(Request $request)
    {
        $newUser = $request->only('name', 'email', 'password');
        $user = new User();
        $user->fill($newUser);
        $user->save();
        return $user;
    }

}
