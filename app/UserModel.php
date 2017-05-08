<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserModel extends Model
{
    protected $table = 'users';

    protected $fillable = ['username', 'password'];
    public function createUser($user){

        $data = [
            'username' => $user['username'],
            'password' => md5($user['password']),
        ];
//        dd($data);
        $result = $this->create($data);
        return $result;
    }
}
