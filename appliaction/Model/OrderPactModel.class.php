<?php


 class OrderPactModel extends SystemModel{
     
     
    /**
     * 通过订单ID来获取合同状态
     * @param type $orderid
     * @return type
     */
    public function getOrderPactById($orderid){
        $data["orderid"]=$orderid;
        $dataList = $this->where($data)->select();
        return $dataList; 
    }
    /**
     * 确认合同
     * @param type $orderid
     * @param type $admin
     * @return type
     */
    public function updateOrderPactByOrderid($orderid,$admin){
        $data["orderid"]=$orderid;
        $flag = $this->where($data)->save($admin);
        return $admin;
    }
    
    public function getOrderGroupByOrderid($orderid){
        $where["orderid"]=$orderid;
        $data = $this->where($where)->group("orderid")->select();
        return $data;
        
    }
}
?>
