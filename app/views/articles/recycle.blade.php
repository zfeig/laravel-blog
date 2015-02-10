<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>文章首页</title>
{{HTML::style("css/index.css")}}
{{HTML::style("css/artDialog.css")}}
{{HTML::script('js/jquery.js')}}
{{HTML::script('js/navbar.js')}}
{{HTML::script('js/artDialog.js')}}
{{HTML::script("js/cf.js")}}
<script>
$(function(){
    //点击提示框消失
        $(".success").click(function(){
            $(this).fadeOut(2000);
        });

        $(".error").click(function(){
                    $(this).fadeOut(2000);
                });
     //全选按钮，选中当前页所有列表项
      $("#deleteAll").change(function(){
            if($(this).attr('checked')){
              var ids='';
              $("input[name=item]").each(function(i){
                    ids+=$(this).val()+',';
                    $(this).attr('checked',true);
              });
              ids=ids.substring(0,ids.length-1);
              var url='http://'+window.location.host+'/recycle/'+ids+'/del'
             // alert(url);
            }else{
                  $("input[name=item]").each(function(){
                     $(this).attr('checked',false);
                   });
                 var url='javascript:void(0)';
            }
            //替换url
            $("#moredel").attr('href',url);
      });


     //单选按钮，选中当前列
        $("input[name=item]").change(function(){
            //执行遍历操作获取ids
           var ids=iterator();
           //根据ids长度判断如何生存url
             if(ids.length>0){
                ids=ids.substring(0,ids.length-1);
                var url='http://'+window.location.host+'/recycle/'+ids+'/del';
             }else{
                 var url='javascript:void(0)';
             }
             $("#moredel").attr('href',url);
        });

        //遍历函数
        function iterator(){
              var str='';
              $("input[name=item]").each(function(i){
                    if($("input[name=item]").eq(i).attr('checked')){
                        str+=$("input[name=item]").eq(i).val()+',';
                    }
                });
              return str;
        }

        //点击快速编辑事件
        $("#ajaxEdit").click(function(){

             var len=$("input[name=item]:checked").length;

             if(len==0){
                 artDialog({'title':'快速编辑',content:'你还没有选择编辑项！',width:300,'height':150, style:'alert', lock:true,'cancel':true}, function(){this.close();return false; });
                return false;
             }else if(len>1){
                artDialog({'title':'快速编辑',content:'编辑项只能有一个，饭要一口一口吃',width:300,'height':150, style:'alert', lock:true,'cancel':true},
                 function(){
                    $("input[name=item]:checked").attr('checked',false);
                    this.close();
                    return false;
                 });
                 return false;
             }
          //执行异步编辑操作
          var html='@foreach($cate as $v) <span class="cid">{{$v->name}}:{{Form::radio('cid',$v->id)}}</span>@endforeach';

           artDialog({'title':'快速编辑',content:"<h3 class='rq'>请选择分类:</h3>"+html,width:350,'height':150, style:'alert', lock:true,'cancel':true},function(){
               if($("input[name=cid]:checked").length==0){
                $(".rq").css('color','#F34805');
                return false;
               }
                $.post('ajaxEdit',{'id':$("input[name=item]:checked").val(),'cid':$("input[name=cid]:checked").val()},function(obj){
                     if(obj.status==1){

                        //删除节点,删除按钮恢复默认href
                        $("input[name=item]:checked").parents('tr').remove();
                        $("#moredel").attr('href',"javascript:void(0)");
                     }

                },'json');
           });
        });

        //artDialog，点击确认框

             $("#moredel").click(function(){
                         if($("input[name=item]:checked").length==0){
                             artDialog({'title':'批量删除',content:'<h3 class="noitems">你还没有选择删除项！</h3>',width:300,'height':150, style:'alert', lock:true,'cancel':true}, function(){this.close();return false; });
                             return false;
                         }
                         var url=$(this).attr('href');
                                art.dialog.confirm('<h3 class="noitems">你确定要删除所选项吗？数据一旦删除不可恢复！</h3>', function () {
                                   // alert(url);
                                    this.close();
                                    window.location.href=url;
                                }, function () {
                                    this.close();
                                });
                      return false;
             });


})
</script>


</head>
<body>
    @include('navbar')
    <div class="main">
           <div class="top_nav">
                <div class="top_nav_l"> <b class="index"></b>回车站列表 <span>/</span>{{link_to_route('articles.index','首页')}}</div>
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
                {{Form::open(array('url'=>'find','method'=>'get'))}}
                   {{Form::label('key','搜索')}} {{Form::text('key')}}{{Form::submit('搜索',array('id'=>'sh'))}}
                {{Form::close()}}
                </div>
                 <table cellpadding="1" cellspacing="0">
                               <tr>
                               <th><input type="checkbox" id="deleteAll" name="deleteAll">&nbsp;&nbsp;全选</th>
                                 <th>文章Id</th>
                                 <th>文章标题</th>
                                  <th>文章作者</th>
                                 <th>文章描述</th>
                                  <th colspan="2">编辑操作</th>
                               </tr>

                               @foreach ($articles as $article)
                                 <tr>
                                  <td>{{Form::checkbox('item',$article->id)}}</td>
                                   <td> {{ $article->id }}</td>
                                   <td>{{ link_to_route('articles.show',$article->title,$article->id,array('class'=>'show'))}}</td>
                                   <td>{{ $article->author }}</td>
                                   <td>{{ $article->brief }}</td>
                                   <td>
                                    {{link_to_route('articles.edit','',$article->id,array('class'=>'recovery'))}}
                                   {{link_to_route('articles.recycle.del','',$article->id,array('class'=>'fdel'))}}
                                   </td>
                                 </tr>
                               @endforeach
                               @if(count($articles)==0)
                               <tr><td colspan="5">对不起！暂时没有文章！</td></tr>
                               @endif
                 </table>
                 <div class="con_foot">

                    <div class="create">
                    <a id="ajaxEdit" href="javascript:void(0)">快速恢复</a>
                    <a id="moredel" href="javascript:void(0)">批量删除</a>
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


