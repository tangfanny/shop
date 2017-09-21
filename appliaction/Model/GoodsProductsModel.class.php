<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class GoodsProductsModel extends SystemModel{
    
    
    public function getGoodsProductsByGoodsidAndproid($goodsid,$proid){
        $data["goods_id"]=$goodsid;
        $data["id"]=$proid;
        $datalist= $this->where($data)->select();
        return $datalist;
    }
    
    public function updateGoodsbyNum($goodsid,$proid,$num){
        $data["goods_id"]=$goodsid;
        $data["id"]=$proid;  
        $datanum["goods_number"]=$num;
        $dataflag = $this->where($data)->data($datanum)->save();
        return $dataflag;
    }
    
 
    
    /**
     * 通过goods_id来获取规格
     * @param type $goods_id
     * @return type
     */
    public function get_goods_id($goods_id){
        $param["goods_id"] = $goods_id;
        $data = $this->where($param)->select();
        return $data;
    }
    
    /**
     * 
     * @param type $products_sn
     * @return type
     */
    public function get_goods_products_sn($products_sn){
        $param["products_sn"]=$products_sn;
        return $this->where($param)->find();
    }
    

    
}
?>
