@extends('layouts.home')
@section('info')
<title>{{Config::get('web.web_title')}}：{{Config::get('web.seo_title')}}</title>
<meta name="keywords" content="{{Config::get('web.keywords')}}" />
<meta name="description" content="{{Config::get('web.description')}}" />
@endsection()
@section('content')
<div class="banner">
    <section class="box">
        <ul class="texts">
            <p>打了死结的青春，捆死一颗苍白绝望的灵魂。</p>
            <p>为自己掘一个坟墓来葬心，红尘一梦，不再追寻。</p>
            <p>加了锁的青春，不会再因谁而推开心门。</p>
        </ul>
        <div class="avatar"><a href="/"><span>Because of you</span></a> </div>
    </section>
</div>
<div class="template">
    <div class="box">
        <h3>
        <p><span>站长</span>推荐 Recommend</p>
    </h3>
        <ul>
            @foreach($view_articles as $v)
            <li><a href="{{url('art').'/'.$v->art_id}}" target="_blank"><img src="{{asset($v->art_thumb)}}"></a><span>{{$v->title}}</span></li>
            @endforeach()
        </ul>
    </div>
</div>
<article>
    <h2 class="title_tj">
    <p>文章<span>推荐</span></p>
  </h2>
    <div class="bloglist left">
        @foreach($all_articles as $v)
        <h3>{{$v->title}}</h3>
        <figure><img src="{{asset($v->art_thumb)}}"></figure>
        <ul>
            <p>{{$v->art_description}}...</p>
            <a title="/" href="{{url('/art/'.$v->art_id)}}" target="_blank" class="readmore">阅读全文>></a>
        </ul>
        <p class="dateview"><span>{{date('Y-m-d',$v->art_time)}}</span><span>作者：{{$v->art_editor}}</span></p>
        @endforeach()

        <div class="page">
            {{$all_articles->links()}}
        </div>
    </div>
    <aside class="right">
        <div class="weather">
            <iframe width="250" scrolling="no" height="60" frameborder="0" allowtransparency="true" src="http://i.tianqi.com/index.php?c=code&id=12&icon=1&num=1"></iframe>
        </div>
        <div class="news" style="float:left;">
            @parent
            <h3 class="links">
                <p>友情<span>链接</span></p>
            </h3>
            <ul class="website">
                @foreach($links as $v)
                <li><a href="{{$v->link_url}}">{{$v->link_name}}</a></li>
                @endforeach()
            </ul>
        </div>

    </aside>
</article>
@endsection()
