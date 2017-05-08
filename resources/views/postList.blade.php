<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>

       <center>
           <h1>{{$username}}&nbsp;欢迎来到BBS</h1><br>
           <a href="newPost">发表新帖</a><br>
           <a href="logout">退出BBS</a>
           <table border='1'>
               <tr>
                   <td>title</td>
                   <td>post_at</td>
               </tr>
               @foreach($data as $key => $value)
               <tr>
                   <td><a href="postDetail?pid={{$value['id']}}">{{$value['title']}}</a></td>
                   <td>{{$value['created_at']}}</td>
               </tr>
               @endforeach
           </table>
       </center>

    <div>

    </div>
</body>
</html>