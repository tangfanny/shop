<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ArticleCheapGoodsController extends AdminBaseController{
    
    /**
     * 自动执行
     */
    public function _initialize() {
		parent::_initialize();
		$this->db = model('cheap_list');

    }
    
    public function lists(){
            $goods_id = isset($_GET['goods_id'])?$_GET['goods_id']:1;
            $type = isset($_GET['type'])?$_GET['type']:1;
          
            if(IS_POST){
                       $sqlmap = array();
                       $sqlmap['goods_id']= $goods_id;
                        $sqlmap["cheapflag"]=$type;
			$_order=isset($_POST['order']) ? ($_POST['order']) : NULL;
			$_sort=isset($_POST['sort']) ? ($_POST['sort']) : NULL;
			if($_order && $_sort){
				$order[$_sort] = $_order;
			}else{
				$order['createtime'] = 'DESC';
			}
			$pagenum=isset($_POST['page']) ? intval($_POST['page']) : 1;
			$rowsnum=isset($_POST['rows']) && (int)($_POST['rows']) != 0 ? intval($_POST['rows']) : PAGE_SIZE;
			$data['total'] = $this->db->where($sqlmap)->count();	//计算总数 、
			$data['rows']=$this->db
				->field(true)
				->where($sqlmap)
				->limit(($pagenum-1)*$rowsnum.','.$rowsnum)
				->order($order)
				->select();
//                        echo $this->db->getLastSql();
                        if(!$data['rows']){
                           $data["rows"]=""; 
                        }
                        
                        foreach ($data["rows"] as $k=>$v){
                            $data["rows"][$k]["user_name"]=  base64_decode($v["user_name"]);
                            $data["rows"][$k]["goods_name"]=  base64_decode($v["goods_name"]);
                            $data["rows"][$k]["goods_name"]=  base64_decode($v["goods_name"]);
                        }
			echo json_encode($data);
		}else{
			include $this->admin_tpl('article_cheap_goods_lists');
		}
    }
    
    public function update(){
        
             $opt=I("opt");
             $id=I("id",0);
             $type = isset($_GET['type'])?$_GET['type']:-1;
            if(isset($opt) && $opt){
				
                                //修改是否处理
                                if($opt=='updataflag'){
                                    $wehre["id"]=$id;
                                    $column["processing_flag"] =1;
                                    $column["processing_time"]=  time();
                                    $this->db->where($wehre)->data($column)->save();
                                    showmessage('恭喜你，处理成功！',U('ArticleCheapGoods/lists'),1); 
                                }
				//删除
				if($opt == 'del' && $id ){
					unset($where);
					$where['id']=array('in',$id);
					$this->db->where($where)->delete();
					showmessage('恭喜你，删除成功！',U('ArticleCheapGoods/lists'),1); 
					exit(); 
				}
			}else{
				showmessage('参数错误,请联系管理员!',U('ArticleCheapGoods/lists'),0);
			}
        
    }
}

?>
