<?php

/*
 * 新商品轮播图关联分享图标、分享标题、分享文案
 */
class ArticleFocusNewsController extends AdminBaseController{
    
    
    /**
     *	  自动执行
     *	 
     *
     */
	public function _initialize() {
		parent::_initialize();
		$this->db = model('Focus');
		libfile('form');
	}
        
        /*
         * 轮播图列表页面
         */
        public function lists(){
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
			$data['total'] = $this->db->count();	//计算总数 
			$data['rows']=$this->db->limit(($pagenum-1)*$rowsnum.','.$rowsnum)->select();
			if (!$data['rows']) $data['rows']=array();
			echo json_encode($data);
		}else{
			include $this->admin_tpl('article_focus_new_list');
		}
        }

	/**
	 * 添加修改页
	 */
	public function update(){
		$validform = TRUE;
		$opt=I("opt");
		$id=I("id",0);
		if(IS_POST){
			self::save();
		}else{
			if(isset($opt) && $opt){
				//添加
				if($opt=='add') {
					$id = I('id');
					$article_app_button=M('article_focus_new')->where('id='.$id)->Find();
					include $this->admin_tpl('article_focus_new_edit');
				}
				//编辑
				if($opt=='edit' && $id>0){
					$map['id'] = $id;
					$r = $this->db->getList($map);
					$info = $r['list'][0];
					$info['content'] = dstripslashes($info['content']);
					include $this->admin_tpl('article_focus_new_edit');
				}
				//删除
				if($opt == 'del' && $id ){
					unset($where);
					$where['id']=array('in',$id);
					$this->db->where($where)->delete();
					showmessage('恭喜你，删除成功！',U('Article_focus_new/lists'),1);
					exit();
				}
			}else{
				showmessage('参数错误,请联系管理员!',U('Article_focus_new/lists'),0);
			}
		}

	}
}
?>
