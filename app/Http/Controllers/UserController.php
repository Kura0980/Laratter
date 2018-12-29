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
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

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
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors(), 400);
        }


        $newUser = $request->only('name', 'email', 'password');
        $user = new User();
        $user->fill($newUser);
        $user->save();

        $token = auth('api')->tokenById($user->id);
        return response()->json(['user' => $user, 'token' => $token], 201);
    }

    /**
     * ユーザを取得する
     * 
     * @return array
     */
    public function show(int $id)
    {
        $user = User::where('id', '=', $id)->first();
        return ['name' => $user['name']];
    }

    /**
     * ユーザの投稿を取得する
     * @param int $id ユーザID
     * 
     * @return array
     */
    public function getPosts(int $id)
    {
        $loginUserId = auth()->user()->id;

        $posts = \DB::table('users')
        ->select(
            'users.id AS user_id',
            'users.name',
            'posts.id AS post_id',
            'posts.user_id',
            'posts.sentence',
            \DB::raw('CASE WHEN likes.user_id IS NOT NULL THEN true ELSE false END AS is_like')
            )
        ->join('posts', 'users.id', '=', 'posts.user_id')
        ->leftJoin('likes', function($join) use ($loginUserId) {
            $join->on('posts.id', '=', 'likes.post_id')
                 ->where('likes.user_id', '=', $loginUserId);
        })->where('posts.user_id', $id)
        ->get();

        return $posts;
    }

    /**
     * いいねした記事を取得する
     * 
     * @param int $id ユーザID
     * 
     */
    public function getLikes(int $id) {

        $loginUserId = auth()->user()->id;

        $likes = \DB::table('users')
        ->select(
            'users.id AS user_id',
            'users.name',
            'posts.id AS post_id',
            'posts.user_id',
            'posts.sentence',
            \DB::raw('CASE WHEN likes.user_id IS NOT NULL THEN true ELSE false END AS is_like')
            )
        ->join('posts', 'users.id', '=', 'posts.user_id')
        ->join('likes', function($join) use ($id) {
            $join->on('posts.id', '=', 'likes.post_id')
                 ->where('likes.user_id', $id);
        })
        ->leftjoin('likes AS is_likes', function($join) use ($loginUserId) {
            $join->on('posts.id', '=', 'is_likes.post_id')
                 ->where('is_likes.user_id', '=', $loginUserId);
        })->get();
        return $likes;
    }
}
