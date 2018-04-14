<?php
namespace app\wdata\controller;

use cmf\controller\UserBaseController;
use app\wdata\model\WdataModel;

/**
* 数据中心
*/
class IndexController extends UserBaseController
{
    public function index()
    {
        $param = $this->request->param();
        $scModel = new WdataModel;

        $where = [];
        $list = $scModel->field('*')->where($where)->paginate(30);
// dump($list->items());die;
        $this->assign('list',$list->items());
        $this->assign('pager',$list->appends($param)->render());
        return $this->fetch(':index');
    }

    public function detail()
    {
        $id = $this->request->param();

        $scModel = new WdataModel;
        $post = $scModel->get($id);

        $this->assign('post',$post);
        return $this->fetch(':detail');
    }
}