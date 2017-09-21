<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class OrderGoodsModel extends SystemModel{
    
    
    public function getOrder_sn($order_sn){
        $data["order_id"] = $order_sn;
        $datalist = $this->where($data)->select();
        return $datalist;
    }
   /**
     * 添加数据
     * @param type $data
     */
    public function insert_order_goods($data){
       return  $this->data($data)->add();
    }
    
}
?>
