<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>编辑文章</title>
	{{HTML::script('js/jquery.js')}}
	 {{HTML::script('js/navbar.js')}}
        <script>
        $(function(){
            //点击提示框消失
                $(".success").click(function(){
                    $(this).fadeOut(2000);
                });

                   //获取标签初始值
                   var tag=$("input[name=tag]").val();
                  //增加标签提示
                                $("input[name=tag]").focus(function(){
                                  if($(this).val()=='多个标签以,分隔'){
                                      $(this).val('');
                                  }
                                }).blur(function(){
                                  if($(this).val()==''){
                                      $(this).val('多个标签以,分隔');
                                  }

                                  //更新删除标志.
                                  if($(this).val()!=tag && $(this).val()!="多个标签以,分隔"){
                                        $("input[name=flag]").val(1);
                                  }
                                });

                  //获取删除标签标志，0：不删除,1:删除

                  //获取当前的分类
                  var cid={{$article->cid}};
                  $("#cid>option").each(function(){
                        if( $(this).attr('value')==cid){
                            $(this).attr('selected','selected');
                        };
                  });

        })
        </script>
        {{HTML::style("css/index.css")}}
         {{HTML::style("css/index.css")}}
         {{ Ueditor::css() }}
          {{ Ueditor::content() }}
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
	@include('articles.notifications')
	 @include('navbar')
	<div class="content">
	    <div class="form">
	        {{ Form::open(array('route' => array('articles.update', $article->id), 'method' => 'put')) }}
                                <p class="input_txt">
                                   <span>标题：</span> {{ Form::text('title', $article->title) }}
                                </p>
                                 <p class="input_txt">
                                   <span>作者：</span> {{ Form::text('author', $article->author) }}
                                </p>
                                  <p class="input_txt"> <span>{{Form::label('cid','分类：')}}</span> {{Form::select('cid',$catearr)}}</p>
                                 <p class="input_txt">
                                   <span>简介：</span> {{ Form::text('brief', $article->brief)}}
                                </p>
                                  <p class="input_txt"> <span>{{Form::label('标签：')}}</span> {{Form::text('tag',$tag)}}</p>
                                <p class="input_txt">
                                   <span>{{Form::label('text','内容：')}}</span> {{ Form::textarea('text', $article->text) }}
                                </p>

                                <div>
                                    {{Form::hidden('flag',0)}}
                                    {{ Form::submit('提交',array('class'=>'btn')) }}
                                </div>
                                 <div class="clear"></div>
                            {{ Form::close() }}

	    </div>


	</div>
	</div>
</body>
</html>






