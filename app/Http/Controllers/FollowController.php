<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Follow;

class FollowController extends Controller
{
    private $follow;

    public function __construct(Follow $follow) {
        $this->follow = $follow;
    }

    /**
     * Method to store the follower and the following id
     */
    public function store($user_id){
        $this->follow->follower_id=Auth::user()->id; //The Auth user id is always the follower
        $this->follow->following_id=$user_id; //tge id of the user being followed
        $this->follow->save();

        return redirect()->back();
    }

    /**
     * Method to be use in destroying the follow record of the user 
     */
    public function destroy($user_id){     //destroyには$user_idの指定が必要
        $this->follow
            ->where('follower_id', Auth::user()->id)    //followした人(id)
            ->where('following_id', $user_id)           //followされた人(id)
            ->delete();                                 //をdelete

        return redirect()->back();
    }

}
