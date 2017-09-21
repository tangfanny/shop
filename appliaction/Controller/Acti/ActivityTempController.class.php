<?php

class ActivityTempController extends AdminBaseController {

    public function _initialize() {
        parent::_initialize();
        $this->act_list = M('act_list');
    }

    /**
     * 选择模板
     * @return [type] [description]
     */
    public function lists() {
		$validform='';
		$dialog = '';
		if (IS_POST) {
            $member_id = $_POST['member_id'];
            $push_num = $_POST['push_num'];
            $coupons_id = $_POST['coupons_id'];

            if (isset($member_id) && isset($push_num) && isset($coupons_id)) {
                self::push_coupons($member_id, $push_num, $coupons_id);
            } else {
               showmessage('参数错误，请联系管理员');
            }
		} else {
            $field = "id,name,path";
            $coupons = model('act_temp')->field($field)->select();
            foreach ($coupons as $k => $v) {
                $coupons[$k]['num'] = getCouponsCount($v['id'], 0);
            }
            $list = $coupons;
            //会员列表
            $user_group = M('UserGroup')->select();

			include $this->admin_tpl('activity_temp');
		}
    }
	
	/**
	 * 按条件搜索会员
	 */
	public function search_user(){
		$opt = $_GET['opt'];
		$group_id =$_GET['group_id'];
        if (IS_GET && $opt) {
            if (isset($opt) && $opt == 'search') {
                $userDB=model('User');
                $info=$userDB->push_userids($_GET);
                	if($info){               
	                    if (($info['id']) ) {
	                        $_info = $info;
	                    }else{
	                    	$_info['ids'] = arr2str($info);
//                                echo $_info;
	                    	$_info['count'] = count($info);
//                                echo $_info['count'];
                                
//
	                    }
                        $this->ajaxReturn($_info); 
                    }else{
                         $_info=array('status'=>0);
                         $this->ajaxReturn($_info); 
                    }                    
                }
            } 
	}

    /**
     * 新建活动
     * @return [type] [description]
     */
    public function activityCreate(){
        
        if(IS_POST){
            $param = $_POST;
            $param['addtime'] = time();
            if($this->act_list->create($param)){
                //die('aaa');
               $id = $this->act_list->add(); //返回活动ID
               $data['id'] = $id;
               $data['code'] = M('act_attr')->add($data);

               if(!empty($data['id'])){
                    echo json_encode($data);
               }else{
                    echo json_encode($data);
               }
                
            }  else {
               showmessage($this->act_list->getError(),NULL,0);
            }            
        }else{
            $id = $_GET['id'];
            include $this->admin_tpl('activity_temp_detail');
        }
      
    }

}
