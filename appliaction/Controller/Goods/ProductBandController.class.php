<?php

class ProductBandController extends AdminBaseController {

	public function _initialize() {
		parent::_initialize();
		$this->db = model('Brand');
//		$this->brand = model('brand_rank_sum');
	}

	/**
	 * 品牌列表
	 */
	public function lists(){
		if(IS_POST){
			$sqlmap = array();

			$_order=isset($_POST['order']) ? ($_POST['order']) : NULL;
			$_sort=isset($_POST['sort']) ? ($_POST['sort']) : NULL;
			if($_order && $_sort){
				$order[$_sort] = $_order;
			}else{
				$order['sort'] = 'ASC';
				$order['id'] = 'DESC';
			}

			$pagenum=isset($_POST['page']) ? intval($_POST['page']) : 1;
			$rowsnum=isset($_POST['rows']) && (int)($_POST['rows']) != 0 ? intval($_POST['rows']) : PAGE_SIZE;
			$data['total'] = $this->db->count();	//计算总数
			$data['rows']=$this->db->order($order)->limit(($pagenum-1)*$rowsnum.','.$rowsnum)->select();

			if (!$data['rows']) $data['rows']=array();
			echo json_encode($data);
		}else{
			include $this->admin_tpl('product_band_lists');
		}
	}
	/**
	 * 改变状态
	 */
	public function ajax_status(){
		$id=intval($_GET['id']);
		if($id>0){
			$brand=model('brand');
			$data['status']=array('exp',' 1-status ');;
			$brand->where('id='.$id)->save($data);
			$this->success('恭喜你，成功改变状态！');
		}else{
			$this->error('非法操作，请联系管理员！');
		}
	}
	/**
	 * 改变排序
	 */
	public function ajax_sort(){
		$id=intval($_GET['id']);
		$val=  intval($_GET['val']);
		if($id>0){
			$brand=model('brand');
			$data['sort']=$val;
			$brand->where('id='.$id)->save($data);
			$this->success('恭喜你，成功改变排序！');
		}else{
			$this->error('非法操作，请联系管理员！');
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
//		$where['bid'] = array("IN", $id);
		$this->db->where($sqlmap)->delete();
//		$this->brand->where($where)->delete();
		showmessage('数据删除成功', U('lists'), 1);
	}
	/**
	 * 添加
	 */
	public function add(){
		$validform = true;
		$dialog = true;
		if(IS_POST){
			$brand=model('Brand');
			if($brand->create()){
				//添加品牌的同时给排行榜数据表进行添加

				$id = $brand->add();
//				$data['b_name'] = $_POST['name'];
//				$data['bid'] = $id;
//				$da = M('brand_rank_sum')->add($data);
				showmessage('添加成功',U('lists'),1);
			}  else {
				showmessage($brand->getError(),  U('lists'),0);
			}
		}  else {
			include $this->admin_tpl("product_band_add");
		}
	}
	/**
	 * 编辑
	 */
	public function edit(){
		$brand=model('Brand');
		$validform = true;
		$dialog = true;
		if(IS_POST){
			if($brand->create()){
				//修改商品的同时给排行榜数据表进行更新
//				$where['bid'] = $_POST['id'];
//				$data['b_name'] = $_POST['name'];
//				$_id = M('brand_rank_sum')->where($where)->save($data);
				$brand->save();
				showmessage('ok',  U('lists'),1);
			}  else {
				showmessage($brand->getError(),  NULL,0);
			}

		}  else {
			if($_GET['id']){
				$where['id']=$_GET['id'];
				$info=$brand->where($where)->find();
				include $this->admin_tpl("product_band_edit");
			}else{
				showmessage('传递错误',NULL,0);
			}

		}
	}
}
