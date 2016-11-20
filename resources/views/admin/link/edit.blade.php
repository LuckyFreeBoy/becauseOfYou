@extends('layouts.admin')

@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 编辑友情链接
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
                <a href="{{ url('admin/link/create') }}"><i class="fa fa-plus"></i>添加友情链接</a>
                <a href="{{ url('admin/link') }}"><i class="fa fa-align-justify"></i>全部友情链接</a>
               
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/link/'.$link->link_id)}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="put">
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>链接名称：</th>
                        <td>
                            <input type="text" name="link_name" value="{{$link->link_name}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>分类名称必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>Url：</th>
                        <td>
                           <input type="text" size="50" name="link_url" value="{{$link->link_url}}">
                           <span><i class="fa fa-exclamation-circle yellow"></i>链接地址必须填写</span>
                        </td>
                    </tr>

                    <tr>
                        <th>链接标题：</th>
                        <td>
                            <input type="text" size="50" name="link_title" value="{{$link->link_title}}">
                            
                        </td>
                    </tr>
                    <tr>
                        <th>排序：</th>
                        <td>
                           <input type="text" class="sm" name="link_order" value="{{$link->link_order}}">
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