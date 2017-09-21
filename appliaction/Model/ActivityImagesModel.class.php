<?php 
class ActivityImagesModel extends SystemModel{


    protected $tableName = 'act_img'; 
    protected $_validate  = array(
        array('path', 'require', '图片不能为空', self::EXISTS_VALIDATE, '', self:: MODEL_BOTH),
    );

}