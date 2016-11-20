@extends('layouts.home')

@section('info')
<title>{{$cate->cate_name}}：{{Config::get('web.seo_title')}}</title>
<meta name="keywords" content="{{$cate->cate_keywords}}" />
<meta name="description" content="{{$cate->cate_description}}" />
@endsection()

@section('content')
<article class="blogs">
    <h1 class="t_nav"><span>{{$cate->cate_description}}</span><a href="{{url('/')}}" class="n1">网站首页</a><a class="n2">{{$cate->cate_name}}</a></h1>
    <div class="newblog left">
        @foreach($articles as $v)
        <h2>{{$v->art_title}}</h2>
        <p class="dateview"><span>发布时间：{{date('Y-m-d', $v->art_time)}}</span><span>作者：{{$v->art_editor}}</span><span>分类：[<a href="{{url('/list/'.$v->art_cid)}}">{{$v->art_cname}}</a>]</span></p>
        <figure><img src="{{asset($v->art_thumb)}}"></figure>
        <ul class="nlist">
            <p>{{$v->art_description}}</p>
            <a title="{{$v->art_title}}" href="{{url('/art/'.$v->art_id)}}" target="_blank" class="readmore">阅读全文>></a>
        </ul>
        <div class="line"></div>
        @endforeach()

        <div class="blank"></div>
        <div class="ad">
            <img src="images/ad.png">
        </div>
        <div class="page">
            {{$articles->links()}}
        </div>
    </div>
    <aside class="right">
        @if($child_cates)
        <div class="rnav">
            <ul>
                @foreach($child_cates as $k => $v)
                <li class="rnav{{$k%4+1}}"><a href="{{url('/list/'.$v->cate_id)}}" target="_blank">{{$v->cate_name}}</a></li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="news">
            @parent
        </div>
        <div class="visitors">
            <h3><p>最近访客</p></h3>
            <ul>
            </ul>
        </div>
    </aside>
</article>
@endsection()
