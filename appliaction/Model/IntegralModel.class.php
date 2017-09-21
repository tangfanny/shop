<?php
/**
 * 设置积分兑换比例Model类
 *
 * @author 吴枫
 */
class IntegralModel extends MysqlModel{
    //自动验证
    protected $_validate = array(
        array('sale_key_value', 'require', '数量必须填写！'),
        array('rank', 'require', '对应积分必须填写！'),
    );
    
    /**
     * 向表t_integral添加数据
     * @param type $param 对应数据字段
     * @return type 是否成功
     */
    public function add_integral($param){
        $data = $this->add($param);
        return $data;
    }
}

?>
