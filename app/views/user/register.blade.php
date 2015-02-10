<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>新用户注册</title>
{{HTML::style('bootstrap/css/bootstrap.min.css')}}
{{HTML::style('css/register.css')}}
{{HTML::script('bootstrap/js/jquery.js')}}
{{HTML::script('bootstrap/js/bootstrap.min.js')}}
<script>
    $(function(){

       //表单提交验证一遍
        $("form").submit(function(){

            //验证用户昵称不为空
            if($("input[name=nickname]").val().length==0){
              $("input[name=nickname]").next().html('用户昵称名为空！');
            }else{
              $("input[name=nickname]").next().removeClass('error').addClass('right').html('昵称合法！');
            }

             //验证用户名不为空
                if($("input[name=username]").val().length==0){
                  $("input[name=username]").next().html('用户名为空！');
                }else{
                   $("input[name=username]").next().removeClass('error').addClass('right').html('用户名合法！');
                }

              //验证邮箱
              var reg=/\w+@\w+.\w+/;
              if(!reg.test($("input[name=email]").val())){
                $("input[name=email]").next().html('邮箱不合法！');
              }else{
                 //验证邮箱是否被占用,如果被占用return false,给出错误提示
                     $("input[name=email]").next().removeClass('error').addClass('right').html('邮箱合法！');
              }


              //验证密码不为空
                var nlength=$("input[name=password]").val().length;
                 if(nlength>4 && nlength<33){
                   $("input[name=password]").next().removeClass('error').addClass('right').html('密码合法！');
                 }else{
                   $("input[name=password]").next().html('密码长度5-32！');
                 }

                //判断正确信息个数，提交表单
                  var len=$(".right").length;
                  if(len==4){
                        return true;
                  }else{
                        return false;
                  }


        });


        //blur状态临时验证，动态改变正确个数

          //用户昵称blur验证

          $("input[name=nickname]").blur(function(){
             if($(this).val().length>0){
                $(this).next().removeClass('error').addClass('right').html('昵称合法！');
              }else{
                $(this).next().removeClass('right').addClass('error').html('用户昵称名为空！');
              }
          })

           //用户名blur验证

                $("input[name=username]").blur(function(){
                   if($(this).val().length>0){
                      $(this).next().removeClass('error').addClass('right').html('用户名合法！');
                    }else{
                      $(this).next().removeClass('right').addClass('error').html('用户名为空！');
                    }
                })

            //用户邮箱验证

                 $("input[name=email]").blur(function(){

                    var reg=/\w+@\w+.\w+/;

                    if(reg.test($(this).val())){
                       $(this).next().removeClass('error').addClass('right').html('邮箱合法！');
                     }else{
                       $(this).next().removeClass('right').addClass('error').html('邮箱不合法！');
                     }
                 })

             //用户名密码验证

                 $("input[name=password]").blur(function(){
                    var plength=$(this).val().length;
                    if(plength>4 && plength<33){
                       $(this).next().removeClass('error').addClass('right').html('密码合法！');
                     }else{
                         $(this).next().removeClass('right').addClass('error').html('密码长度5-32！');
                     }
                 })



    })
</script>

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
             <a class="logo"  href="#"> </a>

         </div>

         <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-6">
            <div class="container">

            </div>

         </div><!-- /.navbar-collapse -->
       </div>
     </nav>
        <!--导航-->
        <!--主题部分-->
        <div class="container" id="register">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3" id="reg">
                        <h1>用户注册 <span class="haslogin">已有账号？<a href="/user/login">登录</a></span>  </h1>
                        <!--注册成功信息-->
                        @if(Session::has('success'))
                        <div class="alert alert-success right-info">
                            {{Session::get('success')}}
                        </div>
                        @endif


                        @if(count($errors)>0)
                        <div class="error-info alert alert-danger">
                          @foreach ($errors->all() as $message)
                                      {{ $message }}&nbsp;&nbsp;
                           @endforeach
                        </div>
                        @endif
                    {{Form::open(array('url'=>'user/register','method'=>'post'))}}
                        <ul class="form-group" id="forms">
                            <li >{{Form::text('nickname','',array('class'=>'form-control','placeholder'=>'用户昵称'))}}
                            <span class="error"></span></li>
                            <li>{{Form::text('username','',array('class'=>'form-control','placeholder'=>'用户名'))}}
                             <span class="error"></span></li>
                            <li>{{Form::email('email','',array('class'=>'form-control','placeholder'=>'认证邮箱'))}}
                             <span class="error"></span></li>
                            <li>{{Form::password('password',array('class'=>'form-control','placeholder'=>'用户密码'))}}
                             <span class="error"></span></li>
                            <li>{{Form::submit('注册',array('class'=>'btn btn-default btn-primary','name'=>'btn'))}}</li>
                            </ul>
                    {{Form::close()}}
                    </div>
                </div>

        </div>

 </div>
</body>
</html>