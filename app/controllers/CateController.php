<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/1/16
 * Time: 11:54
 */

class CateController extends BaseController{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $cate = Cate::where('uid',Auth::id())->paginate(5);//列出属于当前登录用户的文章分类
        return View::make('cate.index', compact('cate'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('cate.create');
    }

    /**
     * @create提交动作
     */
    public function store(){
        //数据验证
        //数据验证
        $rules = array(
            'name' => 'required|min:2',
            'desc'=>'required'
        );

        $validator = Validator::make(Input::all(), $rules);
        //规则校验
        if ($validator->fails())
        {
            return Redirect::route('cate.create')
                ->withErrors($validator)
                ->withInput();
        }
          //检查类名唯一性,不同用户的分类可以相同
            $name=Input::get('name');
            $num=Cate::where('name',$name)->where('uid',Auth::id())->count();
        if($num==0){
            //类别入库
            Cate::create(array(
                'name'=>Input::get('name'),
                'uid'=>Input::get('uid'),
                'desc'=>Input::get('desc')
            ));
            return Redirect::route('cate.create')->with('success', '添加成功！');
        }else{
            return Redirect::route('cate.create')->withInput()->with('error','类名不能重复');
        }

    }

    /**
     * @edit
     */

    public function  edit($id){
        $cate=Cate::find($id);
        if(count($cate)==0){
            return Redirect::route('cate.index')->with('error','分类不存在！');
        }

        //检查是否非法编辑，文章所有者是否一致
        if($cate->uid!==Auth::id()){
            return Redirect::to('user/login');
        }
        return View::make('cate.edit',compact('cate'));
    }

    /**
     * @update
     */

    public function update($id){
        //数据验证
        $rules=array(
            'name'=>'required|min:2',
            'desc'=>'required'
        );
        $validator=Validator::make(Input::all(),$rules);

        if($validator->fails()){
            Return Redirect::route('cate.edit',array('id'=>$id))->withErrors($validator)
                ->withInput();
        }

        //检查是否非法编辑，分类所有者是登录用户
        $cate=Cate::find($id);
        $uid=$cate->uid;//获取uid
        if($uid!=Auth::id()){
            return Redirect::to('user/login');
        }

        //检查修改的用户分类是否唯一
        $count=Cate::where('name',Input::get('name'))->where('uid',Auth::id())->where('id','<>',$id)->count();
        if($count==0){
            //执行更新操作
            $cate->name=Input::get('name');
            $cate->desc=Input::get('desc');
            $cate->save();
            return Redirect::route('cate.edit',array('id'=>$id))->with('success','修改成功！');
        }else{
            Return Redirect::route('cate.edit',array('id'=>$id))->with('error','分类不能重复！')
                ->withInput();
        }
    }

    /**
     * @destroy
     */

    public function destroy($id){

        //权限检查，检查是否非法编辑，分类所有者是登录用户
        $cate=Cate::find($id);
        $uid=$cate->uid;//获取uid
        if($uid!=Auth::id()){
            return Redirect::to('user/login');
        }

        //删除分类
        //Cate::find($id)->delete();//按实例删除
        Cate::destroy($id);//按住键删除

        //修改改分类所属文章状态为0，修改分类为默认值0【可选操作】
        Article::where('cid',$id)->update(array('cid'=>0,'status'=>0));

        return  Redirect::route('cate.index')->with('message','分类删除成功!');
    }

} 