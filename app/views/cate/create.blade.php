<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Laravel PHP Framework</title>
	 {{HTML::script('js/jquery.js')}}
	  {{HTML::script('js/navbar.js')}}
     {{HTML::script("js/cf.js")}}
     {{HTML::style("css/cate.css")}}
     {{ Ueditor::css() }}
      {{ Ueditor::content() }}
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
     {{ Ueditor::js() }}
     <script>
          var ue = UE.getEditor('desc');
     </script>
</head>
<body>
	<div class="main">
        <div class="top_nav">
               <div class="top_nav_l"><b class="index"></b> 网站后台 <span>/</span>{{link_to_route('cate.index','首页')}}<span>/</span>添加文章分类</div>
               <div class="top_nav_r"> {{link_to_route('logout','退出')}}</div>
               <div style="clear:both"></div>
        </div>

       <!--成功提示-->
                      @if(Session::has('success'))
                         <div class="success">{{Session::get('success')}}</div>
                         @endif
                 <!--错误提示-->
                      @if(Session::has('error'))
                         <div class="error">{{Session::get('error')}}</div>
                         @endif
	@include('navbar')
        <div class="content">
            <div class="form">
                {{Form::open(array('url'=>'cate','method'=>'post'))}}
                        <p class="input_txt"> <span>{{Form::label('标题：')}}</span> {{Form::text('name')}}</p>
                         <p class="input_txt"> <span>{{Form::label('desc','描述：')}}</span> {{Form::textarea('desc')}}</p>
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

