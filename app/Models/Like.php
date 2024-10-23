<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    public $timestamps =false;//タイムスタンプの設定消した時に必須

    public function user()
    {
    return $this->belongsTo(User::class);
    }
}
