<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Laravel PHP Framework</title>
	 {{HTML::script('js/jquery.js')}}
	  {{HTML::script('js/navbar.js')}}
     {{HTML::style("css/index.css")}}
     {{ Ueditor::css() }}
      {{ Ueditor::content() }}
       <script>
           $(function(){
               //点击提示框消失
                   $(".success").click(function(){
                       $(this).fadeOut(2000);
                   });

                //增加标签提示
                $("input[name=tag]").focus(function(){
                  if($(this).val()=='多个标签以,分隔'){
                      $(this).val('');
                  }
                }).blur(function(){
                  if($(this).val()==''){
                      $(this).val('多个标签以,分隔');
                  }
                });


           })
           </script>
     {{ Ueditor::js() }}
     <script>
          var ue = UE.getEditor('text');
     </script>
</head>
<body>
	<div class="main">
        <div class="top_nav">
               <div class="top_nav_l"><b class="index"></b> 网站后台 <span>/</span>{{link_to_route('articles.index','首页')}}<span>/</span>添加文章</div>
               <div class="top_nav_r"> {{link_to_route('logout','退出')}}</div>
               <div style="clear:both"></div>
        </div>
        @if(Session::has('message'))
        <div class="success">
            {{Session::get('message')}}
        </div>
        @endif
	@include('navbar')
	@include('articles.notifications')
        <div class="content">
            <div class="form">
                {{Form::open(array('url'=>'articles','method'=>'post'))}}
                        <p class="input_txt"> <span>{{Form::label('标题：')}}</span> {{Form::text('title')}}</p>
                         <p class="input_txt"> <span>{{Form::label('作者：')}}</span> {{Form::text('author')}}</p>
                         <p class="input_txt"> <span>{{Form::label('cid','分类：')}}</span> {{Form::select('cid',$catearr)}}</p>
                           <p class="input_txt"> <span>{{Form::label('标签：')}}</span> {{Form::text('tag','多个标签以,分隔')}}</p>
                          <p class="input_txt"> <span>{{Form::label('简介：')}}</span> {{Form::text('brief')}}</p>
                         <p class="input_txt"> <span>{{Form::label('text','内容：')}}</span> {{Form::textarea('text')}}</p>
                        <div>
                        {{Form::hidden('uid',Auth::id())}}
                        {{Form::submit('添加',array('class'=>'btn'))}}
                        </div>
                         <div class="clear"></div>
                    {{Form::close()}}
            </div>
        </div>
	</div>
</body>
</html>

