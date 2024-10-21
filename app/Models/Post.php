<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;//付け加える
use Illuminate\Support\Facades\Auth; //付け加える


class Post extends Model
{
    use HasFactory, SoftDeletes ; //付け加える

    # A post belongst to w user
    # Use this method to get the owner of the post
    public function user(){
        return $this ->belongsTo(User::class)->withTrashed();
        //withTrashed()は論理削除（soft delete）されたユーザーも含めて取得するオプション
    }

    # Use this method to get the categories ynder a pot 
    public function categoryPost(){
        return $this->hasMany(CategoryPost::class);
        //This post has many CategoryPost
    }

    /**
     * Use this method to get the comments tof a post
     */
    public function comments(){
        return $this->hasMany(Comment::class);
        //This post has many Comment
    }

    /**
     * Use this method to get the lieks of a post
     */

    public function likes(){   
        return $this->hasMany(Like::class);
        //This post has many Like
    }
    /**
     * Return True if the Authe User already like hte post
     */

    public function isLiked(){
        return $this->likes()->where('user_id',Auth::user()->id)->exists();
        //This post has many Like->でログインユーザーが->いいねしてたらTrue
    }
}
