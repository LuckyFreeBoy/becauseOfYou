@extends('layouts.admin')

@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 编辑自定义导航
    </div>
    <!--面包屑导航 结束-->
    
    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
            @if (count($errors) > 0) 
                <div class="mark">
                    @foreach($errors->all() as $error)
                    <p>{{$error}}</p>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{ url('admin/nav/create') }}"><i class="fa fa-plus"></i>添加自定义导航</a>
                <a href="{{ url('admin/nav') }}"><i class="fa fa-align-justify"></i>全部自定义导航</a>
               
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/nav/'.$nav->nav_id)}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="put">
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>导航名称：</th>
                        <td>
                            <input type="text" name="nav_name" value="{{$nav->nav_name}}">
                            <input type="text" class="sm" name="nav_alias" value="{{$nav->nav_alias}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>导航名称必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>Url：</th>
                        <td>
                           <input type="text" size="50" name="nav_url" value="{{$nav->nav_url}}">
                           <span><i class="fa fa-exclamation-circle yellow"></i>导航地址必须填写</span>
                        </td>
                    </tr>

                    <tr>
                        <th>排序：</th>
                        <td>
                           <input type="text" class="sm" name="nav_order" value="{{$nav->nav_order}}">
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection()