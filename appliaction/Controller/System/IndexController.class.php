<?php
/*
 *      系统设置 
 */
class IndexController extends AdminBaseController {
   public function _initialize() {
        parent::_initialize();    
    }
    
    /*
     * 数据库配置列表
     */
    public function db_lists(){
        $content  = file_get_contents(APP_PATH."/../../../core/Conf/apisend/config/DbConfig.php");
        echo "<pre>";print_r(htmlspecialchars($content));die;
    }
     
    /*
     * 数据库配置列表
     */
    public function host_lists(){
        $host_lists  = file_get_contents(APP_PATH."/../../../core/Conf/frontend/config/baisc_conf.php");
        echo "<pre>";print_r(htmlspecialchars($host_lists));die;
    }  
    
    /*
     * 调试开关
     */
    public function debug(){
        require("switch.php");
    }      
    
}