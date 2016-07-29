<?php

namespace larashop\Http\Controllers;

use larashop\Like;
use Illuminate\Http\Request;

use larashop\Http\Requests;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function likeReview($id)
    {
        $this->handleLike('larashop\Review', $id);
        return redirect()->back();
    }

    public function handleLike($type, $id)
    {
        $existing_like = Like::withTrashed()->whereLikeableType($type)->whereLikeableId($id)
                                    ->whereUserId(Auth::id())->first();

        if(is_null($existing_like)) {
            Like::create([
                'user_id'   =>  Auth::id(),
                'likeable_id'   =>  $id,
                'likeable_type' =>  $type
            ]);
        } else {
            if(is_null($existing_like->deleted_at)) {
                $existing_like->delete();
            } else {
                $existing_like->restore();
            }
        }
    }
}
