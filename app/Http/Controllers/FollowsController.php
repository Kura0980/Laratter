<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Follow;

class FollowsController extends Controller
{
    /**
     * フォロー登録
     * @param Request $request
     *  
     * @return array
     */
    public function store(Request $request)
    {
        $newFollow = $request->only('follow_id');
        $user = auth()->user();
        $newFollow['follower_id'] = $user->id;
        $follows = new Follow();	
        $follows->fill($newFollow);
        $follows->save();
        return response()->json($follows, 201);
    }

    /**
     * フォロー削除
     * @param int $id フォローID
     * 
     * @return array
     */
    public function destroy(int $id)
    {
        $user = auth()->user();
        Follow::where('follow_id', $id)
              ->where('follower_id', $user->id)
              ->delete();
        return response(null, 204);
    }

}
