<?php

namespace App\Http\Middleware\Validate;

use App\UserModel;
use \Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Login
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $user = new UserModel();
        $user_info = $request->all();

        $pwd = md5($user_info['password']);
        $data = $user->where('username',$user_info['username'])->first();
//        dd($data['password']);
       if($data['password'] == $pwd){
           Session::put('uid',$data['id']);
           Session::save();
           return $next($request);
       }
       else if($data['username'] == null){
           return response('该用户不存在');
       }else
           return response('输入的密码不正确');
    }
}
