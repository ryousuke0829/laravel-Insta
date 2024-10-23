<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;
    const ADMIN_ROLE_ID = 1; //Admin　constは定数の設定
    const USER_ROLE_ID = 2; //Regular constは定数の設定

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ]; //必ず一括でこの３つを保存するセキュリティ。

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    /**
     * Use this method to get the all posts of user
     */
    public function posts(){
        return $this->hasMany(Post::class)->latest();
    }   // this user has Many Post->latest()

        /**
     * Use this method to get all the followers of a user
     */
    public function followers(){
        return $this->hasMany(Follow::class, 'following_id');
    }   // this user has Many (Follow Tableのfollowing_id)

    /**
     * Users table
     * id         name
     * 1        John Smith
     * 2        TIm Watson
     * 
     * Follows table
     * followers_id  followeing_id
     * ----------------------------
     * 1              
     */

    /**
     * Use this method to get all the users that the user is followeing
     */
    public function following(){
        return $this->hasMany(Follow::class,'follower_id');
    }   // this user has Many (Follow Tableのfollower_id)

    /**
     * Method to use in checking inf user is already following a user
     */
    public function isFollowed(){
        return $this->followers()->where('follower_id',Auth::user()->id)->exists();
        //ログインユーザーがフォローしているかどうか。？？
        //Auth::user()->id --> is always the follower
        //firstly, get all the followers of the user ($this->follower() ). Then,from that list , serch for th Auth user id from the follower column(where ('follower_id',Auth::user()->id))
    }

    public function isFollowing(){
        return $this->following()->where('following_id',Auth::user()->id)->exists();
    }

}
