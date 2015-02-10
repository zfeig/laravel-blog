<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/1/14
 * Time: 14:40
 */

class UserController extends BaseController{
    /**
     * 登录页
     *
     * */
    public function getLogin(){
        //若用户已登录，则直接进入后台
        if(Auth::check()){
            return Redirect::to('articles');
        }
        return View::make('user.login');
    }

    /**
     * @return mixed
     */
    // 登录操作
    public function postLogin()
    {
        if (Auth::attempt(array('email'=>Input::get('email'), 'password'=>Input::get('password')))) {
            return Redirect::to('articles')
                ->with('message', '成功登录');
        } else {
            return Redirect::to('user/login')
                ->with('message', '用户名密码不正确')
                ->withInput();
        }
    }

    /**
     * @return mixed
     */
    // 登出
    public function getLogout()
    {
        Auth::logout();
        return Redirect::to('user/login');
    }

    /**
     * @return mixed
     */
    //用户注册页面
    public function getRegister(){
        return  View::make('user.register');
    }

    /**
     * @return mixed
     */
    //注册处理程序
   public function postRegister(){
       $rules=array(
           'nickname' => 'required|alpha_num|min:2',
           'username' => 'required|unique:users',
           'email'=>'required|email|unique:users',
           'password'=>'required|alpha_num|between:5,32',
       );

       $validator = Validator::make(Input::all(),$rules);

       if($validator->passes()){
           $bAdmin = new User();
           $bAdmin->nickname = Input::get('nickname');
           $bAdmin->username = Input::get('username');
           $bAdmin->email = Input::get('email');
           $bAdmin->password = Hash::make(Input::get('password'));
           $bAdmin->save();
           return Redirect::to('user/register')
               ->with('success', '注册成功！');
       }else{
           return Redirect::to('user/register')
               ->withErrors($validator)
               ->withInput();
       }

   }

    /**
     * @return mixed
     */
    //用户主页

    public  function  home(){
        $id=Auth::id();
        //获取当前登录用户信息
        $user=User::find($id);
        return View::make('user.home',compact('user'));
    }


    /**
     * @修改用户信息
     */
    public function edit(){
        $id=Auth::id();
        $info=User::find($id);
        return View::make('user.edit',compact('info'));
    }

    /**
     * post修改用户信息
     */

    public function  postEdit(){
        $id=Auth::id();
        $info=User::find($id);

        $nickname=Input::get('nickname');
        $say=strip_tags(Input::get('say'));

        $rules=array(
            'nickname'=>'required',
            'say'=>'required'
        );

        $validator = Validator::make(Input::all(),$rules);

        if($validator->fails()){
            return Redirect::route('user.edit',compact('info'))->with('error','编辑失败！');
        }

        $info->nickname=$nickname;
        $info->say=$say;
        $info->save();

        return Redirect::route('user.edit',compact('info'))->with('message','编辑成功！');

    }

    /**
     * @修改密码
     */

    public  function pwd(){
        return View::make('user.pwd');
    }


    /**
     * @执行修改密码
     */
    public function  chpwd(){

        $rules=array(
            'pwd'=>'min:6',
            'cfpwd'=>'min:6|same:pwd'
        );

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return Redirect::route('user.pwd')->with('error','修改失败！');
        }
        $info=User::find(Auth::id());
        $newpwd=Hash::make(Input::get('cfpwd'));
        $info->password=$newpwd;
        $info->save();
        return Redirect::route('user.pwd',compact('info'))->with('message','编辑成功！');

    }




    /**
     * @修改头像视图
     */

    public function  modifyPic(){
        $user=User::find(Auth::id());
        return View::make('user.pic',compact('user'));
    }

    /**
     * 上传头像
     */
    public function upload(){

          $path = app_path()."/../public/avatar/";
          $tmpath="/avatar/";

         if(!empty($_FILES)){

            //得到上传的临时文件流
            $tempFile = $_FILES['myfile']['tmp_name'];

            //允许的文件后缀
            $fileTypes = array('jpg','jpeg','gif','png');

            //得到文件原名
            $fileName = iconv("UTF-8","GB2312",$_FILES["myfile"]["name"]);
            $fileParts = pathinfo($_FILES['myfile']['name']);



            //最后保存服务器地址
            if(!is_dir($path)){
                mkdir($path);
            }

            if (move_uploaded_file($tempFile, $path.$fileName)){
                $info= $tmpath.$fileName;
                $status=1;
                $data=array('path'=>app_path(),'file'=> $path.$fileName);
            }else{
                $info=$fileName."上传失败！";
                $status=0;
                $data='';
            }
             echo $info;
        }
    }


     /**
      * @裁剪头像
      */

    public function cutPic(){
        if(Request::ajax()){
            $path="/avatar/";
            $targ_w = $targ_h = 150;
            $jpeg_quality = 100;
            $src = Input::get('f');
            $src=app_path().'/../public'.$src;//真实的图片路径

            $img_r = imagecreatefromjpeg($src);
            $ext=$path.time().".jpg";//生成的引用路径
            $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

            imagecopyresampled($dst_r,$img_r,0,0,Input::get('x'),Input::get('y'),
                $targ_w,$targ_h,Input::get('w'),Input::get('h'));

            $img=app_path().'/../public'.$ext;//真实的图片路径

            if(imagejpeg($dst_r,$img,$jpeg_quality)){
               //更新用户头像
                $user=User::find(Auth::id());
                $user->thumb=$ext;
                $user->save();
                $arr['status']=1;
                $arr['data']=$ext;
                $arr['info']='裁剪成功！';
                echo json_encode($arr);

            }else{
                $arr['status']=0;
                echo json_encode($arr);
            }
            exit;
        }
    }







} 