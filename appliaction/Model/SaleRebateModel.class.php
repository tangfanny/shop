<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SaleRebateModel
 *
 * @author 吴枫
 */
class SaleRebateModel extends MysqlModel{
    
     /**
      * 初始化数据分成计划数据
      * @param type $rebate_hierarchy 要初始化的数据行数
      */
     public function insertSaleRebats($rebate_hierarchy){
        for($num=0;$num<$rebate_hierarchy;$num++){
            for($num_1=0;$num_1<($num+1);$num_1++){
                 $param["rebate_".($num_1+1)]=0;
            }
            $this->data($param)->add();

        }
    }
    /**
     * 查询salerebate表中数据
     * @return type
     */
    public function getsaleAll(){
        return $this->select();
    }
    
    /**
     * 根据ID查询对应返利数据
     * @param type $id 层级关系结果集合
     * @return type 具体返利数据
     */
    public function get_sale_rebats_id($id){
        $param["id"]=$id;
        return $this->where($param)->find();
    }

    public function update_rebate_val($id,$column){
        $param["id"]=$id;
        $data=  $this->where($param)->save($column);
        return $data;
    }
    
}

?>
