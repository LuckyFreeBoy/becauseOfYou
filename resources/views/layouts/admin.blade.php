<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="{{asset('style/admin/css/ch-ui.admin.css')}}">
	<link rel="stylesheet" href="{{asset('style/admin/font/css/font-awesome.min.css')}}">
	<script type="text/javascript" src="{{asset('style/admin/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('style/admin/js/ch-ui.admin.js')}}"></script>
    <script type="text/javascript" src="{{asset('style/layer/layer.js')}}"></script>
   	<style type="text/css">
   	    /*分页样式*/
   	    .page_list ul li span {
   	        padding: 6px 12px;
   	        text-decoration: none;
   	    }
   	</style>
</head>
<body>
	@yield('content')
</body>
</html>