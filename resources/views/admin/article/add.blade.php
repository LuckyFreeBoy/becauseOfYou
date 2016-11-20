@extends('layouts.admin')

@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 添加文章
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
                <a href="{{ url('admin/article/create') }}"><i class="fa fa-plus"></i>添加文章</a>
                <a href="{{ url('admin/article') }}"><i class="fa fa-align-justify"></i>全部文章</a>
               
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/article')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>分类：</th>
                        <td>
                            <select name="art_cid">
                                {{-- <option value="0">==顶级分类==</option> --}}
                                @foreach ($data as $v)
                                <option value="{{$v->cate_id}}">{{$v->cate_name}}</option>
                                @endforeach()
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>文章标题：</th>
                        <td>
                            <input type="text" name="art_title" value="{{old('art_title')}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>分类名称必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th>编辑：</th>
                        <td>
                           <input type="text" class="sm" name="art_editor" value="{{old('art_editor')}}">
                        </td>
                    </tr>
                    <tr>
                        <th>缩略图：</th>
                        <td>
                            <input type="text" size="50" name="art_thumb" value="{{old('art_thumb')}}">
                            <script type="text/javascript" src="{{asset('style/uploadify/jquery.uploadify.min.js')}}"></script>
                            <link rel="stylesheet" type="text/css" href="{{asset('style/uploadify/uploadify.css')}}">
                            <input id="file_upload" name="file_upload" type="file" multiple="true">

                            <script type="text/javascript">
                                <?php $timestamp = time();?>
                                $(function() {
                                    $('#file_upload').uploadify({
                                        'buttonText' : "图片上传",
                                        'formData'     : {
                                            'timestamp' : '<?php echo $timestamp;?>',
                                            '_token'     : "{{csrf_token()}}"
                                        },
                                        'swf'      : "{{asset('style/uploadify/uploadify.swf')}}",
                                        'uploader' : "{{url('admin/upload')}}",
                                        'onUploadSuccess' : function(file, data, response) {
                                                    $("input[name=art_thumb]").val(data);
                                                    $('#art_thumb_img').attr('src', data)
                                                }
                                    });
                                });
                            </script>
                            <style>
                            .uploadify{display:inline-block;}
                            .uploadify-button{border:none; border-radius:5px; margin-top:8px;}
                            table.add_tab tr td span.uploadify-button-text{color: #FFF; margin:0;}
                            </style>

                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <img src="" id="art_thumb_img" alt="" max-width="360px" max-heigth="100px">
                        </td>
                    </tr>
                    <tr>
                        <th>关键词：</th>
                        <td>
                            <textarea name="art_tag">{{old('art_tag')}}</textarea>
                            {{-- <p>这里可以做简单的描述</p> --}}
                        </td>
                    </tr>
                    <tr>
                        <th>描述：</th>
                        <td>
                            <textarea class="lg" name="art_description">{{old('art_description')}}</textarea>
                            {{-- <p>这里可以做简单的描述</p> --}}
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>文章内容：</th>
                        <td>
                            <script type="text/javascript" src="{{asset('style/ueditor/ueditor.config.js')}}"></script>
                            <script type="text/javascript" src="{{asset('style/ueditor/ueditor.all.min.js')}}"></script>
                            <script type="text/javascript" src="{{asset('style/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
                            <style>
                                .edui-default{line-height: 28px;}
                                div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
                                {overflow: hidden; height:20px;}
                                div.edui-box{overflow: hidden; height:22px;}
                            </style>
                            <script type="text/javascript">
                                 var ue = UE.getEditor('editor');
                            </script>
                            <script id="editor" name="art_content" type="text/plain" style="width:860px;height:500px;"></script>
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