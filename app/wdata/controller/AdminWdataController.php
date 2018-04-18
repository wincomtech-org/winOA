<?php
namespace app\wdata\controller;

use cmf\controller\AdminBaseController;
use app\wdata\model\WdataModel;
use think\Db;

/**
 * Class AdminWdataController
 * @package app\wdata\controller
 * @adminMenuRoot(
 *     'name'   => '网站资源',
 *     'action' => 'default',
 *     'parent' => '',
 *     'display'=> true,
 *     'order'  => 10000,
 *     'icon'   => '',
 *     'remark' => '网站资源管理'
 * )
 */
class AdminWdataController extends AdminBaseController
{
    /**
     * 网站列表
     * @adminMenu(
     *     'name'   => '网站管理',
     *     'parent' => 'wdata/AdminWdata/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '网站列表',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        // Db::execute("truncate cmf_wdata;");
        $param = $this->request->param();

        $where = [];
        $keyword = isset($param['keyword']) ? $param['keyword'] : '';
        if (!empty($keyword)) {
            $where['name|url'] = ['like','%'.$keyword.'%'];
        }
        // ->whereOr()
        $scModel = new WdataModel();
        $list = $scModel->where($where)->order('list_order,id DESC')->paginate(16);

        $this->assign('keyword',$keyword);
        $this->assign('list', $list->items());
        // $list->appends();
        $this->assign('pager', $list->render());
        $this->assign('statusV',config('wdata_status'));
        return $this->fetch();
    }

    /**
     * 添加网站
     * @adminMenu(
     *     'name'   => '添加网站',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加网站',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        $this->assign('type', '');
        $this->assign('typeV', config('wdata_type'));
        $this->assign('statusV', lothar_statusOptions(1));
        return $this->fetch();
    }

    /**
     * 添加网站提交
     * @adminMenu(
     *     'name'   => '添加网站提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加网站提交',
     *     'param'  => ''
     * )
     */
    public function addPost()
    {
        $data = $this->request->param();

        $result = $this->validate($data, 'wdata/Wdata.add');
        if ($result !== true) {
            $this->error($result);
        }

        $scModel = new WdataModel();
        $scModel->allowField(true)->data($data, true)->isUpdate(false)->save();
        $this->success('添加成功!', url('index'));
    }

    /**
     * 编辑网站
     * @adminMenu(
     *     'name'   => '编辑网站',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '编辑网站',
     *     'param'  => ''
     * )
     */
    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');
        if ($id > 0) {
            $scModel = new WdataModel();
            $post = $scModel->get($id);
            if (empty($post)) {
                $this->error('数据不存在！');
            } else {
                $post = $post->toArray();
            }
            $url = '';
            $buff = '|'.PHP_EOL;
            foreach ($post['url'] as $u) {
                $url .= $u.$buff;
            }
            $post['url'] = trim($url,$buff);
            $statusV = lothar_statusOptions($post['status']);
            $this->assign($post);
            $this->assign('statusV', $statusV);
            $this->assign('typeV', config('wdata_type'));
            return $this->fetch();
        } else {
            $this->error('操作错误!');
        }

    }

    /**
     * 编辑网站提交
     * @adminMenu(
     *     'name'   => '编辑网站提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '编辑网站提交',
     *     'param'  => ''
     * )
     */
    public function editPost()
    {
        $data = $this->request->param();

        $result = $this->validate($data, 'wdata/Wdata.edit');
        if ($result !== true) {
            $this->error($result);
        }

        $scModel = new WdataModel();
        $scModel->allowField(true)->isUpdate(true)->data($data, true)->save();
        $this->success('保存成功!',url('edit',['id'=>$data['id']]));
    }

    /**
     * 网站排序
     * @adminMenu(
     *     'name'   => '网站排序',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '网站排序',
     *     'param'  => ''
     * )
     */
    public function listOrder()
    {
        parent::listOrders(Db::name('wdata'));
        $this->success("排序更新成功！", '');
    }

    /**
     * 删除网站
     * @adminMenu(
     *     'name'   => '删除网站',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '删除网站',
     *     'param'  => ''
     * )
     */
    public function delete()
    {
        $mq = Db::name('wdata');
        $id = $this->request->param('id',0,'intval');
        $result = $mq->where('id',$id)->delete();
        if ($result==1) {
            $this->success('删除成功!');
        } else {
            $this->error('删除失败');
        }
    }
}