<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RebateModel
 *
 * @author 吴枫
 */
class RebateModel extends MysqlModel{

    
    /**
     * 修改总价返利比金额
     * @param type $param 修改的字段总价返利比金额
     * @return type 是否成功
     */
    public function updateRebate($param){
      return  $this->where("id=1")->save($param);
    }

    public function updateInteralRebate($param){
      return  $this->where("id=1")->save($param);
    }

    /**
     * 查询总价返利比数据
     * 层级关系数据
     * @return type 总价返利比数据
     */
    public function getBysalerebate(){
        return $this->where("id=1")->find();
    }
    public function getBysaleintegral(){
        return $this->where("id=1")->find();
    }
    
    /**
     * 删除数据库表，返回删除结果
     * @return type 成功或者失败
     */
    public function dropRebate(){
        $sql = "drop table t_sale_rebate";
        $dropflag = $this->query($sql);
        return $dropflag;
    }

    public function dropSaleIntegral(){
        $sql = "drop table t_sale_integral";
        $dropflag = $this->query($sql);
        return $dropflag;
    }
    
    /**
     * 执行创建sql语句进行封装
     * @return type
     */
    public function createSaleRebateSql(){
        $rebate = $this->getBysalerebate();
        $sql = "create  table t_sale_rebate ( id INT(11) not null AUTO_INCREMENT,primary key (id),";
        for($rebate_hierarchy=0;$rebate_hierarchy<$rebate["rebate_hierarchy"];$rebate_hierarchy++){
            $param.="rebate_".($rebate_hierarchy+1)." int(11) ,";
        }
        $sql.=substr($param, 0,-1);
        $sql.=")";
        $createSaleRebate=  $this->query($sql);
        return $createSaleRebate;
    }

    
    /**
     * 删除数据库表，返回删除结果
     * @return type 成功或者失败
     */
    public function dropIntegralRebate(){
        $sql = "drop table t_sale_integral";
        $dropflag = $this->query($sql);
        return $dropflag;
    }
    /**
     * 执行创建sql语句进行封装积分逻辑分成
     * @return type
     */
    public function createSaleIntegralSql(){
        $integral = $this->getBysaleintegral();
        $sql = "create  table t_sale_integral ( id INT(11) not null AUTO_INCREMENT,primary key (id),";
        for($integral_hierarchy=0;$integral_hierarchy<$integral["integral_hierarchy"];$integral_hierarchy++){
            $param.="integral_".($integral_hierarchy+1)." int(11) ,";
        }
        $sql.=substr($param, 0,-1);
        $sql.=")";
        $createSaleIntegral=  $this->query($sql);
        return $createSaleIntegral;
    }
}

?>
