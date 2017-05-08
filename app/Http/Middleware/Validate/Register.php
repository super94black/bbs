<?php

namespace App\Http\Middleware\Validate;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Register
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $data = $request->all();
        foreach ($data as $key => $value){
            if($value == null){
                return response('注册信息都要填写');
            }
        }
            if(empty($data['username'])){
                return response('用户名为空');
            }else{
                $result = DB::table('users')->where('username',$data['username'])->get();

                if($result != null){
                    return response('该用户已经存在');
                }
            }
            if(empty($data['password']) || empty($data['pwd'])){
                return response('密码不能为空');
            }
            if($data['password'] != $data['pwd']){
                return response('两次密码输入不一致');
            }


            return $next($request);


    }
}
