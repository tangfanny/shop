<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * 余额表
 *
 * @author 吴枫
 */
class UserWalletModel extends MysqlModel {

    /**
     * 通过用户ID来获取余额表中数据
     * @param type $user_id
     * @return type
     */
    public function get_user_wallet_by_userid($user_id) {
        $params["uid"] = $user_id;
        $data = $this->where($params)->find();
        return $data;
    }

    /**
     * 通过用户id来修改余额数据
     * @param type $user_id
     * @param type $data
     * @return type
     */
    public function update_user_wallet($user_id, $data) {
        $params["uid"] = $user_id;
        $data = $this->where($params)->data($data)->save();
        return $data;
    }

    public function updateWallet($con) {
        $where = array();
        if (empty($con['uid'])) {
            $where['id'] = $con['id'];
            unset($con['id']);
        } else {
            $where['uid'] = $con['uid'];
            unset($con['uid']);
        }
        return $this->where($where)->save($con);
    }

    /**
     * 添加余额表数据
     * @param type $user_id
     */
    public function inser_user_wallet($user_id) {
        $data["uid"] = $user_id;
        $data["create_time"] = time();
        return $this->data($data)->add();
    }

}

?>
