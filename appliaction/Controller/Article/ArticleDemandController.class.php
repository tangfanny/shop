<?php

/**
 * 威客商场申请试用
 */
class ArticleDemandController extends AdminBaseController{
    
    
      /**
        *	  自动执行
        *	 
        *
        */
	public function _initialize() {
		parent::_initialize();
		$this->db = model('demand');
                $this->category=model("industry_category");
	}
        
        public function lists(){

//           echo sendPublicMsgByMobile("18612337466","1","2222");
            $pos_id = $_GET['pos_id'];
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
			$data['total'] = $this->db->where($sqlmap)->count();	//计算总数 
			$data['rows']=$this->db
				->field(true)
				->where($sqlmap)
				->limit(($pagenum-1)*$rowsnum.','.$rowsnum)
				->order($order)
				->select();
                        foreach ($data['rows'] as $k=>$value){
                            $where["id"]=array("in",$value["category_id"]);
                            $categorylist =$this->category->field(true)->where($where)->select();
                            $categoryname = "";
                            foreach ($categorylist as $ck=>$cvalue){
                                $categoryname=$categoryname.",".$cvalue["name"];
                            }
                            $data["rows"][$k]["category_id"]=$categoryname;
                        }
                        if(!$data["rows"]){
                            $data["rows"]="";
                        }
                        foreach ($data["rows"] as $k=>$v){
                            $data["rows"][$k]["user_name"]=  base64_decode($v["user_name"]);
                            $data["rows"][$k]["company_size"] = base64_decode($v["company_size"]);
                            $data["rows"][$k]["description"] = base64_decode($v["description"]);

                        }
			echo json_encode($data);
		}else{
			include $this->admin_tpl('article_demand_lists');
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
                                    $r = $this->db->where($wehre)->find();
                                    if(empty($r["phone"])){
                                        showmessage('恭喜你，处理成功！',U('ArticleDemand/lists'),1); 
                                    }else{
                                        sendPublicMsgByMobile($r["phome"],"1","","");
                                        showmessage('恭喜你，处理成功,短信发送成功！',U('ArticleDemand/lists'),1); 
                                    }           
                                }
                                
				//编辑
//				if($opt=='edit' && $id>0){
//					$map['id'] = $id;
//					$r = $this->db->getList($map);
//					$info = $r['list'][0];
//					$info['content'] = dstripslashes($info['content']);
//					include $this->admin_tpl('article_adv_update');
//				}
				//删除
				if($opt == 'del' && $id ){
					unset($where);
					$where['id']=array('in',$id);
					$this->db->where($where)->delete();
					showmessage('恭喜你，删除成功！',U('ArticleOntrial/lists'),1); 
					exit(); 
				}
			}else{
				showmessage('参数错误,请联系管理员!',U('ArticleOntrial/lists'),0);
			}
        }        
}
?>
