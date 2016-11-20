<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Model\Article;
use App\Http\Model\Link;
use App\Http\Model\Config;
use App\Http\Model\Category;
class IndexController extends CommonController
{
    public function index()
    {
        // 点击量最高的6篇文章
        $view_articles = Article::orderBy('art_view', 'desc')->limit(6)->get();

        // 图文列表（带分页）
        $all_articles = Article::orderBy('art_id', 'desc')->paginate(5);

        // 友情链接
        $links = Link::orderBy('link_order', 'asc')->get();

        // 网站配置项 （首页 标题 关键字 描述）
        $Configs = Config::get();

    	return view('home.index', compact('view_articles', 'all_articles', 'links', 'Configs'));
    }

    public function list($cate_id)
    {
        // 查看次数自增
        Category::find($cate_id)->increment('cate_view');

        $cate = Category::find($cate_id);
        $cate_arr = Category::where('cate_id',$cate_id)->orWhere('cate_pid', $cate_id)->lists('cate_id');

        $articles = Article::Join('category', 'article.art_cid', '=' ,'category.cate_id')->select('article.*','category.cate_name as art_cname')->whereIn('art_cid', $cate_arr)->paginate(4);

        // 子分类
        $child_cates = Category::where('cate_pid', $cate_id)->get();


    	return view('home.list', compact('cate', 'articles', 'child_cates'));
    }

    public function article($art_id)
    {
        // 查看次数自增
        Article::find($art_id)->increment('art_view');

        // 文章信息
        $data = Article::Join('category', 'article.art_cid', '=' ,'category.cate_id')->select('article.*','category.cate_name as art_cname')->find($art_id);

        // 上一篇 下一篇
        $art['pre'] = Article::select('art_id', 'art_title')->where('art_id', '<', $art_id)->first();
        $art['next'] = Article::select('art_id', 'art_title')->where('art_id', '>', $art_id)->first();

        // 相关文章
        $related = Article::select('art_id', 'art_title')->where('art_cid', $data->art_cid)->where('art_id', '!=', $data->art_id)->limit(6)->get();

    	return view('home.article', compact('data', 'art', 'related'));
    }
}
