<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth; //現在ログインしているユーザーの情報を取得する機能
use App\Models\Post;                //使うTable①
use App\Models\Category;            //使うTable②
use App\Models\CategoryPost;        //使うTable③
use Illuminate\Http\Request;


class PostController extends Controller
{   
    private $post;
    private $category;
    public function __construct(Post $post,Category $category){  //ModelのPostクラスを$postとする。Categoryクラスを$categoryとする。
        $this->post=$post;  
        $this->category=$category;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $all_categories = $this->category->all();
        return view('users.posts.create')
            ->with('all_categories', $all_categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        #1 バリデーション
        $request->validate([
            'category' => 'required|array|between:1,3',  // カテゴリは配列で送信され、1つ以上3つまで選択可能
            'description' => 'required|min:1|max:1000',  // 投稿の説明は1文字以上1000文字以内
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:1048', // 画像は必須で、JPEG, JPG, PNG, GIF形式のみ、最大サイズは1048KB
        ]);
    
        #2 投稿の保存
        $this->post->user_id = Auth::user()->id; // 現在ログインしているユーザーのIDを投稿に関連付ける
        $this->post->image = 'data:image/'.$request->image->extension().';base64,'.base64_encode(file_get_contents($request->image)); 
        // 画像をbase64エンコードして保存。例: 'data:image/jpeg;base64,データ'
        $this->post->description = $request->description; // 説明文を保存
        $this->post->save(); // データベースに投稿を保存
    
        #3 カテゴリの保存 (多対多のリレーション)
        // チェックボックスで複数選択されたカテゴリを保存
        foreach($request->category as $category_id) {
            $category_post[] = ['category_id' => $category_id]; // カテゴリIDを配列に格納
        }
    
        #4 PIVOTテーブル (category_post) にデータを保存
        $this->post->categoryPost()->createMany($category_post); 
        // 投稿とカテゴリのリレーションを保存 (createManyで配列のデータをまとめて挿入)
    
        #5 投稿一覧ページにリダイレクト
        return redirect()->route('index');
    }
    

    /**
     * Display the specified resource.
     */
    public function show($post_id) //使う$post_id（formから送られてくるやつ）を指定。
    {
        $post = $this->post->findOrFail($post_id); //$postを指定の$post_idの全データとおく
        return view('users.posts.show')->with('post',$post); //上記の全データをViewで＄postとして使えるようにする。
    }

    /**
     * Show the form for editing the specified resource.
     * 配列を含んだ編集ページへの移行
     */
    public function edit($post_id) // 使う$post_id（formから送られてくるやつ）を指定。
    {
        // すべてのカテゴリを取得
        $all_categories = $this->category->all();
    
        // 投稿をIDで取得。見つからなければ404エラー
        $post = $this->post->findOrFail($post_id);
    
        // この投稿に関連する選択されたカテゴリのIDを取得
        $selected_categories = categoryPost::where('post_id', $post_id) //当該post_idの,
                                           ->pluck('category_id') // 'category_id' の値を配列で取得
                                           ->toArray(); // コレクションを配列に変換
    
        // 投稿のオーナーが現在のユーザーでない場合、前のページに戻る
        if ($post->user->id != Auth::user()->id) { 
            return redirect()->back();
        }
    
        // ビューを返す。投稿、すべてのカテゴリ、選択されたカテゴリを渡す
        return view('users.posts.edit')
            ->with('post', $post) // 編集する投稿
            ->with('all_categories', $all_categories) // すべてのカテゴリ
            ->with('selected_categories', $selected_categories); // 選択されたカテゴリ
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) //使う$post_id（formから送られてくるやつ）を指定。
    {   
        #1 validate
        $request->validate([
            'category' => 'required|array|between:1,3',
            'description' => 'required|min:1|max:1000',
            'image' => 'mimes:jpeg,jpg,png,gif|max:1048',
        ]);

        $this->post = Post::findOrFail($id);    //まずは$this->postに、findOrFailでPostモデルから指定のidを代入する。

        #2 Save the post
        $this->post->user_id     = Auth::user()->id; //5行目注意参照
        if($request->image){    //もしimageが送信されてきたら、
            $this->post->image = 'data:image/'.$request->image->extension().';base64,'.base64_encode(file_get_contents($request->image));
        }else{
            $this->post->image = $this->post->image;//もしimageが送信されてこなかったら、もともと入っていた画像をもともと入っていたカラムに代入
        }
        $this->post->description = $request->description;
        $this->post->save();  //post id 1

        $this->post->categoryPost()->delete();  //まずはcategoryとpostをdelete()する
        #Save the categories to the category_post(PIVOT)
        foreach($request->category as $category_id){
            $category_post[] = ['category_id'=>$category_id];//foreachでarrayとして$category_post[]に代入する
        }
        #insert the post id and the category id's to the pivot table
        $this->post->categoryPost()->createMany($category_post);//上記のcategory_post[]をcreateManyで保存する。

        #4 Go back to the 
        return redirect()->route('post.show',$id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($post_id) //これはほぼ定型文
    {
        $this->post->findOrFail($post_id)->forceDelete(); //softdeleteを本当に削除するやつ
        return redirect()->back();
    }
}
