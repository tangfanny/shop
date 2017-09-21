<?php


 class OrderGoodsStagingModel extends SystemModel{
     
     
   
    
    /**
     * 修改商品支付状态
     * @param type $id
     * @param type $admin
     * @return type
     */
    public function updateOrderGoodsSatging($orderid,$staging_num,$datainfo){
       $data["order_id"]=$orderid;
       $data["staging_num"]=$staging_num;
       $flag = $this->where($data)->data($datainfo)->save();
       return $flag;
    }
    
    public function insert_order_goods_staging($data){
        $this->data($data)->add();
    }
}
?>
