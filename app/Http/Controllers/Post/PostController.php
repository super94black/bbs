<?php

namespace App\Http\Controllers\Post;

use App\Post;
use App\User;
use App\UserModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    public $post;
    public function __construct(){
        if($this->post == null){
            $this->post = new Post();
        }
    }

    //发表新帖子
    public function newPost(Request $request){
        $info = $request->all();
        $uid = Session::get('uid');
        //过滤敏感词汇
        $badword = array(
            '操',
            '草',
            '日你',
            'cao',
            'fuck',
            '民主',
            '自由',
            '尼玛',

        );
        $badword = array_combine($badword,array_fill(0,count($badword),'*'));
        $info['title'] = strtr($info['title'],$badword);
        $info['content'] = strtr($info['content'],$badword);
        $data = [
            'title' => $info['title'],
            'content' => $info['content'],
            'uid' => $uid,
            'pid' => '0',
            'is_leaf' => '1',

        ];
        if($data['title'] == null){
            return response('标题不能为空');
        }
        $data = $this->post->create($data);
        $result = [
            'root_id' => $data['id'],
        ];

        $result = $this->post->where('id',$data['id'])->update($result);

        if($result){
           return redirect('postList');
        }
    }
    //获得帖子
    public function getPostList(){
        $data = $this->post->where('pid','0')->get();
        $uid = Session::get('uid');
        $user = new User();
        $user_info = $user->where('id',$uid)->get();
        $username = $user_info[0]['username'];

        return view('postList')->with('data',$data)->with('username',$username);
    }
    //获得某个帖子的留言板
    public function getPostDetail(Request $request){
        //帖子ID
        $id = $request->input('pid');
        //获取当前帖子pid为0的信息
        $pid_zero = $this->post->where('id',$id)->first();
        //获取用户名
        $user = new User();
        $pid_zero['user'] = $user->where('id',$pid_zero['uid'])->first();
        //获取除了楼主发帖的信息外(pid = 0) 所有的第一层留言(pid = 楼主id)
        $data = $this->post->where('root_id', $id)->where('pid','!=','0')->get();
        foreach($data as $key => $value){
            $username =  $user->where('id',$value['uid'])->first(['username']);
            $data[$key]['username'] = $username['username'];
            if($value['is_leaf']){
                $pinfo = $this->post->where('id',$value['pid'])->get(['content','uid']);
                $uid = $pinfo[0]['uid'];
                $user_info = $user->where('id',$uid)->first(['username']);
                $data[$key]['pname'] = $user_info['username'];
                $data[$key]['pcontent'] = $pinfo[0]['content'];

            }

        }

        //进行对每个第一层循环 得出所有的第一层下边的留言
//      foreach($data as $key => $value){
//          if(!$value['is_leaf']){
//              $this->getPostTree($value['id']);
//          }
//      }

        if($data){
            Session::put('root_id', $id);
            Session::save();
            return view('postDetail')->with('data',$data)->with('pid_zero',$pid_zero);
        }else{
            return response('该贴子已被移除');
        }

    }
    //递归函数 对某条发言找出回复它的所有记录
//    public function getPostTree($pid){
//        $data = $this->post->where('pid',$pid)->get();
//        foreach($data as $key => $value){
//            if(!$value['is_leaf']){
//                $this->getPostTree($value['id']);
//            }
//
//        }
//    }
    //回复帖子页面
    public function reply(Request $request){
        $pid = $request->input('pid');
        return view('reply',['pid' => $pid]);
    }
    //保存回复内容
    public function replySubmit(Request $request){
        $info = $request->all();

        $uid = Session::get('uid');

        if(empty($info['content'])){
            return response('内容不能为空');
        }
        else{
            $root_id = Session::get('root_id');
            $badword = array(
                '操',
                '草',
                '日你',
                'cao',
                'fuck',
                '民主',
                '自由',
                '尼玛',

            );
            $badword = array_combine($badword,array_fill(0,count($badword),'*'));
            $info['content'] = strtr($info['content'],$badword);
            $data = [
                'title' => 'default',
                'content' => $info['content'],
                'uid' => $uid,
                'pid' => $info['pid'],
                'root_id' => $root_id,
                'is_leaf' => '1',

            ];
            $this->post->create($data);
            //更新父亲节点不是为叶子节点
            $this->post->where('id',$info['pid'])->update(['is_leaf' => '0']);
//            $data = $this->post->where('pid',$info['pid'])->Orwhere('id',$info['pid'])->get();
//            $data = $this->post->where('root_id',$root_id)->get();
//            return view('postDetail')->with('data',$data);
            return redirect('postList');
        }
    }
}

