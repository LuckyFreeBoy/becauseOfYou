<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    public function upload(Request $request){
    	$file = $request->file('Filedata');
    	// $tmpName = $file->getFileName();  // 缓存在tmp文件夹中的文件名
    	// $realPath = $file->getRealPath();    //这个表示的是缓存在tmp文件夹下的文件的绝对路径
    	$entension = $file->getClientOriginalExtension(); //上传文件的后缀.
    	// $mimeTye = $file->getMimeType(); // 文件类型  image/jpeg

    	$newName = date('YmdHis').mt_rand(100, 999).'.'.$entension;
    	$path = $file -> move(public_path().'/uploads',$newName);

    	$filepath = '/uploads/'.$newName;
    	return $filepath;
    }
}
