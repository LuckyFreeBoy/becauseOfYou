<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Model\Nav;
use App\Http\Model\Article;
class CommonController extends Controller
{
    public function __construct(){
    	$navs = Nav::orderBy('nav_order', 'asc')->get();

    	// 最新发布的8篇文章
    	$new_articles = Article::orderBy('art_id','desc')->limit(8)->get();

    	// 点击量最高的5篇文章
    	$hot_articles = Article::orderBy('art_view', 'desc')->limit(5)->get();

    	view()->share('navs', $navs);
    	view()->share('new_articles', $new_articles);
    	view()->share('hot_articles', $hot_articles);
    }
}
