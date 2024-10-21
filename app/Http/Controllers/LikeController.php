<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\MOdels\Like;

class LikeController extends Controller
{
    private $like;
    public function __construct(Like $like) {
        $this->like = $like;
    }

    public function store($post_id){
        $this->like->user_id =Auth::user()->id;
        $this->like->post_id =$post_id;
        $this->like->save();

        return redirect()->back();
    }

    public function destroy($post_id)
    {
    $this->like
        ->where('user_id', Auth::user()->id)//ログインユーザーの、
        ->where('post_id', $post_id)        //指定されたpost_idの
        ->delete();                         //削除
    return redirect()->back();
    }
}