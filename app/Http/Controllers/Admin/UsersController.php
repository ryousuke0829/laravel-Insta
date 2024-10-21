<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    private $user;
    public function __construct(User $user) {
        $this->user = $user;
    }

    public function index(){
        /**
         * The WithTrashed() ->will include the soft delete users records in the query result
         */
        $all_users = $this->user->withTrashed()->latest()->paginate(4);  // Viewの最後らへんに{{$all_users->links()}}をつければNextページボタンを設計可能
        return view('admin.users.index')->with('all_users',$all_users);
    }
    /**
     * Create a method to softdelete a user
     */
    public function deactivate($user_id){
        $this->user->destroy($user_id); 
        return redirect()->back();
    }

    /**
     * Method to restore the soft deleted users
     */
    
    public function activate($user_id){
        $this->user->onlyTrashed()->findOrFail($user_id)->restore();
        /**
            * The OnlyTrashed()-->retrives soft delete records only
            * restore()-->This will un-delete a soft deleted model/record.This will set the "delete_at" column to null
            */
        return redirect()->back();
    }
    }