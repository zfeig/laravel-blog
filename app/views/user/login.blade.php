<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>login</title>
</head>
<style>
    *{padding: 0;margin: 0;list-style: none}
    body{background: #F3726D}
    .main{width: 330px;height: auto ;margin: 150px auto;text-align: center}
    .main .title{margin-bottom:10px;padding: 10px;color: #fff;font-size: medium;font-weight: 400;font-family: "microsoft yahei", "黑体"}
    .form{background: #fff}
    .form h1{text-align: center;height: 30px;line-height: 30px;background: #F4F4F4;color: #868686;font-size: 12px;border-bottom: 2px solid #E9E9E9;margin: 0 0 30px 0}
    .form p{text-align: left;text-indent: 20px;margin: 5px 0;color: #B6B6B6;font-weight: bold;font-family: "microsoft yahei", "黑体";font-size: 12px;}
    .form .btn{margin-top:15px;height: 30px;line-height: 30px;text-align: center;background: #76B078;color: #fff;border: none;display: inline-block;width: 60px;font-weight: bold;font-size: 13px;cursor: pointer;border-radius: 2px;}
    .form .clear{margin: 30px;width: 30px;height: 30px;}
    .form .text{display: inline-block;width: 250px;height: 40px;line-height: 40px;border: 1px solid #E1E1E1;text-indent: 15px;}
    .error{margin-bottom: 20px;color: #fff}
</style>
<body>
    <div class="main">
        <div class="title">网站后台</div>
        @if(Session::has('message'))
        <div class="error">{{Session::get('message')}}</div>
        @endif
        <div class="form">
            <h1>登录</h1>
            <form action="/user/login" method="post">
                <p>邮箱</p>
                <p><input type="text" class="text" name='email'/></p>
                <p>密码</p>
                <p><input type="password"  class="text" name="password"/></p>
                <p><input type="submit" value="登录" class="btn" name="btn" /></p>
                <div class="clear"></div>
            </form>
        </div>
    </div>
</body>
</html>