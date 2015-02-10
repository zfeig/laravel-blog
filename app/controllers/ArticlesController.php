<?php

class ArticlesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        //列出属于当前登录用户的文章
        $articles = Article::where('uid',Auth::id())->where('cid','>',0)->paginate(5);
        return View::make('articles.index', compact('articles'));
	}

    /**
     * @文章回收站
     */

    public function recycle(){
        //列出属于当前登录用户的回收站文章
        $articles=Article::where('uid',Auth::id())->where('status',0)->paginate(5);
        $cate=User::find(Auth::id())->getCate;//关联模型获取cate
        return View::make('articles.recycle', compact('articles'))->with('cate',$cate);

    }

    /**
     * @search
     */

    public function search($key=''){

        $key=Input::get('key')?strip_tags(trim(Input::get('key'))):$key;
        $para="%".htmlspecialchars($key)."%";
        //$articles=Article::whereRaw("title like ?",array('?'=>$para))->paginate(1);//这种方法可行
          $articles=Article::where('title','like',$para)->where('uid',Auth::id())->where('cid','>',0)->paginate(5);
        return View::make('articles.search', compact('articles'))->with('key',$key);
    }


    /**
     * @find,查找回车站文章
     */

    public function find($key=''){
        $key=Input::get('key')?strip_tags(trim(Input::get('key'))):$key;
        $para="%".htmlspecialchars($key)."%";
        //$articles=Article::whereRaw("title like ?",array('?'=>$para))->paginate(1);//这种方法可行
        $articles=Article::where('title','like',$para)->where('uid',Auth::id())->where('cid',0)->paginate(5);
        //获取分类
        $cate=User::find(Auth::id())->getCate;//关联模型获取cate
        return View::make('articles.find', compact('articles'))->with('key',$key)->with('cate',$cate);
    }




    /**
     * @首页文章列表
     */

    public function lists()
    {
        $articles = Article::all();

        return View::make('articles.lists', compact('articles'));
    }


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

       $getCate=  User::find(Auth::id())->getCate;//关联模型获取cate

        //首先检查分类，分类不存在，提示用户添加分类先
        if(count($getCate)==0){
            return Redirect::to('cate')->with('error','请先创建分类!');
        }
        $catearr=array();
        foreach($getCate as $k=>$v){
            $catearr[$v->id]=$v->name;
        }
		return View::make('articles.create',compact('catearr'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

        //数据验证
        $rules = array(
            'title' => 'required|min:5',
            'brief'=>'required',
            'text'=>'required',
        );

        $validator = Validator::make(Input::all(), $rules);
        //规则校验
        if ($validator->fails())
        {
            return Redirect::route('articles.create')
                ->withErrors($validator)
                ->withInput();
        }
        $tag=Input::get('tag');//获取tag值
        //文章入库
        $article = Article::create(
           array('title' => Input::get('title'), 'author' => Input::get('author'), 'brief' => Input::get('brief'), 'text' => Input::get('text'),'uid'=>Input::get('uid'),'cid'=>Input::get('cid'))
       );

        //对应分类文章数自增
        Cate::where('id',Input::get('cid'))->increment('count');
        //处理标签，如果存在tag且tag不为默认提示，则入库
        if($tag && $tag!="多个标签以,分隔"){
            $tag=str_replace('，',',',$tag);//中文状态逗号，替换成英文逗号
            $tag=trim($tag,',');
            $arr=explode(',',$tag);//拆分标签入库
            foreach($arr as $k=>$v){
                Tag::create(array('uid'=>Auth::id(),'tag'=>$v,'aid'=>$article->id ));
            }
        }

        //添加操作提示
        return Redirect::route('articles.create')->with('message', '添加成功！');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $article = Article::find($id);

        return View::make('articles.show', compact('article'));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

        $article = Article::find($id);
        if(count($article)==0){
           return Redirect::route('articles.index')->with('error','文章不存在！');
        }


        //检查是否非法编辑，文章所有者是否一致
        if($article->uid!==Auth::id()){
            return Redirect::to('articles')->with('error','非法访问操作！');
        }

        //获取所有分类
        $getCate=  User::find(Auth::id())->getCate;//关联模型获取cate
        $catearr=array();
        foreach($getCate as $k=>$v){
            $catearr[$v->id]=$v->name;
        }

        //获取文章管理标签
        $tags=Tag::where('aid','=',$id)->get();
        $tag='';
        foreach($tags as $v){
            $tag.=$v->tag.',';
        }
        $tag=trim($tag,',');
        return View::make('articles.edit', compact('article'))->with('tag',$tag)->with('catearr',$catearr);
	}


	/**
	 * Update the specified resource in storage.
	 * @文章编辑和恢复操作
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        //数据验证
        $rules = array(
            'title' => 'required|min:5',
            'brief'=>'required|min:5',
            'text'=>'required'
        );

        $validator = Validator::make(Input::all(), $rules);
        $article = Article::find($id);

        if ($validator->fails())
        {
            return Redirect::route('articles.edit',array('id'=>$article->id))
                ->withErrors($validator)
                ->withInput();
        }


        $msg='编辑成功';
        //更新cate中文章数量,条件是cid改变了
        if($article->cid!=Input::get('cid')){

            //有分类的文章才执行原有分类自增
            if($article->cid>0){
                Cate::where('id',$article->cid)->decrement('count');
            }else{
                $article->status=1;//恢复操作
                $msg='恢复成功';
            }
            Cate::where('id',Input::get('cid'))->increment('count');
        }



        //更新文章
        $article->title = Input::get('title');
        $article->text = Input::get('text');
        $article->author=Input::get('author');
        $article->brief=Input::get('brief');
        $article->cid=Input::get('cid');
        $article->save();



        //更新标签
        $flag=Input::get('flag');//跟新tag标志之一
        $tags=Input::get('tag');
        $tags=trim($tags,",");
        if($flag && $tags && $tags!="多个标签以,分隔"){
            //删除旧标签
            Tag::where('aid','=',$article->id)->delete();
            //添加新标签
           $tags= str_replace("，",",",$tags);//中文状态逗号，替换成英文逗号
            $arr=explode(',',$tags);//拆分标签入库
            foreach($arr as $k=>$v){
                Tag::create(array('uid'=>Auth::id(),'tag'=>$v,'aid'=>$article->id ));
            }

        }

        return Redirect::route('articles.edit', array($article->id))->with('message',$msg);
	}



    /**
     * @快速编辑
     */
    public function ajaxEdit(){
        //默认非法请求
        $status=0;
        $info='非法请求';
        $data='';
        if(Request::ajax()){
            //获取请求参数
            $id=Input::get('id');//要编辑的文章id
            $cid=Input::get('cid');//重新分类id
            //判断请求权限[cid=0 && uid=Auth::id()]
            $obj=Article::find($id);

            //最严格的判断，检查传过来的cid，是否是伪造的；即Input::get('cid')是否在当前uid所属分类数组中【省略】；
            if($obj->cid==0 && $obj->uid==Auth::id()){
                //更新分类与分类文章数量，更新文章状态
                Cate::where('id',$cid)->increment('count');//文章总数自增1
                $obj->cid=$cid;//更新文章分类id
                $obj->status=1;//更新文章状态
                $obj->save();
                //返回正确结果
                $status=1;
                $info=$id;
                $data=$cid;
            }
        }
        $arr=array(
            'status'=>$status,
            'data'=>$data,
            'info'=>$info
        );
       echo json_encode($arr);

    }


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
     * articles/id/delete 自定义路由
	 */
	public function destroy($id)
	{
        //删除文章标签[真实删除]
       // Tag::where('aid',$id)->delete();

        //检查假删权限【文章uid为登录用户id,并且文章有分类cid!=0】
        $obj=Article::find($id);
        if($obj->cid==0 || $obj->uid!=Auth::id()){
            return Redirect::route('articles.index')->with('error','不被允许的非法操作！');
        }
        //文章分类总数减1
        $cid= Article::find($id)->cid;
        Cate::where('id',$cid)->decrement('count');

        //更改文章分类和状态
        Article::where('id',$id)->update(array('cid'=>0,'status'=>0));

        return Redirect::route('articles.index')->with('message','删除成功！');
	}

    /**
     * @回车站彻底删除
     */
    public function realDelete($ids){

        //检查删除安全和正确性
        $arr=explode(',',$ids);
        //检查删除权限，防止当前用户删除其他用户文章漏洞
        foreach($arr as $v){
            if(Article::find($v)->uid!=Auth::id()){
                return Redirect::route('articles.recycle')->with('error','警告！无法对未授权的文章进行危险操作！');
            }
        }

        //检查删除项必须是没有分类的文章，防止非法get提交
        $record= Article::whereIn("id",$arr)->sum('cid');
        if($record>0){
           return Redirect::route('articles.recycle')->with('error','警告！检查到有非回车站中的文章进行危险操作！');
        }


        //彻底删除对应tag
        Tag::whereIn('aid',$arr)->delete();

        //彻底删除文章
        Article::destroy($arr);

        //回到回车站主页
        return Redirect::route('articles.recycle')->with('message','删除成功！');
    }


}
