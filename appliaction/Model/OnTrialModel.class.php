<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class OnTrialModel extends SystemModel{
    
    
    /**
     * 查询全部申请数据信息
     * @return type
     */
    public function getOnTrialAll(){
        $data = $this->order("createtime desc")->select();
        return $data;
    }
}
?>
