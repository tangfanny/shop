<?php
/**
 * 线下充值管理
 *  @author TXL
 * @date 2016-4-26
 */
class PayController extends AdminBaseController{
    public function _initialize() {
        parent::_initialize();
        $this->db = model('UserWalletPrepay');
        $this->user = model('User');
        $this->userwa = model('UserWallet');
    }
    
    public function lists(){
        $keyword = $_GET['keyword']?$_GET['keyword']:'';
        $prepay_suc = $_GET['prepay_suc']?$_GET['prepay_suc']:'';
        if(IS_POST){
            $con = array();
            switch($prepay_suc){
                case '0':
                    $con['prepay_suc'] = 0; //失败
                    break;
                case '1':
                    $con['prepay_suc'] = 1; //成功
                    break;
                case '3':
                    $con['prepay_suc'] = 3; //等待审核
                    break;
                default:
                    break;
            }
            $_order=isset($_POST['order']) ? ($_POST['order']) : NULL;
            $_sort=isset($_POST['sort']) ? ($_POST['sort']) : NULL;
            if($_order && $_sort){
                $order[$_sort] = $_order;
            }else{
                $order['b.ordtotal_fee'] = 'DESC';
            }
            if (isset($keyword) && $keyword) {
                $con["b.uid|a.nikename|a.mobile|a.email"]=array("like","%".$keyword."%");
            }
            $pagenum=isset($_POST['page']) ? intval($_POST['page']) : 1;
            $rowsnum=isset($_POST['rows']) && (int)($_POST['rows']) != 0 ? intval($_POST['rows']) : PAGE_SIZE;
            $data = $this->db->getUserPrepayList($con,$order,$pagenum,$rowsnum);
            if(!$data['rows']){$data["rows"]=array();}
                echo json_encode($data);
        }else{
			include $this->admin_tpl("offline_pay_list");
		}

    }

    public function edit(){
    	if(IS_POST){
            $id['id'] = array('eq',$_GET['id']) ;
            $status = $_POST['prepay_suc'];
            $where['uid'] =array('eq',$_POST['uid']) ;
            $where1['id'] =array('eq',$_POST['uid']) ;
            $data['check_time'] = time();
            switch($status) {
                case '0':
                    $data['refusal'] = $_POST['refusal'];
                    $data['prepay_suc'] = 0;
                    $message = "用户线下充值驳回！";
                    break;
                case '1':
                    $data['prepay_suc'] = 1;
                    $wallet = D('UserWallet')->where($where)->find();
                    $con['balance'] = $wallet['balance']+$_POST['ordtotal_fee'];
                    $con['expense'] = $wallet['prepaid']+$_POST['ordtotal_fee'];
                    $con['update_time'] = time();
                    $this->userwa->where($where)->save($con);
                    $user = $this->user->where($where1)->find();
                    $mobileNo = $user['mobile'];
                    $email = $user['email'];
                    $nikename = $user['nikename'];
                    if (empty($nikename) && !empty($email)){
                        $msg['username'] = $email;
                    }elseif(!empty($nikename) && empty($email)) {
                        $msg['username'] = $nikename;
                    }elseif (!empty($nikename) && !empty($email)) {
                        $msg['username'] = $nikename;
                    }else{
                        $msg['username'] = "";
                    }
                    $msg['money'] = $_POST['ordtotal_fee'];
                    if (empty($mobileNo)) {
                        $message = "获取用户手机号失败！无法发送短信！";
                    }else{
                        $type = '9';
                        sendPublicMsgByMobile($mobileNo,$type,$msg);
                        $message = "用户线下充值成功！";
                    }
                    break;
                case '3':
                    $message = "请选择审核状态！";
                    break;
            }
            $this->db->where($id)->save($data);
            if(!empty($message)){
                showmessage($message, U('lists'), 2);
            }
    	}else{
    		$id = $_GET['id'];
        	$info = $this->db->getUserCashInfo($id);
            include $this->admin_tpl("offline_pay_info");
        }
    }









}
?>
