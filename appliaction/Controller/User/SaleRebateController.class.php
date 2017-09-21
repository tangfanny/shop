<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SaleRebateController
 *
 * @author 吴枫
 */
class SaleRebateController extends AdminBaseController{
    
     public function _initialize() {
        parent::_initialize();    
        $this->db=model("Rebate");
        $this->sale_rebate=  model("SaleRebate");
    }
    
    public function salerebate(){
        $type=2;
        $data = $this->db->getBysalerebate();
        $salerebate = $this->sale_rebate->getsaleAll();
        include $this->admin_tpl("sale_rebate");
    }
    
    public function editrebate(){
        $rebate = $_GET["rebate"]>100?100:$_GET["rebate"];
        $param["rebate"]=$rebate;
        $param["rebatetime"]=  time();
        $data = $this->db->updateRebate($param);
        if($data){
            echo '1';
        }else{
            echo '0';
        }
    }
    
    public function editrebatehierarchy(){
        $rebate = $_GET["RebateHierarchy"]<0||$_GET["RebateHierarchy"]>10?10:$_GET["RebateHierarchy"];
        $param["rebate_hierarchy"]=$rebate;
        $param["rebatetime"]=  time();
        $data = $this->db->updateRebate($param);
        if($data){
            $this->droprebate();
            $this->createSaleRebateSql();
            $this->insertSaleRebats();
            echo '1';
        }else{
            echo '0';
        }
    }
    /**
     * drop数据表
     */
    public function droprebate(){
          $this->db->dropRebate();
    }
    /**
     * 创建数据库语句
     */
    public function createSaleRebateSql(){
         $this->db->createSaleRebateSql();
    }
    /**
     * 向数据库插入数据并且初始化
     */
    public function insertSaleRebats(){
        $rebate_num = $this->db->getBysalerebate();
        $this->sale_rebate->insertSaleRebats($rebate_num["rebate_hierarchy"]);
    }

    public function EditRebateVal(){
        $count  =  count($_REQUEST);
        for ($i=0; $i < $count; $i++) { 
            $param['rebate_'.($i+1)] = $_REQUEST['rebate_'.($i+1)];
        }
        $data = $this->sale_rebate->update_rebate_val($count,$param);
        
        if ($data) {
            echo "1";
        }else{
            echo '0';
        }
        
    }

    
    
}

?>
