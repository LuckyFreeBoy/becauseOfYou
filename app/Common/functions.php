<?php

// 这里都是自定义函数，可能有误，谨慎使用。

/**
 * 普通分类数组 转为 无限分类 样式
 * cat_0
 *|--cat1
 *|--cat1
 *|--|--cat2
 *|--|--cat2
 * cat_0
 *|--cat1
 *|--|--cat2
 * @param array  	$data    		分类数组
 * @param string 	$field_name   	字段名 分类名称
 * @param string 	$field_id   	字段名 分类ID
 * @param string 	$field_pid   	字段名 分类PID
 * @param int 		$pid   			顶级pid
 * @param string 	$flat   	    分类样式符号 默认|——
 * @param int 		$c   			分类层级 顶层从0开始 一般不修改
 *
 * @return 转换后数组
 */
function getTree($data, $field_name='name', $field_id='id', $field_pid='pid', $pid=0, $flag='├──',$c = 0){
	$arr = array();
	foreach ($data as $k=>$v) {
		if ($v[$field_pid] == $pid) {
			$arr[] = $v;
			for ($i=0; $i<$c ; $i++) { 
				$v[$field_name] = $flag.$v[$field_name];
			}
			$a = $c+1;
			$arr = array_merge($arr,getTree($data, $field_name, $field_id, $field_pid, $v[$field_id], $flag, $a));
		}
	}
	return $arr;
}