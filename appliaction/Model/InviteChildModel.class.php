<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RebateModel
 *
 * @author 吴枫
 */
class InviteChildModel extends MysqlModel {

    /**
     * 通过子用户ID查询父亲id
     * @param type $user_id 用户ID
     * @return type 父亲id
     */
    public function get_invite_parent($user_id) {
        $param["child_id"] = $user_id;
        $data = $this->where($param)->find();
        return $data;
    }

    /**
     * 删除父亲表相关节点
     * @param type $par_id
     * @param type $child_id
     * @return type
     */
    public function delete_child($par_id, $child_id) {
        $param["child_id"] = $par_id;
        $param["par_id"] = $child_id;
        return $this->where($param)->delete();
    }

    public function add_child($par_id, $child_id) {
        $param["par_id"] = $par_id;
        $param["child_id"] = $child_id;
        return $this->data($param)->add();
    }

}

?>
