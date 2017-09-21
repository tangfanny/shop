<?php

class ServiceGoodsOrderController extends AdminBaseController
{
    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('ServiceGoodsOrder');
    }

    public function index()
    {
        include $this->admin_tpl('sgo_index');
    }

    /**
     * 服务商品订单表
     */
    public function lists()
    {
        if(IS_POST) {
            $page = I('post.page', 1);
            $rows = I("post.rows", 30);
            $goods_id = I("post.goods_id", 0);
            $data = $this->model->getList($page, $rows, $goods_id);
            $userModel = model("User");
            foreach($data['rows'] as $k => $d) {
                $uinfo = $userModel->get_user_info($d['user_id']);
                $data['rows'][$k]['user_name'] = $uinfo['nikename'];
            }
            echo json_encode($data);
        }
    }

    /**
     * 商品订单详情
     */
    public function info()
    {
        $this->_config = $this->load_config('status');
        $id = I("get.id", 0);
        $info = $this->model->getInfo($id);
        $info['customer'] = model('User')->get_user_info($info['user_id']);
        $this->assign('info', $info);
        $dialog = true;
        include $this->admin_tpl('sgo_info');
    }

    public function update()
    {
        if(IS_POST) {
            $order_sn = I("post.order_sn");
            $status = I("post.order_status");
            $data = $this->model->updateOrderStatus($order_sn, $status);
            $this->ajaxReturn($data);
        }
    }
}
