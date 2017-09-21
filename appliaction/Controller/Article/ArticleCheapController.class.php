<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ArticleCheapController extends AdminBaseController{
    
    /**
     * 自动执行
     */
    public function _initialize() {
		parent::_initialize();
		$this->db = model('cheap_count');
                $this->goodsdb=model("cheap_list");
    }
    
    public function lists(){
         $type = isset($_GET['type'])?$_GET['type']:-1;
            if(IS_POST){
			$sqlmap = array();
			$_order=isset($_POST['order']) ? ($_POST['order']) : NULL;
			$_sort=isset($_POST['sort']) ? ($_POST['sort']) : NULL;
			if($_order && $_sort){
				$order[$_sort] = $_order;
			}else{
				$order['id'] = 'DESC';
			}
                        switch ($type) {
                            case '1':
				$sqlmap['cheapflag'] = 1;
				break;
			case '2':
                                $sqlmap['cheapflag'] = 0;
				break;
			default:
				break;
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
                         foreach ($data["rows"] as $k=>$v){
                            $data["rows"][$k]["goods_name"]=  base64_decode($v["goods_name"]);

                        }
			echo json_encode($data);
		}else{
			include $this->admin_tpl('article_cheap_count_lists');
		}
    }
    
    public function update(){
        
             $opt=I("opt");
              $id=I("id",0);
             $type = I("type");
            if(isset($opt) && $opt){
                                //修改是否处理
                                if($opt=='goodscheap'){
                                   // showmessage('恭喜你，处理成功！',U('ArticleCheapGoods/lists',array("id"=>$id,"type"=>$type)),1); 
                                    $this->redirect(U('ArticleCheapGoods/lists',array("id"=>$id,"type"=>$type)));
                                }
			}else{
				showmessage('参数错误,请联系管理员!',U('ArticleOntrial/lists'),0);
			}
    }
    
    
}

?>
