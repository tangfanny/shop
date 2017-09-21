<?php
/**
 * 销售列表
 *
 * @author 陈星
 */
class SaleListController extends AdminBaseController{
    /**
     * 自动执行初始化方法
     */
    public function _initialize() {
        parent::_initialize();    
        $this->db = model("Rebate");
        $this->sale_list =  model("UserSales");
        // $this->income =  model("Income");
    }
    
   public function lists(){
        $type=5;
        if(IS_POST){
            $keyword = $_POST['keyword'];
            $user_id = $_POST['user_id'];
            $_order=isset($_POST['order']) ? ($_POST['order']) : NULL;
            $_sort=isset($_POST['sort']) ? ($_POST['sort']) : NULL;
            if($_order && $_sort){
                $order[$_sort] = $_order;
            }else{
                $order['id'] = 'DESC';
            }
            $pagenum=isset($_POST['page']) ? intval($_POST['page']) : 1;
            $rowsnum=isset($_POST['rows']) && (int)($_POST['rows']) != 0 ? intval($_POST['rows']) : PAGE_SIZE;
            $data['total'] = $this->sale_list->count();    //计算总数 
            $data['rows']=$this->sale_list->limit(($pagenum-1)*$rowsnum.','.$rowsnum)->order($order)->select();
            if (!$data['rows']) $data['rows']=array();
            $data = $this->sale_list->getList($keyword,$user_id,$_order,$_sort,$pagenum,$rowsnum);
            // echo $this->income->_sql();exit();
            echo json_encode($data);
        }else{
            include $this->admin_tpl("sale_list");
        }


    }

    
}

?>
