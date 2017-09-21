<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 *
 * @author TXl
 */
class UserWalletAccountModel extends MysqlModel{

    /*
    * 众测会员白帽子信息
    * */
    public function  getMyWalletInfo($uid){
        return $this->where('uid='.$uid)->find();
    }

}

?>
