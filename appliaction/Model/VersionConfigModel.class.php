<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VersionConfigModel
 *
 * @author Administrator
 */
class VersionConfigModel extends SystemModel{
    //put your code here
    
    /**
     * 
     * @return type
     */
    public function get_version_config(){
        return $this->where("id=1")->find(); 
    }
    /**
     * 
     * @param type $data
     * @return type
     */
    public function update_version_config($data){
        return $this->where("id=1")->data($data)->save();
    }
}

?>
