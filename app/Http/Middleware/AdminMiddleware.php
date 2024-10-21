<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; //追加
use App\Models\User;//

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        // ユーザーがログインしていて、かつ管理者であるかチェック
        if(Auth::check() && Auth::user()->role_id==User::ADMIN_ROLE_ID){
            return $next($request);// 管理者であれば、次の処理に進む
        }
        return redirect()->route('index');
    }
}
