<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;

class LikeController extends Controller
{
    /**
     * いいね登録
     * @return Request $request
     * 
     * @return json
     */
    public function store(Request $request)
    {
        $newLike = $request->only('post_id');
        $user = auth()->user();
        $newLike['user_id'] = $user->id;
        $likes = new Like();	
        $likes->fill($newLike);
        $likes->save();
        return response()->json($likes, 201);
    }

    /**
     * いいね削除
     * @param int $id ポストID
     * 
     * @return response
     */
    public function destroy(int $id)
    {
        $user = auth()->user();
        Like::where('user_id', $user->id)
            ->where('post_id', $id)
            ->delete();
        return response(null, 204);
    }
}
