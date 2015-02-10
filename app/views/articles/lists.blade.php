<style>
    a{text-decoration: none;color:#4288CE}
    h1,.navbars,table{padding:15px;}
    table tr td{border-top: 1px solid #dddddd;padding: 13px}
    a.show{color: #1FB7E0}
    a.del{color:#CD3F3F}
    a.edit{color:#008000}
</style>
{{HTML::script('js/jquery.js')}}
{{HTML::script('js/navbar.js')}}
{{HTML::script('js/navbar.js')}}
{{HTML::script("js/cf.js")}}
 <h1>文章列表</h1>
 @include('navbar')
<div class="navbars">

</div>
 <table>
   <tr>
     <th>文章Id</th>
     <th>文章标题</th>
     <th>文章内容</th>

   </tr>

   @foreach ($articles as $article)
     <tr>
       <td>{{ $article->id }}</td>
       <td>{{ link_to_route('articles.show',$article->title,$article->id,array('class'=>'show'))}}</td>
       <td>{{ $article->text }}</td>
     </tr>
   @endforeach
 </table>