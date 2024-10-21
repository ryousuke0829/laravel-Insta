<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    /**
     * Use theis mothod to get the info of the owner of the comment
     */
    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
        //withTrashed()は論理削除（soft delete）されたユーザーも含めて取得するオプション
    }

}
