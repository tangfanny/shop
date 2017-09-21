<?php

class MemberAddressController extends AdminBaseController {

	public function _initialize() {
		parent::_initialize();	
                $this->db= model("PostAddress");
	}
	
	/**
	 * 收货地址列表
	 */
	public function lists(){
		$user_id = $_GET['user_id'];
		if(IS_POST){
			$sqlmap = array();		
			$sqlmap['uid']=I('user_id');		
			//分页
			$pagenum=isset($_GET['page']) ? intval($_GET['page']) : 1;
			$rowsnum=isset($_GET['rows']) && (int)($_GET['rows']) != 0 ? intval($_GET['rows']) : PAGE_SIZE;
			//计算总数 
			$data['total'] = $this->db->where($sqlmap)->count();	
			$data['rows']=$this->db->where($sqlmap)->limit(($pagenum-1)*$rowsnum.','.$rowsnum)->order($order)->select();
                        foreach ($data["rows"] as $k=>$v){
                            $data["rows"][$k]["address_name"]=  base64_decode($v["name"]);
                            $data["rows"][$k]["prov_name"]=  base64_decode($v["province"]);
                            $data["rows"][$k]["city_name"]= base64_decode($v["city"]);
                            $data["rows"][$k]["dist_name"]=  base64_decode($v["area"]);
                            $data["rows"][$k]["address"]=  base64_decode($v["address"]);
                        }
			if (!$data['rows']) $data['rows']=array();
//                        echo var_dump($data['rows']);
			echo json_encode($data);
		}else{
			include $this->admin_tpl('member_address_list');
		}
	}
}