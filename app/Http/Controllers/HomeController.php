<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class HomeController extends Controller
{   
    private $post;
    private $user;
    public function __construct(Post $post, User $user) {
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    //methodは順不同で良いよ
    public function index()
    {   
        $home_posts=$this->getHomePosts();
        $suggested_users = $this->getSuggestedUsers();

        return view('users.home')
            ->with('home_posts', $home_posts)
            ->with('suggested_users',$suggested_users);
    }

    /**
     * Filter the posts thet will be displayed in the homepage
     * Only the posts of the user that the Auth user if following showing thw post
     */
    public function getHomePosts(){
        // 1. すべての投稿を最新順で取得
        $all_posts = $this->post->latest()->get();
    
        // 2. まず配列を初期化declare an empty array
        $home_posts = []; 
    
        // 3. 取得したすべての投稿をループ処理
        foreach ($all_posts as $post) {
            // 4. ログインしているユーザーが投稿者をフォローしているid || 自身のid
            if ($post->user->isFollowed() || $post->user->id === Auth::user()->id) {
                $home_posts[] = $post;  // の投稿をhome_postsに追加
            }
        }
        return $home_posts;
    }

    /**
     * Get the lists of the users that the Auth User is not following yet.
     */
    private function getSuggestedUsers() {
        // 1. すべてのユーザーを取得し、現在のログインユーザーを除外
        $all_users = $this->user->all()->except(Auth::user()->id);
    
        // 2. 提案するユーザーのリストを初期化
        $suggested_users = [];
    
        // 3. すべてのユーザーをループ処理
        foreach ($all_users as $user) {
            // 4. ユーザーがフォローされていない場合、提案するユーザーリストに追加
            if (!$user->isFollowed()) {
                $suggested_users[] = $user;
            }
        }
        // 5. 提案したいユーザーのリストから最大4人を取得して返す
        return array_slice($suggested_users, 0, 4);
        # array_slice(x, y, z)
        # x: 対象の配列、y: 開始インデックス、z: 取得する要素数
    }

    /**
     * Method to search user
     */
    public function search(Request $request){
        $users = $this->user->where('name','like','%'.$request->search.'%')->get();

        return view('users.search')
            ->with('users', $users)
            ->with('search', $request->search);
    }
}
