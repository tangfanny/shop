<?php
/*
 *  调试模式开关
 */
        //define('APP_DEBUG', true); 
        $dir_name="../../core/Core_TP/switch";
	if(APP_DEBUG == true){
            if(!file_exists($dir_name)){
                if(mkdir($dir_name,0777)){
                    echo "指定目录".$dir_name."创建成功!";
                }else{
                    echo "指定目录".$dir_name."创建失败!";
                }
            }else{      
                echo "已成功开启";
            }
	}else{
		rmdir($dir_name); 
                echo "关闭成功";  
	}
