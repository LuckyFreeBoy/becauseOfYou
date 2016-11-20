<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    // Route::get('/', function () {
    //     return view('welcome');
    // });

    Route::get('/', 'Home\IndexController@index');
    Route::get('/list/{cate_id}', 'Home\IndexController@list');
    Route::get('/art/{art_id}', 'Home\IndexController@article');

    // // 登陆
    Route::any('/admin/login', 'Admin\LoginController@login');

    // // 验证码图片
    Route::get('/admin/code', 'Admin\LoginController@code');

    // // 获取验证码
    // Route::get('/admin/getcode', 'Admin\LoginController@getcode');

    // // 加密
    // Route::get('/admin/crypt', 'Admin\LoginController@crypt');

});

Route::group(['middleware' => ['web', 'admin.login'], 'prefix'=>'admin', 'namespace'=>'Admin'], function(){
	// 主页
	Route::get('/', 'IndexController@index');
	Route::get('info', 'IndexController@info');

	// 退出
	Route::get('quit', 'LoginController@quit');

	// 修改密码
	Route::any('pass', 'IndexController@pass');

	// 分类
	Route::resource('category', 'CategoryController');

	// 修改分类排序
	Route::post('category/orderChange', 'CategoryController@orderChange');

	// 文章
	Route::resource('article', 'ArticleController');

	// 图片上传
	Route::any('upload', 'CommonController@upload');

	// 友情链接
	Route::resource('link', 'LinkController');
	// 修改友情链接排序
	Route::post('link/orderChange', 'LinkController@orderChange');// 友情链接

	// 自定义导航
	Route::resource('nav', 'NavController');
	// 修改友情链接排序
	Route::post('nav/orderChange', 'NavController@orderChange');

	// 网站配置内容修改
	Route::any('config/putfile', 'ConfigController@putFile');
	// 网站配置
	Route::resource('config', 'ConfigController');
	// 网站配置排序
	Route::post('config/orderChange', 'ConfigController@orderChange');
	// 网站配置内容修改
	Route::post('config/confContentChange', 'ConfigController@confContentChange');

});