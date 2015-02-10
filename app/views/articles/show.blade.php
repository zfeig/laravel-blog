 <!doctype html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>{{$article->title}}</title>
 		{{HTML::script('js/jquery.js')}}
            {{HTML::script("js/cf.js")}}
            {{HTML::style("css/index.css")}}
 </head>
 <body>
 	<div class="main">
 	    <div class="top_nav">
                        <div class="top_nav_l">{{$article->title}}<span>/</span> 文章列表 <span>/</span>{{link_to_route('articles.index','首页')}}</div>
                        <div class="top_nav_r"> {{link_to_route('logout','退出')}}</div>
                        <div style="clear:both"></div>
                   </div>

       <div class="head">
                   {{ $article->title }}
       </div>

     <div class="show">
       {{ $article->text }}
     </div>
 	</div>
 </body>
 </html>





