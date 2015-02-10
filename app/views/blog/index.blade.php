<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>基于laravel的blog</title>
{{HTML::style('bootstrap/css/bootstrap.min.css')}}
{{HTML::style('css/default.css')}}
{{HTML::script('bootstrap/js/jquery.js')}}
{{HTML::script('bootstrap/js/bootstrap.min.js')}}

</head>
<body>

    {{--<nav class="navbar navbar-inverse navbar-fixed-top">--}}
          {{--<div class="container">--}}
            {{--<div class="navbar-header">--}}
              {{--<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">--}}
                {{--<span class="sr-only">Toggle navigation</span>--}}
                {{--<span class="icon-bar"></span>--}}
                {{--<span class="icon-bar"></span>--}}
                {{--<span class="icon-bar"></span>--}}
              {{--</button>--}}
              {{--<a class="navbar-brand" href="#">博客首页</a>--}}
            {{--</div>--}}
            {{--<div id="navbar" class="navbar-collapse collapse">--}}
              {{--<form class="navbar-form navbar-right">--}}
                {{--<div class="form-group">--}}
                  {{--<input type="text" placeholder="Email" class="form-control">--}}
                {{--</div>--}}
                {{--<div class="form-group">--}}
                  {{--<input type="password" placeholder="Password" class="form-control">--}}
                {{--</div>--}}
                {{--<button type="submit" class="btn btn-success">Sign in</button>--}}
              {{--</form>--}}
            {{--</div><!--/.navbar-collapse -->--}}
          {{--</div>--}}
        {{--</nav>--}}

        <!--jumbotron-->
        <div class="jumbotron red">
          <div class="container">
            <h1 class="text-center" >为 Laravel 爱好者创造的博客系统。</h1>
            <p  class="text-center">基于php的著名web框架-laravel开发的博客系统，你值得拥有！</p>

          </div>
        </div>

<!--幻灯片面板-->
                           <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                             <!-- Indicators -->
                             <ol class="carousel-indicators">
                               <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                               <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                               <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                               <li data-target="#carousel-example-generic" data-slide-to="3"></li>
                             </ol>

                             <!-- Wrapper for slides -->
                             <div class="carousel-inner" role="listbox">

                               <div class="item active">
                                 <img src="/images/1.jpg" alt="...">
                                 <div class="carousel-caption">
                                 基于laravel开发
                                 </div>
                               </div>
                               <div class="item">
                                 <img src="/images/2.jpg" alt="...">
                                 <div class="carousel-caption">
                                    流行的响应式设计
                                 </div>
                               </div>

                                <div class="item">
                                    <img src="/images/3.jpg" alt="...">
                                    <div class="carousel-caption">
                                      完善的后台管理
                                    </div>
                                  </div>
                                  <div class="item">
                                      <img src="/images/4.jpg" alt="...">
                                      <div class="carousel-caption">
                                         可扩展的多用户系统
                                      </div>
                                    </div>

                             </div>

                             <!-- Controls -->
                             <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                               <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                               <span class="sr-only">Previous</span>
                             </a>
                             <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                               <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                               <span class="sr-only">Next</span>
                             </a>
                           </div>
                         <!--幻灯片面板-->


        <div class="container brief">

          <!-- Example row of columns -->
          <div class="row">
            <div class="col-md-4">
              <h2>完整的后台管理</h2>
              <p>完美实现后台文章列表，权限检测，文章分类管理，文章分类统计，文章标签管理，文章回车站，文章添加，文章编辑，文章恢复，文章删除，分类删除等常用操作环节，结合artdailog 和ajax操作，不一样的用户体验，轻松上手，博客编写不愁！<a href="/user/login">后台登录</a></p>
            </div>
            <div class="col-md-4">
              <h2>可扩展的多用户支持</h2>
              <p>完美实现多用户注册、用户资料编辑、头像上传、密码修改以及基于登录用户的权限操作，文章管理，分类管理等功能，已经有多位小伙伴：
              @foreach($users as $u)
                <a href="/blog/{{$u->username}}"><img class="img-circle small" src="{{strlen($u->thumb)>0?$u->thumb :'/avatar/photo.jpg'}}"/></a>
              @endforeach
              加入我们的博客系统啦，还等什么？<a href="/user/register">立刻加入</a> </p>

           </div>
            <div class="col-md-4">
              <h2>流行的响应式设计</h2>
              <p>采用流行的响应式,利用响应式框架bootstrap实现,满足了pc端和手机端的访问无缝对接！还等什么，看看下面的文章吧！
              @foreach($articles as $v) <a href="/article/{{$v->id}}">{{$v->title}}</a>&nbsp; @endforeach
              </p>
            </div>
          </div>
          <hr>
        </div>
        <!-- /container -->
          <!--页脚 copyright-->
          <footer>
                 <p>All rights reserved by &copy; Company 2014  laravel blog project</p>
          </footer>
          <!--页脚-->


</body>
</html>