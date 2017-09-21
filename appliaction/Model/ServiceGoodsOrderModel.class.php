<?php

class ServiceGoodsOrderModel extends Model
{
    public function getList($page, $page_size=PAGE_SIZE, $goods_id=0)
    {
        $start = ($page-1)*$page_size;
        $where = '';
        if($goods_id > 0) {
            $where = 'goods_id='.$goods_id;
        }

        $data = array('total' => 0, 'rows' => array());
        $data['total'] = $this->where($where)->count();
        $data['rows'] = array();
        $result = $this->where($where)
            ->limit($start, $page_size)
            ->select();
        if($result) {
            $data['rows'] = $result;
        }
        return $data;
    }

    /**
     * 获取订单详情
     * 
     * @param  $id
     * @return array
     */
    public function getInfo($id)
    {
        $data = $this->Table('t_service_goods_order sgo, t_service_goods sg')
            ->where("sgo.id=%d and sgo.goods_id=sg.id", $id)
            ->select();
        return $data[0];
    }

    /**
     * 更新订单状态
     * 
     * @param $order_sn
     * @param $status
     */
    public function updateOrderStatus($order_sn, $status)
    {
        $data = array('order_status'=>$status);
        if($status == 1) {
            $data['confirm_time'] = time();
        }
        return $this->where("order_sn='%s'", $order_sn)->save($data);
    }
}
