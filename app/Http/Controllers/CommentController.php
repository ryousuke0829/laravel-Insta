<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    private $comment;
    public function __construct(Comment $comment) {
        $this->comment = $comment;
    }

    public function store(Request $request, $post_id)//どのpostにコメントしたかの指定
    {
        #validate//エラーメッセージの編集方法：['form name'.'.validate項目'=>'エラーメッセージ']
        $request->validate([
            'comment_body'.$post_id => 'required|min:1|max:150',
        ],
        [
            'comment_body'. $post_id. '.required' =>'You cannot submit an empty comment.',
            'comment_body'. $post_id. '.max' =>'The comment must not have more than 150 charactors.'
        ]);

        #2 Save the comment
        $this->comment->body = $request->input('comment_body'.$post_id);//どの投稿にどのコメントを送信したか区別できるようにformに.$post_idを加えておく。これはそれを取得するため。
        $this->comment->user_id     = Auth::user()->id; //5行目注意参照
        $this->comment->post_id     = $post_id; 
        $this->comment->save();  

        return redirect()->route('post.show',$post_id);
    }

    public function destroy($comment_id)
    {
        $this->comment->destroy($comment_id); 
        return redirect()->back();
    }
}
