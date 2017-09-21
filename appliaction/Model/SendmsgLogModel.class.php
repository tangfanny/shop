<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SendmsgLog
 *
 * @author Administrator
 */
class SendmsgLogModel extends MysqlModel {

    //put your code here

    public function add_sendsmglog($phone) {
        $param["mobile"] = $phone;
        $param["send_time"] = time();
        return $this->data($param)->add();
    }

}

?>
