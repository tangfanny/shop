<?php

/*
 * 会员发票管理为base1.0版本
 * 1、主要主要列表展现
 */
class MemberInvoiceController extends AdminBaseController{
    
    
        /**
	 * 自动执行
	 */
	public function _initialize() {
		parent::_initialize(); 
		$this->db = model('BillInvoice');
	}
        /**
         * 
         */
        public function lists(){
            $user_id = $_GET["user_id"];
            if(IS_POST){
                $sqlmap['uid']=I('user_id');
                //分页
		$pagenum=isset($_GET['page']) ? intval($_GET['page']) : 1;
		$rowsnum=isset($_GET['rows']) && (int)($_GET['rows']) != 0 ? intval($_GET['rows']) : PAGE_SIZE;
                $data["total"] = $this->db->getCount($user_id);
                $data["rows"] = $this->db->getInvoiceList($user_id,$pagenum,$rowsnum);
                foreach ($data["rows"] as $k=>$v){
                   if($v["invoice_type"]==1){
                       $data["rows"][$k]["title"]=  base64_decode($v["title"]);
                       $data["rows"][$k]["taxpayer"]=  "-";
                       $data["rows"][$k]["reg_address"]= "-";
                       $data["rows"][$k]["reg_tel"]=  "-";
                       $data["rows"][$k]["bank"]=  "-";
                       $data["rows"][$k]["account"]=  "-";
                   }else{
                       $data["rows"][$k]["title"]=  base64_decode($v["title"]);
                       $data["rows"][$k]["reg_address"]=  base64_decode($v["reg_address"]);
                       $data["rows"][$k]["bank"]=  base64_decode($v["bank"]);
                   } 
                }
                if (!$data['rows']) $data['rows']=array();
                echo json_encode($data);
            }else{
                include $this->admin_tpl('member_invoice_list');
            }
        }
}
?>
