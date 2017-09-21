<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class CheapCountModel extends SystemModel{
    
     public function getOnTrialAll(){
        $data = $this->order("createtime desc")->select();
        return $data;
    }
}
?>
