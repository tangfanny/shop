<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class UserMsgModel extends SystemModel{
    
    public function addUserMsg($usermsg){
        $data = $this->data($usermsg)->add();
        
        return $data;
        
    }
}
?>
