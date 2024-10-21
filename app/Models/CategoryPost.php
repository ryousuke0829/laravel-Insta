<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    use HasFactory;
    protected $table    = 'category_post';//table名がCategoryPostじゃないので指定する。
    protected $fillable = ['category_id','post_id'];//pivotTableには必須のセキュリティ設定
    public $timestamps  = false;  //migrationでtimetableを消した時使う

    #Use  
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
