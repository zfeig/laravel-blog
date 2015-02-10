<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>文章首页</title>
{{HTML::script('js/jquery.js')}}
{{HTML::script('js/navbar.js')}}
{{HTML::script('js/artDialog.js')}}
{{HTML::script("js/cf.js")}}
{{HTML::style("css/index.css")}}
{{HTML::style("css/artDialog.css")}}

<script>
$(function(){
    //点击提示框消失
        $(".success").click(function(){
            $(this).fadeOut(2000);
        });

        $(".error").click(function(){
                    $(this).fadeOut(2000);
                });
})
</script>
</head>
<body>
    <div class="main">
           <div class="top_nav">
                <div class="top_nav_l"> <b class="index"></b>文章列表 <span>/</span>{{link_to_route('articles.index','首页')}}</div>
                <div class="top_nav_r">{{Auth::user()->username}}  {{link_to_route('logout','退出')}}</div>
                <div style="clear:both"></div>
           </div>

            <!--登录成功提示-->
                 @if(Session::has('message'))
                    <div class="success">{{Session::get('message')}}</div>
                    @endif
              <!--错误信息提示-->
                              @if(Session::has('error'))
                                 <div class="error">{{Session::get('error')}}</div>
                                 @endif
                           @include('navbar')
        <div class="content">
                <div class="search">
                {{Form::open(array('url'=>'search','method'=>'get'))}}
                   {{Form::label('key','搜索')}} {{Form::text('key')}}{{Form::submit('搜索',array('id'=>'sh'))}}
                {{Form::close()}}
                </div>
                 <table cellpadding="1" cellspacing="0">
                               <tr>
                                 <th>文章Id</th>
                                 <th>文章标题</th>
                                  <th>文章作者</th>
                                 <th>文章描述</th>
                                  <th colspan="2">编辑操作</th>
                               </tr>

                               @foreach ($articles as $article)
                                 <tr>
                                   <td>{{ $article->id }}</td>
                                   <td>{{ link_to_route('articles.show',$article->title,$article->id,array('class'=>'show'))}}</td>
                                   <td>{{ $article->author }}</td>
                                   <td>{{ $article->brief }}</td>
                                   <td>
                                    {{link_to_route('articles.edit','',$article->id,array('class'=>'edit'))}}
                                   {{link_to_route('articles.del','',$article->id,array('class'=>'del'))}}
                                   </td>
                                 </tr>
                               @endforeach
                               @if(count($articles)==0)
                               <tr><td colspan="5">对不起！暂时没有文章！</td></tr>
                               @endif
                 </table>
                 <div class="con_foot">

                    <div class="create">
                    {{ link_to_route('articles.create', '创建文章') }}
                    </div>
                     <div class="page">
                        <!--<a href="#">1</a><a href="#">2</a><a href="#">3</a><a href="#">4</a>-->
                            {{$articles->links()}}
                     </div>
                     <div style="clear: both"></div>
                 </div>


        </div>

    </div>

</body>
</html>


