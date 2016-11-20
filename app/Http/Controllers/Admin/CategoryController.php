<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Model\Category;
use Validator;
class CategoryController extends CommonController
{
    // get  admin/category/ 分类列表
    public function index(Request $request)
    {
        $categorys = (new Category)->tree();

        // 搜索条件
        $search['keywords'] = $request->get('keywords');
        $search['cate_pid'] = $request->get('cate_pid');
        
        $cate_pid = $search['cate_pid'];
        $data = Category::where('cate_name','like','%'.$search['keywords'].'%')
                    ->where(function($query) use($cate_pid){
                            if (!empty($cate_pid)) {
                                $query->where('cate_pid',$cate_pid)
                                    // ->orWhere('cate_pid',$cate_pid)
                                ;
                            }
                        })
                    ->paginate(10)
                    ->appends([
                        'keywords' => $search['keywords'],
                        'cate_pid'=>$cate_pid
                        ]);
        $page = $data;

        // 当显示全部分类的时候才排序,有搜索条件是不排序
        if (empty($search['keywords'])) {
            $data = getTree($data, 'cate_name', 'cate_id', 'cate_pid', $cate_pid);
        }

        return view('admin.category.list')
                    ->with('page', $page)
                    ->with('data', $data)
                    ->with('search', $search)
                    ->with('categorys', $categorys);
    }

    // post ajax更新分类排序
    public function orderChange(Request $request)
    {

        $input = $request->all();
        $category = Category::find($input['cate_id']);
        $category->cate_order = $input['cate_order'];
        $res = $category->update();

        $data = array();
        if ($res) {
            $data = [
                'status' => 0,
                'msg' => '分类排序更新成功！'
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '分类排序更新失败！请稍后重试。'
            ];
        }

        return $data;
    }

    // get  admin/category/create 添加分类
    public function create()
    {
        $data = (new Category)->tree();
        return view('admin.category.add', compact('data'));
    }

    // post  admin/category/store 添加分类提交
    public function store(Request $request)
    {
        $input = $request->except('_token');
        // 规则验证
        $rules = [
            'cate_name' => 'required',
        ];
        $message = [
            'cate_name.required' => '分类名称必须填写！',
        ];
        $validator = Validator::make($input, $rules, $message);
        
        if ($validator->fails()) {

            return back()->withInput()->withErrors($validator);
        }else {
            $res = Category::create($input);

            if ($res) {
                return redirect('admin/category')->with('success', '添加分类成功！');
            } else {
                return back()->withErrors('添加分类失败！请稍后重试。');
            }
        }
    }

    // get  admin/category/{categroy}
    public function show($id)
    {
        //
    }

    // get  admin/category/{categroy}/edit
    public function edit($cate_id)
    {
        $categorys = (new Category)->tree();
        $cate = Category::find($cate_id);
        return view('admin.category.edit')->with('data', $categorys)->with('cate',$cate);
    }

    // put  admin/category/{categroy}
    public function update(Request $request, $cate_id)
    {
        $input = $request->except('_token', '_method');
        // 规则验证
        $rules = [
            'cate_name' => 'required',
        ];
        $message = [
            'cate_name.required' => '分类名称必须填写！',
        ];
        $validator = Validator::make($input, $rules, $message);
        
        if ($validator->fails()) {

            return back()->withInput()->withErrors($validator);
        }else {
            $res = Category::where('cate_id', $cate_id)->update($input);
            if ($res) {
                return redirect('admin/category')->with('success', $input['cate_name'].' 分类修改成功！');
            } else {
                return back()->withErrors('分类修改失败！请稍后重试。');
            }
        }
    }

    // delete  admin/category/{categroy}
    public function destroy($cate_id)
    {
        $res = Category::where('cate_id', $cate_id)->delete();
        $data = array();
        if ($res) {
            Category::where('cate_pid', $cate_id)->update(['cate_pid'=>0]);
            $data = [
                'status' => 0,
                'msg' => '分类删除成功！',
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '分类删除失败，请稍后重试！',
            ];
        }
        return $data;
    }
}
