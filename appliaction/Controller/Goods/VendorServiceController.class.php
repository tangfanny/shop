<?php
/**
 * 规格管理
 */
class VendorServiceController extends AdminBaseController {

	public function _initialize() {
		parent::_initialize();
		$this->db = model('vendor_service');
                $this->brand = model("brand");
	}

	/* 规格列表 */
	public function lists(){
//	  $sqlmap = array();
//	  $count  = $this->db->where($sqlmap)->count();
//		$pagesize = $_GET['pagesize'];
//		$pagesize = $pagesize ? $pagesize : getconfig('page_num');
//	  $page   = new Page($count, $pagesize);
//	  $lists  = $this->db->where($sqlmap)->order("`sort` ASC")->page(PAGE, $pagesize)->select();
//	  $meta_title = '规格列表';
//		$page = $page->show();
//	  include $this->admin_tpl("product_spec_lists");
		if(IS_POST){
			$sqlmap = array();
			
			$_order=isset($_POST['order']) ? ($_POST['order']) : NULL;
			$_sort=isset($_POST['sort']) ? ($_POST['sort']) : NULL;
			if($_order && $_sort){
				$order[$_sort] = $_order;
			}else{
				$order['t_vendor_service.sort'] = 'ASC';
				$order['t_vendor_service.id'] = 'DESC';
			}
			
			$pagenum=isset($_POST['page']) ? intval($_POST['page']) : 1;
			$rowsnum=isset($_POST['rows']) && (int)($_POST['rows']) != 0 ? intval($_POST['rows']) : PAGE_SIZE;
			$data['total'] = $this->db->count();	//计算总数 
			$data['rows']=$this->db->join("left join t_brand on t_brand.id=t_vendor_service.brand_id")
                                ->order($order)->limit(($pagenum-1)*$rowsnum.','.$rowsnum)
                                ->field("t_brand.name,t_vendor_service.value,t_vendor_service.id,t_vendor_service.type,t_vendor_service.sort,t_vendor_service.status")->select();
//                        echo $this->db->getLastSql();

			if (!$data['rows']) $data['rows']=array();
			echo json_encode($data);
		}else{
			include $this->admin_tpl('product_vendor_lists');
		}
	}
        /**
         * 不可以选择服务年限
         */
        public function search_spec_main(){
		$map = array();
		$list = $this->db->where($map)->select();
		foreach ($list as $key => $value) {
			$list[$key]['values'] = str2arr($value['value']);
		}
		include $this->admin_tpl('goods_search_spec_main');
	}
        /**
         * 可选择服务年限
         */
        public function search_spec(){
		$map = array();
		$list = $this->db->where($map)->order('id ASC')->select();
		foreach ($list as $key => $value) {
			if (empty($value['value'])) continue;
			$list[$key]['values'] = str2arr($value['value']);
		}
		include $this->admin_tpl('goods_search_spec_vendor');
	}
        
        /* 添加或编辑商品时：新增规格 */
	public function goods_add_spec() {
		if (empty($_POST['name'])) $this->error('请填写要添加的规格名称');
		$result = $this->db->add(array('name'=>$_POST['name']));
		if (!$result) $this->error('新规格添加失败');
		$this->success('添加成功');
	}
        
        /* 添加或编辑商品时：新增属性 */
	public function goods_add_value() {
		$data       = array();
		$data['id'] = (int)$_POST['spec_id'];
		$new_value  = str_replace('，',',',trim($_POST['new_value']));
		if (empty($new_value)) $this->error('请填写要添加的属性值');
		if ($data['id'] < 1) $this->error('该规格不存在或规格ID有误');
		$old_info = $this->db->find($data['id']);
		if (empty($old_info['value'])) {
			$data['value'] = $new_value;
		} else {
			$data['value'] = $old_info['value'].','.$new_value;
		}
		$result = $this->db->save($data);
		if (!$result) $this->error('新增属性失败');
		$this->success('新增属性成功');
	}

	/* 改变状态 */
	public function ajax_status(){
		$id= intval($_GET['id']);
		if($id>0){
			$data['status']=array('exp',' 1-status ');;
			$this->db->where('id='.$id)->save($data);
			showmessage('恭喜你，成功改变状态！', '', 1);
		}else{
		   showmessage('非法操作，请联系管理员！'); 
		}
	}
	 /**
	 * 改变排序
	 */
	public function ajax_sort(){
		$id=intval($_GET['id']);
		$val=  intval($_GET['val']);
		if($id>0){
			$data['sort'] = $val;
			$this->db->where('id='.$id)->save($data);
			showmessage('恭喜你，成功改变排序！', '', 1); 
		}else{
		   showmessage('非法操作，请联系管理员！'); 
		}
	}
	 /**
	 * 删除品牌
	 */
	public function ajax_del(){
		$id = (array) $_GET['id'];
		$sqlmap = array();
		if(empty($id)) showmessage('参数错误');
		$sqlmap = array();
		$sqlmap['id'] = array("IN", $id);
		$this->db->where($sqlmap)->delete();
		showmessage('数据删除成功', U('lists'), 1);
	}
	/**
	 * 添加
	 */
	public function add(){
                $brandlist = $this->brand->select();
		if(IS_POST){
			$_GET['value'] = implode(',', array_unique($_GET['value']));
			if($this->db->create($_GET)){
			   $this->db->add();
			   showmessage('规则添加成功',U('lists'),1);
			}  else {
			   showmessage($this->db->getError(),NULL,0);
			}	 
		}  else {
			$validform = $dialog = TRUE;
			include $this->admin_tpl("product_vendor_add");
		}
	}
	/**
	 * 编辑
	 */
	public function edit(){
                $brandlist = $this->brand->select();
		if(IS_POST){
			$_GET['value'] = implode(',', array_unique($_GET['value']));
			if($this->db->create($_GET)){
			   $this->db->save();
			   showmessage('规则编辑成功',U('lists'),1);
			}  else {
			   showmessage($this->db->getError(),NULL,0);
			}			
		}  else {
			$validform = $dialog = TRUE;
			$id = (int) $_GET['id'];
			$info = $this->db->getById($id);
			if(!$info) showmessage('参数错误或数据不存在');
			include $this->admin_tpl("product_vendor_edit");			
		}
	}
}
