<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VersionController
 *
 * @author Administrator
 */
class VersionController extends AdminBaseController {

    public function _initialize() {
        parent::_initialize();
        $this->db = model("VersionConfig");
    }

    public function edit() {
        $list = $this->db->get_version_config();
        include $this->admin_tpl('versin');
    }
    
    public function save(){
        $this->db->update_version_config($_POST);
        showmessage('操作成功', '', 1);
    }

}

?>
