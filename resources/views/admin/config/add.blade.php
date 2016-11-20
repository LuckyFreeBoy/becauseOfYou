@extends('layouts.admin')

@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 添加网站配置
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
                <a href="{{ url('admin/config/create') }}"><i class="fa fa-plus"></i>添加网站配置</a>
                <a href="{{ url('admin/config') }}"><i class="fa fa-align-justify"></i>全部网站配置</a>
               
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/config')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>标题：</th>
                        <td>
                            <input type="text" name="conf_title" value="{{old('conf_title')}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>配置标题必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>名称：</th>
                        <td>
                            <input type="text" name="conf_name" value="{{old('conf_name')}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>配置名称必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th>类型：</th>
                        <td>
                            <label><input type="radio" name="field_type" onclick="showTr(this)" value="input"
                                @if (old('field_type'))
                                    @if (old('field_type')== 'input') 
                                            checked
                                        @endif()
                                @else
                                    checked
                                @endif()
                            />input</label>
                            <label><input type="radio" name="field_type" onclick="showTr(this)" value="textarea" 
                                @if (old('field_type')== 'textarea') 
                                        checked
                                    @endif()
                            />textarea</label>
                            <label><input type="radio" name="field_type" onclick="showTr(this)" value="radio" 
                                @if (old('field_type')== 'radio') 
                                        checked
                                    @endif()
                            />radio</label>
                                
                            {{-- <span><i class="fa fa-exclamation-circle yellow"></i>类型： input textarea radio</span> --}}
                        </td>
                    </tr>

                    <tr class="field_value">
                        <th>类型值：</th>
                        <td>
                           <input type="text" class="lg" name="field_value" value="{{old('field_value')}}">
                           <p><i class="fa fa-exclamation-circle yellow"></i>类型值只有在radio的情况下才需要填写，格式：1|开启,0|关闭</p>
                        </td>
                    </tr>
                    <tr>
                        <th>排序：</th>
                        <td>
                           <input type="text" class="sm" name="conf_order" value="{{old('conf_order')?old('conf_order'):0}}">
                        </td>
                    </tr>

                    <tr>
                        <th>说明：</th>
                        <td>
                            <textarea name="conf_tips" cols="30" rows="10">{{old('conf_tips')}}</textarea>
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
    <script type="text/javascript">
        showTr();
        function showTr(obj){
            var type=$("input[name=field_type]:checked").val()
            if (type == 'radio') {
                $('.field_value').show();
            }else {
                $('.field_value').hide();
            }
        }
    </script>
@endsection()