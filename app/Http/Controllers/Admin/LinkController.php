<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Model\Link;
use Validator;
class LinkController extends CommonController
{
    // get  admin/link/ 友情链接列表
    public function index(Request $request)
    {
        // $links = Link::orderBy('link_order', 'desc')->get();

        // 搜索条件
        $search['keywords'] = $request->get('keywords');
        
        $data = link::where('link_name','like','%'.$search['keywords'].'%')
                    ->orderBy('link_order', 'desc')
                    ->paginate(10)
                    ->appends([
                        'keywords' => $search['keywords'],
                        ]);
        return view('admin.link.list')
                    ->with('data', $data)
                    ->with('search', $search);
    }

    // post ajax更新友情链接排序
    public function orderChange(Request $request)
    {

        $input = $request->all();
        $link = link::find($input['link_id']);
        $link->link_order = $input['link_order'];
        $res = $link->update();

        $data = array();
        if ($res) {
            $data = [
                'status' => 0,
                'msg' => '友情链接排序更新成功！'
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '友情链接排序更新失败！请稍后重试。'
            ];
        }

        return $data;
    }

    // get  admin/link/create 添加友情链接
    public function create()
    {
        return view('admin.link.add');
    }

    // post  admin/link/store 添加友情链接提交
    public function store(Request $request)
    {
        $input = $request->except('_token');
        // 规则验证
       	$rules = [
	        'link_name' => 'required',
	        'link_url' => 'required',
	    ];
	    $message = [
	        'link_name.required' => '友情链接名称必须填写！',
	        'link_url.required' => '友情链接Url必须填写！',
	    ];
        $validator = Validator::make($input, $rules, $message);
        
        if ($validator->fails()) {

            return back()->withInput()->withErrors($validator);
        }else {
            $res = link::create($input);

            if ($res) {
                return redirect('admin/link')->with('success', '添加友情链接成功！');
            } else {
                return back()->withErrors('添加友情链接失败！请稍后重试。');
            }
        }
    }

    // get  admin/link/{link}
    public function show($id)
    {
        //
    }

    // get  admin/link/{link}/edit
    public function edit($link_id)
    {
        $link = link::find($link_id);
        return view('admin.link.edit')->with('link',$link);
    }

    // put  admin/link/{link}
    public function update(Request $request, $link_id)
    {
        $input = $request->except('_token', '_method');
        // 规则验证
        $rules = [
            'link_name' => 'required',
            'link_url' => 'required',
        ];
        $message = [
            'link_name.required' => '友情链接名称必须填写！',
            'link_url.required' => '友情链接Url必须填写！',
        ];
        $validator = Validator::make($input, $rules, $message);
        
        if ($validator->fails()) {

            return back()->withInput()->withErrors($validator);
        }else {
            $res = link::where('link_id', $link_id)->update($input);
            if ($res) {
                return redirect('admin/link')->with('success', $input['link_name'].' 友情链接修改成功！');
            } else {
                return back()->withErrors('友情链接修改失败！请稍后重试。');
            }
        }
    }

    // delete  admin/link/{link}
    public function destroy($link_id)
    {
        $res = link::where('link_id', $link_id)->delete();
        $data = array();
        if ($res) {
            $data = [
                'status' => 0,
                'msg' => '友情链接删除成功！',
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '友情链接删除失败，请稍后重试！',
            ];
        }
        return $data;
    }
}
