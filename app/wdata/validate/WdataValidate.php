<?php
namespace app\wdata\validate;

use think\Validate;

class WdataValidate extends Validate
{
    protected $rule = [
        'id'    => 'require',
        'name' => 'require',
        'url'   => 'require|checkUrl',
    ];
    protected $message = [
        'id.require'    => 'ID不能为空!',
        'title.require' => '网站名称不能为空!',
        'url.require'   => '域名不能为空!',
        'url.checkUrl'  => '域名格式不正确!'
    ];

    protected $scene = [
        'add'   => ['name'=>'require'],
        'edit'  => ['id'=>'require']
    ];

    // 验证url 格式
    protected function checkUrl($value, $rule, $data)
    {
        return true;
    }

    // 验证url 格式
    protected function checkName($value, $rule, $data)
    {
        return true;
    }
}