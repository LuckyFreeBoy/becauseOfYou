<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'cate_id';
    public $timestamps = false;

    protected $guarded = [];

    // 获取转换后的分类
    public function tree(){
    	$categorys = $this->orderBy('cate_order', 'asc')->get();

    	return getTree($categorys, 'cate_name', 'cate_id', 'cate_pid', 0);
    }
}
