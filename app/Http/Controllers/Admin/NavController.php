<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Model\Nav;
use Validator;
class navController extends CommonController
{
    // get  admin/nav/ 自定义导航列表
    public function index(Request $request)
    {
        // $navs = nav::orderBy('nav_order', 'desc')->get();

        // 搜索条件
        $search['keywords'] = $request->get('keywords');
        
        $data = Nav::where('nav_name','like','%'.$search['keywords'].'%')
                    ->orderBy('nav_order', 'asc')
                    ->paginate(10)
                    ->appends([
                        'keywords' => $search['keywords'],
                        ]);
        return view('admin.nav.list')
                    ->with('data', $data)
                    ->with('search', $search);
    }

    // post ajax更新自定义导航排序
    public function orderChange(Request $request){

        $input = $request->all();
        $nav = Nav::find($input['nav_id']);
        $nav->nav_order = $input['nav_order'];
        $res = $nav->update();

        $data = array();
        if ($res) {
            $data = [
                'status' => 0,
                'msg' => '自定义导航排序更新成功！'
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '自定义导航排序更新失败！请稍后重试。'
            ];
        }

        return $data;
    }

    // get  admin/nav/create 添加自定义导航
    public function create()
    {
        return view('admin.nav.add');
    }

    // post  admin/nav/store 添加自定义导航提交
    public function store(Request $request)
    {
        $input = $request->except('_token');
        // 规则验证
       	$rules = [
	        'nav_name' => 'required',
	        'nav_url' => 'required',
	    ];
	    $message = [
	        'nav_name.required' => '自定义导航名称必须填写！',
	        'nav_url.required' => '自定义导航Url必须填写！',
	    ];
        $validator = Validator::make($input, $rules, $message);
        
        if ($validator->fails()) {

            return back()->withInput()->withErrors($validator);
        }else {
            $res = Nav::create($input);

            if ($res) {
                return redirect('admin/nav')->with('success', '添加自定义导航成功！');
            } else {
                return back()->withErrors('添加自定义导航失败！请稍后重试。');
            }
        }
    }

    // get  admin/nav/{nav}
    public function show($id)
    {
        //
    }

    // get  admin/nav/{nav}/edit
    public function edit($nav_id)
    {
        $nav = Nav::find($nav_id);
        return view('admin.nav.edit')->with('nav',$nav);
    }

    // put  admin/nav/{nav}
    public function update(Request $request, $nav_id)
    {
        $input = $request->except('_token', '_method');
        // 规则验证
        $rules = [
            'nav_name' => 'required',
            'nav_url' => 'required',
        ];
        $message = [
            'nav_name.required' => '自定义导航名称必须填写！',
            'nav_url.required' => '自定义导航Url必须填写！',
        ];
        $validator = Validator::make($input, $rules, $message);
        
        if ($validator->fails()) {

            return back()->withInput()->withErrors($validator);
        }else {
            $res = Nav::where('nav_id', $nav_id)->update($input);
            if ($res) {
                return redirect('admin/nav')->with('success', $input['nav_name'].' 自定义导航修改成功！');
            } else {
                return back()->withErrors('自定义导航修改失败！请稍后重试。');
            }
        }
    }

    // delete  admin/nav/{nav}
    public function destroy($nav_id)
    {
        $res = Nav::where('nav_id', $nav_id)->delete();
        $data = array();
        if ($res) {
            $data = [
                'status' => 0,
                'msg' => '自定义导航删除成功！',
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '自定义导航删除失败，请稍后重试！',
            ];
        }
        return $data;
    }
}
