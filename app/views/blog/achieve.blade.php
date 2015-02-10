<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>{{$user->username}}的博客</title>
{{HTML::style('bootstrap/css/bootstrap.min.css')}}
{{HTML::style('css/blog.css')}}
{{HTML::script('bootstrap/js/jquery.js')}}
{{HTML::script('bootstrap/js/bootstrap.min.js')}}

</head>
<body>

 <div class="blog">
    <!--导航-->
     <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
       <!-- We use the fluid option here to avoid overriding the fixed width of a normal container within the narrow content columns. -->
       <div class="container-fluid">
         <div class="navbar-header">



           <button type="button" id="toolbar" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-6">
             <span class="sr-only">Toggle navigation</span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
           </button>

            <div id="loginbar" class="navbar-toggle"> <a href="/articles" title="login" class="glyphicon glyphicon-user"></a> </div> </span>

             <a class="logo" title="{{$user->username}}的博客" href="/blog/{{$user->username}}"> </a>
         </div>

         <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-6">
            <div class="container">
                 <ul class="nav navbar-nav">
                             <li class="active"><a href="/blog/{{$user->username}}">首页</a></li>
                             @foreach($cates as $v)
                             <li><a href="/blog/cate/{{$v->id}}">{{$v->name}}</a></li>
                             @endforeach
                           </ul>
            </div>

         </div><!-- /.navbar-collapse -->
       </div>
     </nav>
        <!--导航-->
        <!--主题部分-->
        <div class="container" id="body">
            <div class="row">
                <div class="col-md-8">
<!--左边部分-->
                     <div class="left">
                      <!--文章列表-->
                         <div class="list">
                           @if(count($articles)==0)
                           <h3>暂无更多内容!</h3>
                           @else
                            <!--面包屑导航-->
                                <ol class="breadcrumb">
                                  <li><a href="/blog/{{$user->username}}">博客首页</a></li>
                                  <li><a href="#">全部文章</a></li>
                                </ol>
                                @foreach($articles as $v)
                                <div class="list-item">
                                    <a href="/article/{{$v->id}}"><h2>{{$v->title}}</h2></a>
                                    <div class="a-brief"><blockquote><p>{{$v->brief}}</p></blockquote></div>
                                    <div class="a-tag"><span class="glyphicon glyphicon-tag"></span>
                                     @if(count($v->getTags)>0)
                                       @foreach($v->getTags as $n)
                                        <a href="/tags/{{$n->uid}}/{{$n->tag}}">{{$n->tag}}</a>
                                       @endforeach
                                       @else
                                      <a href="javascript:void(0)"> 暂无标签</a>
                                      @endif

                                     </div>
                                    <div class="a-info"><span class="glyphicon glyphicon-time"></span>&nbsp;{{$v->created_at}}&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-tasks"></span>&nbsp;{{$v->getCate->name}}   &nbsp;&nbsp;&nbsp;&nbsp<span class="glyphicon glyphicon-user"></span>&nbsp;{{$v->author}} </div>
                                </div>
                                @endforeach
                           @endif

                         </div>
                        <!--文章列表-->
                         <!--分页列表-->
                         <div class="page-nav">
                           {{$articles->links()}}
                         </div>
                         <!--分页列表-->
                     </div>
<!--左边部分-->
                </div>
                <div class="col-md-4">

                             <div class="right">
                                <h1>推荐文章：</h1>
                                <div class="recoment">
                                <ul class="list-group">
                                    @foreach($recoment as $v)
                                     <li class='list-group-item'><a href="/article/{{$v->id}}">{{$v->title}}</a></li>
                                     @endforeach
                                </ul>
                                </div>
                            </div>

                            <div class="right">
                                 <div class="cate_tj">
                                   <h1>文章分类：</h1>
                                   <ul class="list-group">
                                   @foreach($cates as $v)
                                       <li class="list-group-item">  <span class="badge">{{$v->count}}</span> <a href="/blog/cate/{{$v->id}}">{{$v->name}}</a></li>
                                    @endforeach
                                       </ul>

                                 </div>
                            </div>





                </div>

            </div>
        </div>

 </div>



</body>
</html>