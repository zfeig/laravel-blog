<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/1/19
 * Time: 9:46
 */

class BlogController extends BaseController{

    /**
     * @param $username
     * @return mixed
     */
    public function index(){

        //获取推荐文章
        $articles=Article::where('status',1)->groupBy('cid')->take(5)->get();

        //获取推荐用户信息
        $users=User::take(5)->get();

        return View::make('blog.index',compact('articles'))->with('users',$users);
    }

    /*
     * @用户博客首页
     */
    public  function user($username){
        $uname=strip_tags(trim($username));

        //get每次取多条数据,想取多条用take(n)->get();
        $user=User::whereRaw('username =?',array($uname))->take(0)->get();
       // $user=User::where('username',$uname)->take(0)->get();这种写法也可以

        //检查用户是否存在
        if(count($user)==0){
            return Response::make('user not exist',404);
        }

        $uid= $user[0]->id;

       //获取当前用户的全部文章列表，分页显示
        $articles=Article::where('uid',$uid)->where('status',1)->paginate(5);


        //获取文章标签列表[通过uid查找]
        //$tags=Tag::where('uid',$uid)->groupBy('tag')->get();
        $tags=$user[0]->getTags;

        //获取当前用户文章的总数
        $total=Article::where('uid',$uid)->where('status',1)->count();

        //获取当前用户分类总数
        $cates= User::find($uid)->getCate;//关联模型获取cate

        //获取博客创建时间
        $age=$user[0]->created_at;
        $age=$this->formatTime($age);

        //按日期归档
        $date=Article::select(DB::raw("DATE_FORMAT(created_at,'%Y%m') as time,count( DATE_FORMAT(created_at,'%Y%m')) as num"))->where('uid',$uid)->where('status',1)->groupBy('time')->orderBy('created_at','desc')->get();

        return View::make('blog.user', compact('articles'))->with('tags',$tags)->with('user',$user[0])->with('count',count($articles))->with('total',$total)
            ->with('cates',$cates)->with('age',$age)->with('date',$date);

    }

    /**
     * @文章详情页
     */
    public function detail($id){

        try{
            $aid=intval($id);
            }catch(Exception $e){
            echo 'error request!';exit();
           }

        //查询文章信息
        $article=Article::find($aid);

        if(!is_object($article)){
            return Response::make('article not exist','404');
        }
        if(!$article->status){
            return Response::make('article is missing,maybe is deleted','400');
        }
        //获取用户id
        $uid=$article->uid;

        //获取用户信息
        $user=User::find($uid);

        //获取当前用户分类信息
        $cates=$user->getCate;

        //获取当前用户推荐文章5篇
        $recoment=Article::where('uid',$uid)->where('status',1)->orderBy('updated_at','desc')->take(5)->get();

        return View::make('blog.detail',compact('article'))->with('user',$user)->with('cates',$cates)->with('recoment',$recoment);


    }


    /**
     * @日期计算函数
     */

   private  function  formatTime($time){
        $t=time()-strtotime($time);
        if($t<0){
            return false;
        }

        switch ($t){
            case $t<60:return $t.'秒前';break;
            case $t>=60 && $t<3600:return floor($t/60).'分钟前';break;
            case $t>=3600 && $t<86400:return floor($t/3600).'小时前';break;
            case $t>=86400 && $t<604800:return floor($t/86400).'天前';break;
            case $t>=604800 && $t<2419200:return floor($t/604800).'周前';break;
            case $t>=2419200 && $t<29030400:return floor($t/2419200).'月前';break;
            case $t>=29030400:return floor($t/29030400).'年前';break;
            default:return '刚刚';
        }

    }


    /**
     * @分类文章列表
     */
    public function cate($cid){
        try{
            $cid=intval($cid);
        }catch(Exception $e){
            echo 'error request!';exit();
        }

        $curCate=Cate::find($cid);

        //检查分类合法性
        if(!is_object($curCate)){
            return Response::make('cate not exist',404);
        }

        //当前用户id;
        $uid= $curCate->uid;

        //根据uid查找用户信息
        $user=User::find($uid);

        //根据关联模型查找当前用户所有分类
        $cates=$user->getCate;

        //查找用户当前分类下的文章列表，分页显示
        $articles=Article::where('cid',$cid)->where('uid',$uid)->where('status',1)->paginate(2);

        //户当前分类下的文章总数
        $count=Article::where('cid',$cid)->where('uid',$uid)->where('status',1)->count();

        //查找最新文章
        $recoment=Article::where('uid',$uid)->where('status',1)->orderBy('updated_at')->take(5)->get();



        return View::make('blog.cate',compact('articles'))->with('user',$user)->with('cates',$cates)->with('curCate',$curCate->name)
            ->with('count',$count)->with('recoment',$recoment);



    }

    /**
     * @tag
     */
    public function tag($uid,$tag){
        //参数处理
        $uid=intval($uid);
        $tag=strip_tags(trim($tag));

        //获取当前标签下的文章列表
        $rs=Tag::where('uid',$uid)->where('tag',$tag)->get();
        if(count($rs)==0){
            return Response::make('tag not exist');
        }
        $arr=array();
        foreach($rs as $v){
            array_push($arr,$v->aid);
        }

        $articles=Article::whereIn('id',$arr)->where('status',1)->paginate(5);

        //获取博客用户信息
        $user=User::find($uid);

        //获取用户文章分类
        $cates=$user->getCate;

        //获取用户所有tags
        $tags=Tag::where('uid',$uid)->groupBy('tag')->get();

        //获取当前用户推荐文章5篇
        $recoment=Article::where('uid',$uid)->where('status',1)->orderBy('updated_at','desc')->take(5)->get();

        return View::make('blog.tag',compact('articles'))->with('user',$user)->with('cates',$cates)->with('recoment',$recoment)
            ->with('tags',$tags)->with('tag',$tag);

    }

    /**
     * @achieve,按日期归档的文章
     */

        public function  achieve($date,$uid){
            //参数处理
            $uid=intval($uid);
            $date=strip_tags(trim($date));

            //获取博客用户信息
            $user=User::find($uid);

            if(!is_object($user)){
                return Response::make('user not exist',404);
            }

            //获取日期参数
            $arr=str_split($date,4);
            $date=$arr[0].'-'.$arr[1];

            //获取对应文章
            $para="%".$date."%";
            $articles=Article::where('uid',$uid)->where('created_at','like',$para)->where('status',1)->paginate(5);

            //echo count($articles);die();
            //获取用户文章分类
            $cates=$user->getCate;

            //获取当前用户推荐文章5篇
            $recoment=Article::where('uid',$uid)->where('status',1)->orderBy('updated_at','desc')->take(5)->get();

            return View::make('blog.achieve',compact('articles'))->with('user',$user)->with('cates',$cates)->with('recoment',$recoment);
        }

} 
