<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
    </head>

    <body>
        @yield('info')
        <link href="{{asset('/style/home/css/base.css')}}" rel="stylesheet" />
        <link href="{{asset('/style/home/css/index.css')}}" rel="stylesheet" />
        <link href="{{asset('/style/home/css/style.css')}}" rel="stylesheet" />
        <link href="{{asset('/style/home/css/new.css')}}" rel="stylesheet" />
        <!--[if lt IE 9]>
            <script src="{{asset('/style/home/js/modernizr.js')}}">
            </script>
        <![endif]-->
        <header>
            <div id="logo">
                <a href="/">
                </a>
            </div>
            <nav class="topnav" id="topnav">
                @foreach($navs as $nav)<a href="index.html">
                    <span>{{$nav->nav_name}}</span>
                    <span class="en">{{$nav->nav_alias}}</span>
                </a>@endforeach()
            </nav>
        </header>
        @section('content')
            <!-- Baidu Button BEGIN -->
            <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare">
                <a class="bds_tsina"></a>
                <a class="bds_qzone"></a>
                <a class="bds_tqq"></a>
                <a class="bds_renren"></a><span class="bds_more"></span>
                <a class="shareCount"></a>
            </div>
            <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585"></script>
            <script type="text/javascript" id="bdshell_js"></script>
            <script type="text/javascript">
            document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date() / 3600000)
            </script>
            <!-- Baidu Button END -->
            <div class="blank"></div>
            <h3>
                <p>最新<span>文章</span></p>
            </h3>
            <ul class="rank">
                @foreach($new_articles as $v)
                <li><a href="{{url('/art/'.$v->art_id)}}" title="{{$v->art_title}}" target="_blank">{{$v->art_title}}</a></li>
                @endforeach()
            </ul>
            <h3 class="ph">
                <p>点击<span>排行</span></p>
            </h3>
            <ul class="paih">
                @foreach($hot_articles as $v)
                <li><a href="{{url('/art/'.$v->art_id)}}" title="{{$v->art_title}}" target="_blank">{{$v->art_title}}</a></li>
                @endforeach()
            </ul>


        @show
        <footer>
            <p>
                {!!Config::get('web.copyright')!!} {!!Config::get('web.web_count')!!}
            </p>
        </footer>
    </body>

</html>