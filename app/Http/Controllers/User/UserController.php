<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\Post\PostController;
use App\UserModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public $userModel;
    public function __construct(){
        if($this->userModel == null){
            $this->userModel = new UserModel();
        }
    }

    //视图展示
    public function showPage($url){
        return view($url);
    }
    //添加用户
    public function create(Request $request){

       $user = $request->all();
       $result = $this->userModel->createUser($user);

       if($result){
           Session::put(['user',$result['username'],'uid' => $result['id']]);
           Session::save();
           return redirect('postList');
       }

    }
}
