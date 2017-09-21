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
class UserWhitehatModel extends MysqlModel{
    
   /**
    * 修改白帽子状态
    * @param type $id 用户ID
    * @param type $status 状态
    */
   public function update_user_whitehat_by_id($id,$status,$refusal){
       $param["uid"]=$id;
       $data["check_time"]=time();
       $data["status"]=$status;
       $data["refusal"]=$refusal;
       $data_id = $this->where($param)->data($data)->save();
       return $data_id;
   }
}

?>
