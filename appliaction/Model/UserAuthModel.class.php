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
class UserAuthModel extends MysqlModel{
    
    /**
     * 修改用户认证基本信息表
     * @param type $id 用户ID
     * @param type $status 认证状态
     */ 
    public function update_user_auth_by_uid($id,$status){
        $param["uid"]=$id;
        $data["status"]=$status;
        return $this->where($param)->data($data)->save();
    }

    /*
    * 众测会员白帽子信息
    * */
    public function  getWhiteInfo($uid){
        return $this->where('uid='.$uid)->find();
    }
    
}

?>
