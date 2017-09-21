<?php
/**
 * 设置积分兑换逻辑处理类
 *
 * @author 吴枫
 */
class SaleRankExcController extends AdminBaseController{
    //初始化自动执行
    public function _initialize() {
        parent::_initialize();
        $this->db = model('SaleRankExc');
    }
    
    public function lists(){
        $type=4;
        if(IS_POST){
            $sqlmap = array();
            $_order=isset($_POST['order']) ? ($_POST['order']) : NULL;
            $_sort=isset($_POST['sort']) ? ($_POST['sort']) : NULL;
		if($_order && $_sort){
                    $order[$_sort] = $_order;
		}else{
                    $order['id'] = 'DESC';
		}
                    $pagenum=isset($_POST['page']) ? intval($_POST['page']) : 1;
                    $rowsnum=isset($_POST['rows']) && (int)($_POST['rows']) != 0 ? intval($_POST['rows']) : PAGE_SIZE;
                    $data['total'] = $this->db->count();    //计算总数 
                    $data['rows']=$this->db->limit(($pagenum-1)*$rowsnum.','.$rowsnum)->order($order)->select();
                    if (!$data['rows']) $data['rows']=array();
			echo json_encode($data);
            }else{
                    include $this->admin_tpl('sale_rebate_exc_list');
            }
        }
        
        public function edit(){
            $id=$_GET["id"];
            $info = $this->db->getSaleRankExcById($id);
            if(!$info) showmessage('参数错误');
            if(IS_POST){
                $column["sale_key_value"]=$_POST["sale_key_value"];
                $column["rank"]=$_POST["rank"];
                $id=$_POST["id"];
                $rs = $this->db->saveSaleRankExcById($id,$column);

			if (!$rs) {
				showmessage($this->db->getError());
			} else {
				showmessage('编辑成功', U('lists'), 1);
			}
            }else{
               include $this->admin_tpl("sale_rebate_exc_edit");
            }
        }
}
?>
