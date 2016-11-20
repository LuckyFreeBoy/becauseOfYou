<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Model\Category;
use App\Http\Model\Article;
use Validator;

class ArticleController extends CommonController
{
    // get  admin/article/ 文章列表
    public function index(Request $request)
    {
    	// 搜索条件
    	$search['keywords'] = $request->get('keywords');
    	$search['art_cid'] = $request->get('art_cid');
    	$art_cid = $search['art_cid'];
        $articles = Article::where('art_title','like',$search['keywords'].'%')
        				->where(function($query) use($art_cid){
        						if (!empty($art_cid)) {
        							$query->where('art_cid',$art_cid);
        						}
        					})
        				->orderBy('art_id', 'desc')
        				->paginate(10)
        				->appends([
        					'keywords' => $search['keywords'],
        					'art_id'=>$art_cid
        					]);
        				// dd($search);
        // 文章分类
		$categorys = (new Category)->tree();
        return view('admin.article.list')
        			->with('data', $articles)
        			->with('categorys', $categorys)
        			->with('search', $search);
    }

    // get  admin/article/create 添加文章
    public function create()
    {
        // $data = (new Article)->tree();
        $data = (new Category)->tree();
        return view('admin.article.add', compact('data'));
    }

    // post  admin/article/store 添加文章提交
    public function store(Request $request)
    {
        $input = $request->except('_token');
        // 规则验证
        $rules = [
            'art_title' => 'required',
            'art_content' => 'required',
        ];
        $message = [
            'art_title.required' => '文章标题必须填写！',
            'art_content.required' => '文章内容必须填写！',
        ];
        $input['art_time'] = time();
        $validator = Validator::make($input, $rules, $message);

        if ($validator->fails()) {

            return back()->withInput()->withErrors($validator);
        }else {
            // 默认缩略图
            $input['art_thumb'] = $input['art_thumb']?$input['art_thumb']:config('web.art_default_thumb');
            $res = Article::create($input);

            if ($res) {
                return redirect('admin/article')->with('success', '添加文章成功！');
            } else {
                return back()->withErrors('添加文章失败！请稍后重试。');
            }
        }
    }


    // get  admin/article/{article}/edit
    public function edit($art_id)
    {
        $categorys = (new Category)->tree();
        $art = Article::find($art_id);
        return view('admin.article.edit')->with('data', $categorys)->with('art',$art);
    }

    // put  admin/article/{article}
    public function update(Request $request, $art_id)
    {
        $input = $request->except('_token', '_method');
        // 规则验证
         $rules = [
            'art_title' => 'required',
            'art_content' => 'required',
        ];
        $message = [
            'art_title.required' => '文章标题必须填写！',
            'art_content.required' => '文章内容必须填写！',
        ];

        $validator = Validator::make($input, $rules, $message);

        if ($validator->fails()) {

            return back()->withInput()->withErrors($validator);
        }else {
            // 默认缩略图
            $input['art_thumb'] = $input['art_thumb']?$input['art_thumb']:config('web.art_default_thumb');
            $res = article::where('art_id', $art_id)->update($input);

            if ($res) {
                return redirect('admin/article')->with('success', $input['art_title'].' 文章更新成功！');
            } else {
                return back()->withErrors('文章更新失败！请稍后重试。');
            }
        }
    }

    // delete  admin/article/{article}
    public function destroy($art_id)
    {
        $res = article::where('art_id', $art_id)->delete();
        $data = array();
        if ($res) {
            $data = [
                'status' => 0,
                'msg' => '文章删除成功！',
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '文章删除失败，请稍后重试！',
            ];
        }
        return $data;
    }
}
