<?php
/**
 * 设置积分关系处理类
 *
 * @author 陈星
 */
class SaleIntegralController extends AdminBaseController{
    /**
     * 自动执行初始化方法
     */
    public function _initialize() {
        parent::_initialize();    
        $this->db=model("Rebate");
        $this->sale_rebate =  model("SaleRebate");
        $this->sale_integral =  model("SaleIntegral");
    }
    /**
     * drop数据表
     */
    public function dropIntegral(){
          $this->db->dropIntegralRebate();
    }
    /**
     * 创建数据库语句
     */
    public function createSaleIntegralSql(){
         $this->db->createSaleIntegralSql();
    }
    /**
     * 向数据库插入数据并且初始化
     */
    public function insertSaleIntegral(){
        $integral_num = $this->db->getBysaleintegral();
        $this->sale_integral->insertSaleIntegral($integral_num["integral_hierarchy"]);
    }

    
   public function saleintegral(){
        $type=3;
        $data = $this->db->getBysalerebate();
        // $salerebate = $this->sale_rebate->getsaleAll();
        $saleintegral = $this->sale_integral->getsaleAll();
        include $this->admin_tpl("sale_integral");
    }

    public function editintegralhierarchy(){
        $integral = $_GET["IntegralHierarchy"]<0||$_GET["IntegralHierarchy"]>10?10:$_GET["IntegralHierarchy"];
        $param["integral_hierarchy"]=$integral;
        $param["integraltime"]=  time();
        $data = $this->db->updateInteralRebate($param);
        if($data){
            $this->dropIntegral();
            $this->createSaleIntegralSql();
            $this->insertSaleIntegral();
            echo '1';
        }else{
            echo '0';
        }
    }
    public function editintegral(){
        $count  =  count($_REQUEST);

        for ($i=0; $i < $count; $i++) { 
            $param['integral_'.($i+1)] = $_REQUEST['integral_'.($i+1)];
        }
        $data = $this->sale_integral->update_integral_val($count,$param);
        
        if ($data) {
            echo "1";
        }else{
            echo '0';
        }
        
    }
    
}

?>
