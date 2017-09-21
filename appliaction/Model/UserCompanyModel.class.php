<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class UserCompanyModel extends MysqlModel{
    
   /**
    * 修改白帽子状态
    * @param type $id 用户ID
    * @param type $status 状态
    */
   public function update_user_company_by_id($id,$status,$refusal){
       $param["uid"]=$id;
       $data["check_time"]=time();
       $data["status"]=$status;
       $data["auth_refuse"]=$refusal;
       $data_id = $this->where($param)->data($data)->save();
       return $data_id;
   }
}
?>
