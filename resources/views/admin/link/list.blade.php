@extends('layouts.admin')
@section('content')
<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 友情链接列表
</div>
<!--面包屑导航 结束-->
<!--结果页快捷搜索框 开始-->
<div class="search_wrap">
    <form action="{{url('admin/link')}}" method="get">
        <table class="search_tab">
            <tr>
                <th width="70">关键字:</th>
                <td><input type="text" name="keywords" value="{{$search['keywords']}}" placeholder="输入链接名称查询"></td>
                <td><input type="submit" value="查询"></td>
            </tr>
        </table>
    </form>
</div>
<!--结果页快捷搜索框 结束-->

<!--搜索结果页面 列表 开始-->
<form action="#" method="post">
    <div class="result_wrap">
        <!--快捷导航 开始-->
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{ url('admin/link/create') }}"><i class="fa fa-plus"></i>添加友情链接</a>
                <a href="{{ url('admin/link') }}"><i class="fa fa-align-justify"></i>全部友情链接</a>
               {{--  <a href="{{ url('admin/link') }}" target="main"><i class="fa fa-refresh"></i>更新排序</a> --}}
            </div>
        </div>
        <!--快捷导航 结束-->
    </div>
    <script type="text/javascript">
        @if (!empty(session('success'))) 
            layer.msg("{{session('success')}}",{icon: 6})
        @elseif (!empty(session('error')))
            layer.msg("{{session('error')}}",{icon: 5})
        @endif
    </script>
    <div class="result_wrap">
        <div class="result_content">
            <table class="list_tab">
                <tr>
                    {{-- <th class="tc" width="5%"><input type="checkbox" name=""></th> --}}
                    <th class="tc" width="5%">排序</th>
                    <th class="tc" width="5%">ID</th>
                    <th>链接名称</th>
                    <th>链接标题</th>
                    <th>链接地址</th>
                    <th>操作</th>
                </tr>
                @foreach ($data as $v)
                <tr>
                    {{-- <td class="tc"><input type="checkbox" name="id[]" value="{{$v->link_id}}"></td> --}}
                    <td class="tc">
                        <input type="text" onchange="orderChange(this, {{$v->link_id}})" value="{{$v->link_order}}">
                    </td>
                    <td class="tc">{{$v->link_id}}</td>
                    <td><a href="{{$v->link_url}}">{{$v->link_name}}</a></td>
                    <td>{{$v->link_title}}</td>
                    <td>{{$v->link_url}}</td>
                    <td>
                        <a href="{{url('admin/link/'.$v->link_id.'/edit')}}">修改</a>
                        <a href="javascript:deletelink({{$v->link_id}});">删除</a>
                    </td>
                </tr>
                @endforeach()
            </table>
            <div class="page_list">
                {{$data->links()}}
            </div>
        </div>
    </div>
</form>
<!--搜索结果页面 列表 结束-->
<script>
    function orderChange(obj, link_id){
        var link_order = $(obj).val();

        $.post("{{url('admin/link/orderChange')}}", {'_token': '{{csrf_token()}}', 'link_id':link_id, 'link_order':link_order}, function(data){
            if (data.status == 0) {
                layer.msg(data.msg, {icon: 6});
            } else {
                layer.msg(data.msg, {icon: 5});
            }
        });
    }

    function deletelink(link_id){
        //询问框
        layer.confirm('您确定要删除此友情链接吗？', {
            title: '提示',
            btn: ['确定','取消'] //按钮
        }, function(){
            $.post("{{url('admin/link')}}/"+link_id, {'_token': '{{csrf_token()}}', '_method':'delete'}, function(data){
                if (data.status == 0) {
                    location.href = location.href;
                    layer.msg(data.msg, {icon: 6});
                } else {
                    layer.msg(data.msg, {icon: 5});
                }
            });
        })
    }
</script>

@endsection()