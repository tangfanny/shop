<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GoodsLabelModel
 *
 * @author Administrator
 */
class GoodsLabelModel extends SystemModel{
    //put your code here
    	//自动验证
    protected $_validate = array(
		array('name','require','名称必须！'),
		array('location', 'require', '位置不能为空！'),
    );
    //自动填充
   protected $_auto = array(
        array('create_time', NOW_TIME , Model:: MODEL_INSERT, 'string'), 
    );
}

?>
