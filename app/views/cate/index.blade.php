<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>文章首页</title>
{{HTML::script('js/jquery.js')}}
{{HTML::script('js/navbar.js')}}
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
{{HTML::script('js/artDialog.js')}}
{{HTML::script("js/cf.js")}}
{{HTML::style("css/artDialog.css")}}
{{HTML::style("css/cate.css")}}
</head>
<body>
    <div class="main">
           <div class="top_nav">
                <div class="top_nav_l"> <b class="index"></b>分类列表 <span>/</span>{{link_to_route('articles.index','首页')}}</div>
                <div class="top_nav_r">{{Auth::user()->username}}  {{link_to_route('logout','退出')}}</div>
                <div style="clear:both"></div>
           </div>
            <!--成功提示-->
                 @if(Session::has('message'))
                    <div class="success">{{Session::get('message')}}</div>
                    @endif
            <!--错误提示-->
                 @if(Session::has('error'))
                    <div class="error">{{Session::get('error')}}</div>
                    @endif
                    @include('navbar')
        <div class="content">

                 <table cellpadding="1" cellspacing="0">
                               <tr>
                                 <th>分类Id</th>
                                 <th>分类标题</th>
                                  <th>所属作者</th>
                                 <th>分类描述</th>
                                  <th colspan="2">编辑操作</th>
                               </tr>

                               @foreach ($cate as $cat)
                                 <tr>
                                   <td>{{ $cat->id }}</td>
                                   <td>{{$cat->name}} <span>({{$cat->count}})</span></td>
                                   <td>{{ Auth::user()->username }}</td>
                                   <td>{{ $cat->desc }}</td>
                                   <td>
                                    {{link_to_route('cate.edit','',$cat->id,array('class'=>'edit'))}}
                                   {{link_to_route('cate.del','',$cat->id,array('class'=>'del'))}}
                                   </td>
                                 </tr>
                               @endforeach
                               @if(count($cate)==0)
                               <tr><td colspan="5">对不起！暂时没有文章！</td></tr>
                               @endif
                 </table>
                 <div class="con_foot">

                    <div class="create">
                    {{ link_to_route('cate.create', '创建分类') }}
                    </div>
                     <div class="page">
                        <!--<a href="#">1</a><a href="#">2</a><a href="#">3</a><a href="#">4</a>-->
                            {{$cate->links()}}
                     </div>
                     <div style="clear: both"></div>
                 </div>


        </div>

    </div>

</body>
</html>


