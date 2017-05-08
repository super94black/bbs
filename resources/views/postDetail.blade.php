<!DOCTYPE html>
<html>
    <head>
        <title></title>
    </head>
    <body>

    <div>
        <a href="postList">回到首页</a>
    </div>
        <div>
            楼主(1楼)({{$pid_zero['user']['username']}})&nbsp;&nbsp;&nbsp;标题:{{$pid_zero['title']}}<br><br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;内容:{{$pid_zero['content']}}<br><br>
                @foreach($data as $key => $value)
                    @if($value['pid'] != $pid_zero['id'])

                    {{$key + 2}}楼 用户:{{$value['username']}}回复了【用户:{{$value['pname']}}  内容: {{$value['pcontent']}}】&nbsp;&nbsp;&nbsp;<br><br>
                    &nbsp;&nbsp;&nbsp;&nbsp;内容:{{$value['content']}} &nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="reply?pid={{$value['id']}}">回复</a><br><br>

                    @else

                    {{$key + 2}}楼 用户:{{$value['username']}}&nbsp;&nbsp;&nbsp;<br><br>
                    &nbsp;&nbsp;&nbsp;&nbsp;内容:{{$value['content']}} &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="reply?pid={{$value['id']}}">回复</a><br><br>
                    @endif
                @endforeach
        </div>
    <br><br>
    <center><a href="reply?pid={{$pid_zero['id']}}">留言</a></center>
    </body>
</html>