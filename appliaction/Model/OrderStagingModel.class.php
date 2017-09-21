<?php


 class OrderStagingModel extends SystemModel{
     
     
    /**
     * 通过订单ID来获取分期金额信息
     * @param type $orderid
     * @return type
     */
    public function getOrderStagingAll($orderid){
        $data["orderid"]=$orderid;
        $dataList = $this->where($data)->order("staging_num asc")->select();
        return $dataList; 
    }
    
    /**
     * 修改数据库订单分期表
     * @param type $id
     * @param type $admin
     * @return type
     */
    public function updateOrderStagingUser($id,$admin){
        $data["id"]=$id;
        $flag = $this->where($data)->save($admin);
        return $flag;
    }
    
    /**
     * 根据id进行查询，获取相关数据
     * @param type $id
     * @return type
     */
    public function getOrderSangtingById($id){
        $data["id"]=$id;
        $datalist=  $this->where($data)->find();
        return $datalist;
    }
    /**
     * 修改订单分期数据
     * @param type $id
     * @param type $orderstaginginfo
     * @return type
     */
    public function updateOrderSangingById($id,$orderstaginginfo){
        $data["id"]=$id;
        $flag = $this->where($data)->data($orderstaginginfo)->save();
        return $flag;
    }
    
    public function insert_order_staging($data){
        $this->data($data)->add();
    }
}
?>
