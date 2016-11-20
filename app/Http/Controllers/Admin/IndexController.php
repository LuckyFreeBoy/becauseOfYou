<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Model\User;
use Validator;
use Crypt;
class IndexController extends CommonController
{
    public function index(){
    	return view('admin.index');
    }

    public function info(){
        $nav_url = '&raquo; 系统基本信息';
    	return view('admin.info',compact('nav_url'));
    }

    // 修改密码
    public function pass(Request $request)
    {
    	
    	if ($input = $request->all()) {

    		// 规则验证
    		$rules = [
    			'password' => 'required | between:6,20 | confirmed',
    		];
    		$message = [
    			'password.required' => '新密码不能为空！',
    			'password.between' => '密码必须在6到20位之间！',
    			'password.confirmed' => '新密码和确认密码不一致！',
    		];
    		$validator = Validator::make($input, $rules, $message);
    		
    		if ($validator->fails()) {
    			return back()->withErrors($validator);
    		}

    		// 原密码判断
    		$user = User::find(session('user.user_id'));
    		$_password = Crypt::decrypt($user->user_pass);

    		if ($input['password_o'] != $_password) {
    			return back()->withErrors('原密码输入错误！');
    		}else {
    			$user->user_pass = Crypt::encrypt($input['password']);
    			$user->update();
    			return back()->withErrors('密码修改成功！');
    		}
    		
    	}

    	return view('admin.pass');
    }


}
