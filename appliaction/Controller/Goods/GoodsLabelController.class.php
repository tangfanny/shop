<?php

/*
 * 商品标签管理
 */

header('Content-Type: text/html; charset=UTF-8');
class GoodsLabelController extends AdminBaseController{
    
    public function _initialize() {
        parent::_initialize(); 
        $this->db = model('GoodsLabel');
        
    }
    /**
     * 获取标签列表
     */
    public function lists(){
        if(IS_POST){
			$sqlmap = array();
			if(is_numeric($status)){
				$sqlmap['status'] = $status;
			}
			$_order=isset($_POST['order']) ? ($_POST['order']) : NULL;
			$_sort=isset($_POST['sort']) ? ($_POST['sort']) : NULL;
			if($_order && $_sort){
				$order[$_sort] = $_order;
			}else{
				$order['id'] = 'DESC';
			}
			$pagenum=isset($_POST['page']) ? intval($_POST['page']) : 1;
			$rowsnum=isset($_POST['rows']) && (int)($_POST['rows']) != 0 ? intval($_POST['rows']) : PAGE_SIZE;
			$data['total'] = $this->db->where($sqlmap)->getField('id', true);	//计算总数 
			$data['total'] = count($data['total']);
			$data['rows']=$this->db
				->where($sqlmap)
				->limit(($pagenum-1)*$rowsnum.','.$rowsnum)
				->order($order)
				->select();
			if (!$data['rows']) $data['rows']=array();
			echo json_encode($data);
		}else{
			include $this->admin_tpl('goods_lasbel_lists');
		}
    }
    
    /**
     * 添加标签
     */
    public function add(){
        if(IS_POST){
		$_GET['value'] = implode(',', array_unique($_GET['value']));
		if($this->db->create($_GET)){
		   $this->db->add();
		   showmessage('标签添加成功!',U('lists'),1);
		}  else {
		   showmessage($this->db->getError(),NULL,0);
		}	 
	}  else {
		$validform = $dialog = TRUE;
		include $this->admin_tpl("goods_lasbel_add");
	}
    }
    /**
     * 修改是否显示
     */
    public function ajax_status(){
        $id=intval($_GET['id']);
		if($id>0){
			$brand=model('GoodsLabel');
			$data['status']=array('exp',' 1-status ');
			$brand->where('id='.$id)->save($data);
			$this->success('恭喜你，成功改变状态！'); 
		}else{
		   $this->error('非法操作，请联系管理员！'); 
	}
    }
    /**
     * 删除数据
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
     * 编辑页面
     */
    public function edit(){
        $brand=model('GoodsLabel');
		$validform = true;
		$dialog = true;
		if(IS_POST){
			if($brand->create()){
//				var_dump($_POST);exit();
				$brand->save();
			   showmessage('ok',  U('lists'),1);
			}  else {
				showmessage($brand->getError(),  NULL,0);
			}
			
		}  else {
			if($_GET['id']){
				$where['id']=$_GET['id'];
				$info=$brand->where($where)->find();
				include $this->admin_tpl("goods_lasbel_edit");
			}else{
				showmessage('传递错误',NULL,0);
			}
			
		}
    }
}
?>
