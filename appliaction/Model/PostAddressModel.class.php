<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class PostAddressModel extends MysqlModel{
    
    public function getPostAddress($user_id){
        $where["user_id"] = $user_id;
        $data = $this->where($where)->select();
        return $data;
    }
    
}
?>
