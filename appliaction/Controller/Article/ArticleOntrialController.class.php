<?php

/**
 * 威客商场申请试用
 */
class ArticleOntrialController extends AdminBaseController{
    
    
      /**
        *	  自动执行
        *	 
        *
        */
	public function _initialize() {
		parent::_initialize();
		$this->db = model('on_trial');
	}
        
        public function lists(){
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
                        if(!$data["rows"]){
                            $data["rows"]="";
                        }
                        foreach ($data["rows"] as $k=>$v){
                            $data["rows"][$k]["nikename"]=  base64_decode($v["nikename"]);
                            $data["rows"][$k]["name"]=  base64_decode($v["name"]);
                            $data["rows"][$k]["address"]=  base64_decode($v["address"]);
                            $data["rows"][$k]["goods_name"]=  base64_decode($v["goods_name"]);
                        }
			echo json_encode($data);
		}else{
			include $this->admin_tpl('article_on_trial_lists');
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
                                    showmessage('恭喜你，处理成功！',U('ArticleOntrial/lists'),1); 
                                }
                                
				//编辑
				if($opt=='edit' && $id>0){
					$map['id'] = $id;
					$r = $this->db->getList($map);
					$info = $r['list'][0];
					$info['content'] = dstripslashes($info['content']);
					include $this->admin_tpl('article_adv_update');
				}
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
        
//        public  function sendPublicMsgByMobile($mobileNo='18612337466', $type=3, $msg='')
//    {
//        $post_data = array();
//        $post_data['account'] = iconv('GB2312', 'GB2312',"vip_wkzc");
//        $post_data['pswd'] = iconv('GB2312', 'GB2312',"Tch123456");
//        $post_data['mobile'] =$mobileNo;
//		if($type == 1) {
//			// 发送验证码 1
//			$message="动态验证码".$msg."。请勿向任何人泄露。";
//		} else if($type == 2) {
//			// 通过 2
//			$message="亲爱的威客安全用户，您发布的众测项目已经审核通过，请尽快登陆www.secwk.com进行查看。";
//		} else if($type == 3) {
//			// 驳回 3
//			$message="亲爱的威客安全用户~非常抱歉，您发布的众测项目被驳回，驳回原因请您登陆www.secwk.com进行查看。";
//		} else if($type == 4) {
//			// 到期 4
//			$message="亲爱的威客安全用户，您发布的".$msg."众测项目已经结束，您的漏洞修复完成了吗？白帽子希望你们更安全。";
//		} else if($type == 5) {
//			// 漏洞提交 5
//			$message="亲爱的威客安全用户，您发布的".$msg."众测项目有新的漏洞提交了，赶快登陆www.secwk.com进行确认哦~白帽子提醒您，请尽快修复漏洞。";
//		} else if($type == 6) {
//			// 授权成功 6
//			$message="亲爱的威客安全用户，您的授权已经成功，请尽快登陆www.secwk.com进行查看。";
//		} else if($type == 7) {
//			// 认证成功 7
//			$message="亲爱的威客安全用户，您申请的白帽子/销售认证已经成功，请尽快登陆www.secwk.com进行查看。";
//		} else if($type == 8) {
//			// 认证失败 8
//			$message="亲爱的威客安全用户~非常抱歉~您提交的白帽子/销售认证失败，失败原因请您登陆www.secwk.com进行查看。";
//		} else if($type == 9) {
//			// 充值成功 9
//			$message="亲爱的威客安全用户，用户名为".$msg['username']."成功充值".$msg['money']."元，感谢您对我们的支持。";
//		} else if($type == 10) {
//			// 提现成功 10
//			$message="亲爱的威客安全用户，用户名为".$msg['username']."成功提现".$msg['money']."元，请您尽快查看资金是否到账。感谢您对我们的支持。";
//		}
//        
//        $post_data['msg']=mb_convert_encoding($message,'UTF-8', 'UTF-8');
//        //$url='http://222.73.117.158/msg/HttpSendSM?'; //单发
//        $url='http://222.73.117.158/msg/HttpBatchSendSM?'; //群发
//        $o="";
//        foreach ($post_data as $k=>$v)
//        {
//            $o.= "$k=".urlencode($v)."&";
//        }
//        $post_data=substr($o,0,-1);
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_HEADER, 0);
//        curl_setopt($ch, CURLOPT_URL,$url);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
//        $result = curl_exec($ch);
//        return $result;
//    }
        
}
?>
