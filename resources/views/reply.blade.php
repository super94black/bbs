<!DOCTYPE html>
<html>
<head>
    <title>
        发表新帖子
    </title>
</head>
<body>
<center>

    <form action="{{url('replyForm')}}" method="post">
        <input type="hidden" name="pid" value="{{$pid}}">
        content:<textarea rows="20" cols="80" name="content"></textarea><br>
        submit:<input type="submit" value="提交"></input>
    </form>

</center>
</body>
</html>