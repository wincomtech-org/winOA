<?php
namespace app\wdata\model;

use think\Model;

/**
* 
*/
class WdataModel extends Model
{
    /**
     * history 自动转化
     * @param $value
     * @return string
     */
    public function setHistoryAttr($value)
    {
        return htmlspecialchars(cmf_replace_content_file_url(htmlspecialchars_decode($value), true));
    }
    public function getHistoryAttr($value)
    {
        return cmf_replace_content_file_url(htmlspecialchars_decode($value));
    }
    /**
     * url 域名转化
     * @param [type] $value [description]
     */
    // public function setUrlAttr($value)
    // {
    //     return implode('||',$value);
    // }
    // public function getUrlAttr($value)
    // {
    //     return explode('||',$value);
    // }
}