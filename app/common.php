<?php
// 状态 从config.php
function lothar_statusOptions($status='',$config='wdata_status')
{
    if (is_array($config)) {
        $ufoconfig = $config;
    } elseif (empty(config('?'.$config))) {
        return false;
    } else {
        $ufoconfig = config($config);
    }
    $status = is_numeric($status)?intval($status):$status;
    $options = '';
    foreach ($ufoconfig as $key => $vo) {
        $options .= '<option value="'.$key.'" '.(($status===$key)?'selected':'').'>'.$vo.'</option>';
    }

    return $options;
}

// 选择框 从数据库
function lothar_createOptions($selectId=0, $option='', $data=[])
{
    if ($option=='json') {
        return json_encode($data);
    } elseif ($option=='false' || $option===false) {
        return $data;
    }
    $options = (empty($option)) ? '':'<option value="">--'.$option.'--</option>';
    if (is_array($data)) {
        foreach ($data as $v) {
            $options .= '<option value="'.$v['id'].'" '.($selectId==$v['id']?'selected':'').'>'.$v['name'].'</option>';
        }
    }
    return $options;
}