<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SaleRebateModel
 *
 * @author 吴枫
 */
class UserSalesModel extends MysqlModel{
    
     
     public function getList($keyword,$user_id,$_order,$_sort,$pagenum,$rowsnum){

        $page_size = 20;
        $sqlmap = array();
        if($_order && $_sort){
            $order[$_sort] = $_order;
        }else{
            $order['tus.create_time'] = 'DESC';
        }
        if (isset($user_id) && $user_id > 0) {
            $sqlmap['a.id'] = $user_id;
        }
        if (isset($keyword) && $keyword) {
            $sqlmap['tua.name|a.email|a.mobile'] = array("LIKE", "%".$keyword."%");
        }
        /* 查询销售 */
       $field="a.id,
                a.email,
                a.mobile,
                a.nikename,
                a.integral,
                a.rank,
                a.login_time,
                tus.`create_time` as tuscreatetime,
                tus.`check_time` AS tuschecktime,
                tua.`identity`,
                a.is_whitehat_auth,
                a.is_company_auth,
                a.is_saler_auth,
                tua.name as tuaname,
                g.name as gname,
                tus.status AS tusstatus"; 
       $sqlmap["a.is_saler_auth"]=array("neq","0");   
       $join = "LEFT JOIN __USER__  AS a ON a.id=tus.uid
                LEFT JOIN __USER_GROUP__  AS g ON a.rank=g.id
                LEFT JOIN __USER_AUTH__ AS tua on a.id= tua.uid";

                //分页
        $pagenum=isset($pagenum) ? intval($pagenum) : 1;
        $rowsnum=isset($rowsnum) && (int)($rowsnum) != 0 ? intval($rowsnum) : $page_size;
        //获取记录数
        $data['total'] = $this->getVerifyCount($sqlmap,$join);
        $data['rows']=$this->getVerifyAll($sqlmap,$order,$pagenum,$rowsnum,$join,$field);
//                echo $this->db->_sql();
        if(!$data['rows']){
            $data['rows']=array();
        }
        foreach ($data['rows'] as $k=>$v){
            if($v["company"]){
                $data["rows"][$k]["name"]=$v["company"];
            }
            if(empty($v["mobile"])){
                $data["rows"][$k]["mobile"]=$v["email"];
            }else{
                $data["rows"][$k]["mobile"]=$v["mobile"];
            }
            if($v["is_saler_auth"]==2||$v["is_whitehat_auth"]==9){
                $data["rows"][$k]["roles"]="销售未认证";
            }
            if($v["is_saler_auth"]==1){
                $data["rows"][$k]["roles"]="已认证销售";
            }
            //创建时间
            if($v["tuscreatetime"]){
                $data["rows"][$k]["cretatime"]=$v["tuscreatetime"];
            }
            if($v["tuwcreatetime"]){
                $data["rows"][$k]["cretatime"]=$v["tuwcreatetime"];
            }
            if($v["tuccreatetime"]){
                $data["rows"][$k]["cretatime"]=$v["tuccreatetime"];
            }
            //审核时间
            if($v["tuschecktime"]){
                 $data["rows"][$k]["check_time"]=$v["tuschecktime"];
            }
            if($v["tucchecktime"]){
                 $data["rows"][$k]["check_time"]=$v["tucchecktime"];
            }
             if($v["tuwchecktime"]){
                 $data["rows"][$k]["check_time"]=$v["tuwchecktime"];
            }
            //认证信息
            if($v["tusstatus"]){
                if($v["tusstatus"]==1){
                    $data["rows"][$k]["roles_flag"]="销售未认证";
                }
                if($v["tusstatus"]==2){
                    $data["rows"][$k]["roles_flag"]="销售已认证";
                }
                if($v["tusstatus"]==3){
                    $data["rows"][$k]["roles_flag"]="销售已驳回";
                }
            }
            $incomemodel = new IncomeModel();
            $incomedata =  $incomemodel->getLastIncome($v["id"]);

            $walletmodel = new UserWalletModel();
            $walletdata =  $walletmodel->get_user_wallet_by_userid($v["id"]);
            if ($incomedata) {
                $data["rows"][$k]["income_msg"] = $incomedata["income_money"]." ( ".$incomedata["rebate_money"]." * ".$incomedata["percentage"]."% )";
            }else{
                $data["rows"][$k]["income_msg"] = "暂无收益";
            }
            if ($walletdata) {
                $data["rows"][$k]["balance"] = $walletdata["balance"];
            }else{
                $data["rows"][$k]["balance"] = "未开通钱包";
            }

        }
        return $data;
        
    }
    /**
     * 查询salerebate表中数据
     * @return type
     */
    public function getsaleAll(){
        return $this->select();
    }
    public function getVerifyCount($sqlmap,$join){
            $data = $this->alias("tus")->join($join)->where($sqlmap)->count();
            return $data;
    }
    public function getVerifyAll($sqlmap,$_order,$pagenum,$rowsnum,$join,$field){
            $data = $this->alias("tus")->field($field)->join($join)->where($sqlmap)->limit(($pagenum-1)*$rowsnum.','.$rowsnum)->order($_order)->select();
            return $data;
    }
    
    
    public function update_user_sales_by_id($id,$status,$refusal){
       $param["uid"]=$id;
       $data["check_time"]=time();
       $data["status"]=$status;
       $data["refusal"]=$refusal;
       $data_id = $this->where($param)->data($data)->save();
       return $data_id;
    }
    
    /**
     * 根据ID查询相关认证人员信息
     * @param type $id
     * @return type
     */
    public function get_user_sales_by_uid($id){
        $params["uid"]=$id;
        $array = $this->where($params)->find();
        return $array;
    }
}
?>
