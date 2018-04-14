<?php
namespace app\wdata\model;

use think\Model;

/**
* 
*/
class WdataModel extends Model
{
    protected $type = [
        'more' => 'array',
        // 'url' => 'array',
    ];

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    public function setCreateTimeAttr($value)
    {
        return strtotime($value);
    }
    public function setUpdateTimeAttr($value)
    {
        return strtotime($value);
    }
    // published_time 自动完成
    public function setPublishedTimeAttr($value)
    {
        return strtotime($value);
    }

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
    public function setUrlAttr($value)
    {
        return preg_replace('/[\\r\\n]/is', '', $value);
        // return implode('|',$value);
    }
    public function getUrlAttr($value)
    {
        return explode('|',$value);
    }


}