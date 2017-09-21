<?php 
class ActivityBannerModel extends SystemModel{


    protected $tableName = 'act_banner'; 
    protected $_validate  = array(
        array('pic', 'require', '图片不能为空', self::EXISTS_VALIDATE, '', self:: MODEL_BOTH),
    );

}