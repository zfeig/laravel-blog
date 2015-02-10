<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


// 不需要登录验证的路由
Route::get('/', ['as' => 'index','uses'=>'BlogController@index']);

Route::get('/article/{id}',['as'=>'blog.detail','uses'=>'BlogController@detail']);
Route::get('/tags/{uid}/{tag}',['as'=>'blog.detail','uses'=>'BlogController@tag']);

//用户登录
Route::get('user/login', ['as' => 'login', 'uses' => 'UserController@getLogin']);
Route::post('user/login', ['as' => 'login', 'uses' => 'UserController@postLogin']);

//用户注册
Route::get('user/register',['as'=>'register','uses'=>'UserController@getRegister']);
Route::post('user/register',['as'=>'register','uses'=>'UserController@postRegister']);

Route::get('blog/{username}',['as'=>'blog.user','uses'=>'BlogController@user']);
Route::get('blog/cate/{cid}',['as'=>'blog.cate','uses'=>'BlogController@cate']);
Route::get('achieve/{date}/{uid}',['as'=>'blog.achieve','uses'=>'BlogController@achieve']);




// 需要登录验证才能操作的接口
Route::group(array('before' => 'auth'), function()
{
    //退出
    Route::get('user/logout', ['as' => 'logout', 'uses' => 'UserController@getLogout']);

    //用户中心
    Route::get('user/home',['as'=>'home','uses'=>'UserController@home']);
    //修改用户信息
    Route::get('user/edit',['as'=>'user.edit','uses'=>'UserController@edit']);
    Route::post('user/postEdit',['as'=>'user.postEdit','uses'=>'UserController@postEdit']);

    //修改用户密码
    Route::get('user/pwd',['as'=>'user.pwd','uses'=>'UserController@pwd']);
    Route::post('user/chpwd',['as'=>'user.chpwd','uses'=>'UserController@chpwd']);

    //用户头像上传
    Route::get('user/pic', ['as' => 'user.pic', 'uses' => 'UserController@modifyPic']);
    Route::post('user/upload', ['as' => 'user.upload', 'uses' => 'UserController@upload']);
    Route::post('user/cutPic', ['as' => 'user.cutPic', 'uses' => 'UserController@cutPic']);


    //文章管理路由
    Route::resource('articles','ArticlesController');
    Route::get('articles/{id}/del',array('as'=>'articles.del','uses'=>'ArticlesController@destroy'));
    Route::get('search/{key?}','ArticlesController@search');

    //文章回车站管理
    Route::get('recycle',array('as'=>'articles.recycle','uses'=>'ArticlesController@recycle'));
    Route::get('recycle/{ids}/del',array('as'=>'articles.recycle.del','uses'=>'ArticlesController@realDelete'));
    Route::get('find/{key?}','ArticlesController@find');
    Route::post('ajaxEdit','ArticlesController@ajaxEdit');

    //文章分类管理路由
    Route::get('cate',array('as'=>'cate.index','uses'=>'CateController@index'));
    Route::get('cate/create',array('as'=>'cate.create','uses'=>'CateController@create'));
    Route::post('cate',array('as'=>'cate.store','uses'=>'CateController@store'));
    Route::get('cate/{id}/edit',array('as'=>'cate.edit','uses'=>'CateController@edit'));
    Route::put('cate/{id}',array('as'=>'cate.update','uses'=>'CateController@update'));
    Route::get('cate/{id}/del',array('as'=>'cate.del','uses'=>'CateController@destroy'));

});




