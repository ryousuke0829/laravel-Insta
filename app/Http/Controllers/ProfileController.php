<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Follow;

class ProfileController extends Controller
{
    private $user;
    public function __construct(User $user) {
        $this->user = $user;
    }

    public function show($user_id){
        $user = $this->user->findOrFail($user_id);              // 指定したIDのユーザーを取得。見つからない場合は404エラー
        return view('users.profile.show')->with('user',$user);  // 取得したユーザー情報をビューに渡し、プロフィールページを表示
    }

    public function edit(){
        $user = $this->user->findOrFail(Auth::user()->id);      //ログインしているユーザーのIDを使ってユーザー情報を取得。見つからなければ404エラー
        return view('users.profile.edit')->with('user',$user);
    }

    /**
     * Method to update the user details
     */

    public function update(Request $request,$id){
        #1. Validate the data
        $request->validate([
            'name' => 'required|min:1|max:100',
            'email' => 'required|min:1|max:100',
            'introduction' => 'required|min:1|max:1000',
            'avatar' => 'mimes:jpeg,jpg,png,gif|max:1048',
        ]);

        #2. Save the new data into the Db
        $this->user = User::findOrFail($id);
        $this->user->name = $request->name;
        $this->user->email = $request->email;
        $this->user->introduction = $request->introduction;

        if($request->avatar){
            $this->user->avatar = 'data:avatar/'.$request->avatar->extension().';base64,'.base64_encode(file_get_contents($request->avatar));
        }else{
            $this->user->avatar = $this->user->avatar;
        }

        $this->user->save(); 

        #3. Redirect to profile page
        return redirect()->route('profile.show',$id);
    }

    public function follower($user_id){
        $user = $this->user->findOrFail($user_id);
        return view('users.profile.followers')
            ->with('user',$user);
    }
    /**
     * Method use to get the all the users that the User is following
     */
    public function following($user_id){
        $user = $this->user->findOrFail($user_id);
        return view('users.profile.following')
            ->with('user',$user);
    }

}
