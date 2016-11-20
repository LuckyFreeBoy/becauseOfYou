<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use Crypt;
use App\Http\Model\User;
// use Illuminate\Support\Facades\Input;

use Org\code\Code;
// use Code;
class LoginController extends CommonController
{
	// 登陆
    public function login(Request $request){

    	// Request 与 Input 区别？？？？
    	// 貌似没有太大的区别。
		// dd($request->all());

    	// 课程中的方法
    	// if ($input = Input::all()) {
    	// 	$codes = new \code;
	    // 	$_code = $codes->get();
    	// 	if (strtoupper($input['code']) !== $_code) {
    	// 		return back()->with('msg', '验证码错误！');
    	// 	}
    	// }else{
    	// 	return view('admin.login');
    	// }

    	// 官网方法
    	if ($input = $request->all()) {

    		$code = new code;
	    	$_code = $code->get();
    		if (strtoupper($input['code']) !== $_code) {
    			return back()->with('msg', '验证码错误！');
    		}

    		$user = User::first();
    		// dd($user);
    		if ($input['user_name'] != $user->user_name || Crypt::decrypt($user->user_pass) != $input['user_pass']) {
    			return back()->with('msg', '用户名或密码错误！');
    		}
    		session(['user'=>$user]);
    		// echo $_SESSION['user']['user_name'];die;
    		// dd(session('user.user_name'));
    		return redirect('admin');
    	}else{
    		return view('admin.login');
    	}

    }

    // 验证码图片
    public function code(){

        // 引入文件放到最上面会报错 在控制台里面 php artisan route:list
        // require_once ('../resources/org/code/Code.class.php');
    	$codes = new code;
    	$_code = $codes->make();
		echo $_code;
    }

	// 获取验证码
    public function getcode(){
    	$codes = new code;

        return $codes->get();
    }

    // 加密解密
    public function crypt(){
    	$pass = '123456';

    	echo Crypt::encrypt($pass);
    	echo '<br/>';
    	echo Crypt::decrypt('eyJpdiI6IlBBXC80Y05wbmRmXC9ZU0ZubHEyZFZEUT09IiwidmFsdWUiOiIwUWJ1UThGUzhFOEZOR3lxb0pPbG1BPT0iLCJtYWMiOiI5ZjE0MWZjMmMyYmFiOTkxMzZhMDI0Mzg4NmU3NWRkODU0OTJkMWY2ZmE2YWVjMGUwZTQ0NjQ5YjFmNTkwMWU1In0=');
    }

    // 退出
    public function quit(){
    	session(['user' => null]);
    	return redirect('admin/login');
    }

}
