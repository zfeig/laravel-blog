<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>register</title>
    {{HTML::script('js/jquery.js')}}
    {{HTML::script("js/navbar.js")}}
    {{HTML::style("css/index.css")}}
</head>
<body>
    <div class="main">
       <div class="top_nav">
                       <div class="top_nav_l"> <b class="index"></b>网站后台 <span>/</span><a href="/articles">首页</a><span>/</span>用户主页</div>
                       <div class="top_nav_r"> {{link_to_route('logout','退出')}}</div>
                       <div style="clear:both"></div>
       </div>

           @include('navbar')
        <div class="content">
                 <div class="form home">
                  <h3>用户信息：</h3>
                  <div class="thumb">
                    @if($user->thumb)
                    <img src="{{$user->thumb}}" alt=""/>
                    @else
                    <img src="/avatar/photo.jpg" alt=""/>
                    @endif
                  </div>
                  <p>用户昵称：{{$user->nickname}}</p>
                  <p>用户名：{{$user->username}}</p>
                  <p>认证邮箱：{{$user->email}}</p>
                  <p>个人简介：@if($user->say){{$user->say}}@else 暂无信息 @endif</p>
                 </div>
        </div>

    </div>
</body>
</html>