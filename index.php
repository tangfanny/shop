<?php
define('IN_APP', TRUE);
/* 编码定义 */
define('CHARSET', 'utf-8');
//程序目录
defined('DOC_ROOT') or define('DOC_ROOT', str_replace("\\", '/', dirname(__FILE__) ).'/');
/* 应用名称*/
define('APP_NAME', 'appliaction');
/* 应用目录*/
define('APP_PATH', DOC_ROOT.'appliaction/');
define('LIB_PATH', APP_PATH);
/* 扩展目录*/
define('EXTEND_PATH', APP_PATH.'Library/');
define('TAGLIB_PATH', APP_PATH.'Taglib/');
/* 配置文件目录*/
define('CONF_PATH', DOC_ROOT.'config/');
/* 模板目录 */
define('TMPL_PATH', DOC_ROOT.'template/');
/* 数据目录*/
define('RUNTIME_PATH', DOC_ROOT.'data/');
define('LOG_PATH', RUNTIME_PATH.'logs/');
define('TEMP_PATH', RUNTIME_PATH.'temp/');
define('CACHE_PATH', RUNTIME_PATH.'caches/');
define('DATA_PATH', RUNTIME_PATH.'data/');
define('TEMP_PRE_PATH','/home/secwk/www/admins/shop');
/**活动生成静态的模板前置目录在shop/appliaction/Framework/Lib/Core/View.class.php 下*/
/* 插件目录 */
define('PLUGIN_PATH', DOC_ROOT.'plugin/');
/* DEBUG & 开发者模式 */
define('APP_DEBUG', true);
define("__API__NEW__", "http://mall.secwk.com");
define("_SHOP_SECW",'http://higuanliyuan.shop.secwk.com');
define("IMG_URL", 'http://offline.img.secwk.com/');
define('Img_ADDRESS', '/img/imglook/file_id/');
define("DB_URL", "mysql://user133:secwk.com@172.18.199.133/secwk_db");
define("DB_PREFIX", "t_");
define('SEC_IMG','http://img.secwk.com/');
define('RESOURCE',IMG_URL); //资源文件
define('QINIU_UPLOAD_BUCKET','qunp');
define('__QINIU__','http://static.secwk.com/qiniu_upload/');
define('PUBLIC_URL', 'http://offline.static.secwk.com/');//资源服务器地址(css,js,本地img)
define('__UEDITOR__','http://upload.img.secwk.com/');
define('IMG_AD','Order/GetPactNew/order_sn/');
define('IMG_INTREFACE','1'); //1:7牛;0:本地
include APP_PATH.'Framework/framework.php';
