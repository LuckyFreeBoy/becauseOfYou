<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Model\Config;
use Validator;

class ConfigController extends CommonController
{
    // get  admin/config/ 网站配置列表
    public function index(Request $request)
    {
        // 搜索条件
        $search['keywords'] = $request->get('keywords');

        $data = Config::where('conf_name','like','%'.$search['keywords'].'%')
                    ->orderBy('conf_order', 'desc')
                    ->paginate(10)
                    ->appends([
                        'keywords' => $search['keywords'],
                        ]);
        foreach ($data as $k => $v) {
            switch ($v->field_type) {
                case 'input':
                    $v->_html = '<input type="text" class="lg" name="conf_content" value="'.$v->conf_content.'" onchange="confContentChange(this, '.$v->conf_id.')" />';
                    break;
                case 'textarea':
                    $v->_html = '<textarea name="conf_content" onchange="confContentChange(this, '.$v->conf_id.')">'.$v->conf_content.'</textarea>';
                    break;
                case 'radio':
                    $v->_html = '';
                    $field_value_arr = explode(',',$v->field_value);
                    foreach ($field_value_arr as $vv) {
                        $arr = explode('|',$vv);
                        $checked = $arr[0] == $v->conf_content ? 'checked':'';
                        $v->_html .= '<label><input type="radio" name="conf_content" value='.$arr[0].' '.$checked.' onchange="confContentChange(this, '.$v->conf_id.')"/>'.$arr[1].'</label>';
                    }
                    break;

                default:
                    # code...
                    break;
            }
        }
        return view('admin.config.list')
                    ->with('data', $data)
                    ->with('search', $search);
    }

    // post ajax更新网站配置排序
    public function orderChange(Request $request)
    {

        $input = $request->all();
        $config = Config::find($input['conf_id']);
        $config->conf_order = $input['conf_order'];
        $res = $config->update();

        $data = array();
        if ($res) {
            $data = [
                'status' => 0,
                'msg' => '网站配置排序更新成功！'
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '网站配置排序更新失败！请稍后重试。'
            ];
        }

        return $data;
    }

    // post ajax更新网站配置内容
    public function confContentChange(Request $request)
    {

        $input = $request->all();
        $config = Config::find($input['conf_id']);
        $config->conf_content = $input['conf_content'];
        $res = $config->update();

        $data = array();
        if ($res) {
            $this->putFile();
            $data = [
                'status' => 0,
                'msg' => '网站配置排序更新成功！'
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '网站配置排序更新失败！请稍后重试。'
            ];
        }

        return $data;
    }

    // 将网站配置写入配置文件 /config/web.php
    protected function putFile()
    {
        // public function putFile(){
        $conf = Config::pluck('conf_content', 'conf_name')->all();
        $path = base_path().'\config\web.php';
        $str = "<?php \r\n// 这是我的自定义网站配置文件\r\nreturn ".var_export($conf,true).';';
        file_put_contents($path, $str);
        return ;
    }
    // get  admin/config/create 添加网站配置
    public function create()
    {
        return view('admin.config.add');
    }

    // post  admin/config/store 添加网站配置提交
    public function store(Request $request)
    {
        $input = $request->except('_token');
        // 规则验证
       	$rules = [
            'conf_title' => 'required',
	        'conf_name' => 'required',
	    ];
	    $message = [
            'conf_title.required' => '网站配置标题必须填写！',
	        'conf_name.required' => '网站配置名称必须填写！',
	    ];
        $validator = Validator::make($input, $rules, $message);

        if ($validator->fails()) {

            return back()->withInput()->withErrors($validator);
        }else {
            $res = Config::create($input);

            if ($res) {

                $this->putFile();
                return redirect('admin/config')->with('success', '添加网站配置成功！');
            } else {
                return back()->withErrors('添加网站配置失败！请稍后重试。');
            }
        }
    }

    // get  admin/config/{config}
    public function show($id)
    {
        //
    }

    // get  admin/config/{config}/edit
    public function edit($conf_id)
    {
        $config = Config::find($conf_id);
        return view('admin.config.edit')->with('conf',$config);
    }

    // put  admin/config/{config}
    public function update(Request $request, $conf_id)
    {
        $input = $request->except('_token', '_method');
        // 规则验证
        $rules = [
                'conf_title' => 'required',
                'conf_name' => 'required',
            ];
        $message = [
                'conf_title.required' => '网站配置标题必须填写！',
                'conf_name.required' => '网站配置名称必须填写！',
        ];
        $validator = Validator::make($input, $rules, $message);

        if ($validator->fails()) {

            return back()->withInput()->withErrors($validator);
        }else {
            $res = Config::where('conf_id', $conf_id)->update($input);
            if ($res) {
                $this->putFile();

                return redirect('admin/config')->with('success', $input['conf_title'].' 网站配置修改成功！');
            } else {
                return back()->withErrors('网站配置修改失败！请稍后重试。');
            }
        }
    }

    // delete  admin/config/{config}
    public function destroy($conf_id)
    {
        $res = Config::where('conf_id', $conf_id)->delete();
        $data = array();
        if ($res) {
            $this->putFile();

            $data = [
                'status' => 0,
                'msg' => '网站配置删除成功！',
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '网站配置删除失败，请稍后重试！',
            ];
        }
        return $data;
    }
}
