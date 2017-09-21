<?php
/**
 * 
 * user表模型
 * @author wj
 * @date 2014-10-14
 *
 */
class UserGroupModel extends MysqlModel
{
	 //自动完成
    protected $_auto = array(
    );
    //自动验证
    protected $_validate = array(
        array('name', 'require', '名称必须！'),
        array('min_points', 'number', '最小经验必须是数字！'),
        array('max_points', 'number', '最大经验必须是数字！'),
        array('discount', '/^\d{1,3}$/', '折扣为1-100的整数', 1),
    );
    
    /**
     * 查询用户等级，来修改用户等级
     * @param type $max_points
     * @return type
     */
    public function get_user_gourp_leven($max_points){
        $parma["min_points"]=array("elt",$max_points);
        $parma["max_points"]=array("egt",$max_points);
        if($max_points<0){
            $data = $this->where("0>=min_points")->find();
        }else{
             $data = $this->where($parma)->find();
             if(!$data){
                 $max = $this->max("max_points");
                 $parma["min_points"]=array("elt",$max);
                 $parma["max_points"]=array("egt",$max);
                 $data = $this->where($parma)->find();
             }
        }
        return $data;
    } 
}
?>