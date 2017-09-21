<?php
return array(
    'DEFAULT_C_LAYER'      => 'Controller',
    'VAR_GROUP'            => 'm',
    'VAR_MODULE'           => 'c',
    'VAR_ACTION'           => 'a',
    'OUTPUT_ENCODE'        => TRUE,
	'APP_GROUP_LIST'       => '*',
    'DEFAULT_GROUP'        => 'Goods',
    'DEFAULT_MODULE'       => 'Index',
    'DEFAULT_ACTION'       => 'index',
   // 'ERROR_PAGE'		   => '?m=admin&c=public&a=404',

    'URL_MODEL'            => 0,
    'VAR_SESSION_ID'       => 'PHPSESSID',
    'uploadpath'           => './uploads/uploadfile/',
    'USER_AUTH_KEY'        => 'uid',
    'VAR_PAGE'             => 'page',
    'LOG_EXCEPTION_RECORD' => TRUE,
    'TMPL_CACHE_ON'        => FALSE, //开启模板缓存
    'URL_CASE_INSENSITIVE' => TRUE,
    'DATABASE_BACKUP_PATH' => 'backup',
    'SYSTEM_HOOK_LIST'     => 'system',//系统内置hook文件列表
    'LOAD_EXT_CONFIG'      => 'site,db_config,db,reg,info,mail,safe,upfile,mobile,cloud,theme,version,moneylog,weixin',
    'SHOW_PAGE_TRACE'	   =>TRUE,
    
    //redis配置
    'redis_config'=>array(
          'host'=>'cache.secwk.com',
          'port'=>'6379',
          'password'=>'1q2O5htCzdP.hCd1',
    ),
    //登录是否需要短信验证码  0.不需要 1.需要
    'SentVerifyCode'=>array(  
          'sent'=>'0', 
    ),
    //短信开关1开启 0关闭
    'Messageflag'=>array(
        'order_sent'=>'0', //订单
    ),

);