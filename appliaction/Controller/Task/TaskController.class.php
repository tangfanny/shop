<?php
/**
 *
 * 众测项目管理
 * @author TXL
 * @date 2016-4-27
 *
 */
class TaskController extends AdminBaseController
{
    public function _initialize() {
        parent::_initialize();
        $this->db = model('task');
        $this->bm = model('task_enroll');
        $this->user = model('user');
        $this->auth = model('user_auth');
        $this->wallet = model('user_wallet_account');
        $this->bug = model('task_bug');
        $this->user = model("User");
    }
    public  function lists()
    {
        $keyword = $_GET['keyword']?$_GET['keyword']:'';
        if (IS_POST) {
            $where = array();
            $_order = isset($_POST['order']) ? ($_POST['order']) : NULL;
            $_sort = isset($_POST['sort']) ? ($_POST['sort']) : NULL;
            if ($_order && $_sort) {
                $order[$_sort] = $_order;
            } else {
                $order['a.sec_price'] = 'DESC';
            }
            if (isset($keyword) && $keyword) {
                $where["a.task_id|a.title|b.email|b.mobile"] = array("like", "%" . $keyword . "%");
            }
            $pagenum = isset($_POST['page']) ? intval($_POST['page']) : 1;
            $rowsnum = isset($_POST['rows']) && (int)($_POST['rows']) != 0 ? intval($_POST['rows']) : PAGE_SIZE;
            $data = $this->db->getTaskList($where, $order, $pagenum, $rowsnum);
            if (!$data['rows']) {
                $data["rows"] = array();
            }
            echo json_encode($data);
        } else {
            include $this->admin_tpl("task_lists");
        }
    }
    public function edit(){
        if(IS_POST){
            $where['task_id'] = array('eq',$_POST['task_id']);
            $_POST['start_time'] = strtotime($_POST['start_time']);
            $_POST['end_time'] = strtotime($_POST['end_time']);
            $_POST['create_time'] = time();
            $_POST['isopen'] = isset($_POST['isopen'])?$_POST['isopen']:"1";
            $this->db->where($where)->save($_POST);
            showmessage('修改成功！', U('lists'), 2);
        }else{
            $taskid = $_GET['task_id'];
            $info = $this->db->getInfoByTaskid($taskid);
            include $this->admin_tpl('task_edit');
        }
    }

    public function shenhe(){
        if($_POST){
            $uid =  $_POST['uid'];
            $status = $_POST['pub_status'];
            $where['task_id'] = array('eq', $_POST['task_id']);
            $data['check_time'] = time();
            $data['refusal'] = $_POST['refusal'];
            $message = '';
            switch ($status) {
                case '1':
                    $data['pub_status'] = 1;
                    $data['start_level'] = $_POST['start_level'];
                    $message = "该众测已通过！";
                    $type = 2;
                    $msg = $_POST['title'];
                    $this->sendMes($uid,$type,$msg);
                    break;
                case "2":
                    $data['pub_status'] = 2;
                    $type = 2;
                    $message = "该众测已驳回！";
                    $this->sendMes($uid,$type);
                    break;
                case '7':
                    $data['pub_status'] = 7;
                    $message = "该众测已完成！";
                    break;
                case '8':
                    $data['pub_status'] = 8;
                    $message = "该众测已取消！";
                    break;
                case '9':
                    $data['pub_status'] = 9;
                    $msg = $_POST['title'];
                    $type = 4;
                    $message = "该众测已过期！";
                    $this->sendMes($uid,$type,$msg);
                    break;
            }
            $this->db->where($where)->save($data);
            if(!empty($message)){
                showmessage($message, U('lists'), 2);
            }
        }else{
            $where['task_id']= array('eq',$_GET['task_id']);
            $info = $this->db->where($where)->find();
            include $this->admin_tpl("task_shenhe");
        }
    }
    private function  sendMes($uid,$type,$msg){
        $user = $this->user->where('id='.$uid)->find();
        $mobileNo = $user['mobile'];
        $email = $user['email'];
        if (empty($mobileNo)) {
            sendMsgByEmail($email,$msg);
        } else {
            sendPublicMsgByMobile($mobileNo,$type,$msg);
        }
    }

    /*
     * 报名列表
     * */
    public function bmlist()
    {
        $keyword = $_GET['keyword']?$_GET['keyword']:'';
        $ispass = $_GET['ispass']?$_GET['ispass']:'';
        $tid = $_GET['task_id'];
        if (IS_POST) {
            $where = array();
            $where['task_id'] = array('eq',$tid);
            switch ($ispass) {
                case '0':
                    $where['a.ispass'] = 0; //未通过
                    break;
                case '1':
                    $where['a.ispass'] = 1; //通过
                    break;
            }
            $_order = isset($_POST['order']) ? ($_POST['order']) : NULL;
            $_sort = isset($_POST['sort']) ? ($_POST['sort']) : NULL;
            if ($_order && $_sort) {
                $order[$_sort] = $_order;
            } else {
                $order['a.create_time'] = 'DESC';
            }
            if (isset($keyword) && $keyword) {
                $where["b.nikename|b.email|b.mobile"] = array("like", "%" . $keyword . "%");
            }
            $pagenum = isset($_POST['page']) ? intval($_POST['page']) : 1;
            $rowsnum = isset($_POST['rows']) && (int)($_POST['rows']) != 0 ? intval($_POST['rows']) : PAGE_SIZE;
            $data = $this->bm->getBmList($where, $order, $pagenum, $rowsnum);
            if(!$data['rows']){
                $data["rows"]=array();
            }
            echo json_encode($data);
        }else{
            include $this->admin_tpl("task_bmlist");
        }

    }

    public function showinfo(){
            $uid= $_GET['uid'];
            $info = array();
            $info = $this->user->getBmInfo($uid);
            $info['email'] = isset($info['email'])?$info['email']:"当前未认证邮箱";
            $info['mobile'] = isset($info['mobile'])?$info['mobile']:"当前未认证手机";
            $info['nikename'] = isset($info['nikename'])?$info['nikename']:"默认昵称";
            $whiteinfo = $this->auth->getWhiteInfo($uid);
            $WalletInfo = $this->wallet->getMyWalletInfo($uid);
            include $this->admin_tpl("task_bm_showinfo");
    }

    /**
     * 改变报名状态
     */
    public function ajax_status(){
        $uid=$_GET['uid'];
        if($uid>0){
            $data['ispass']=array('exp',' 1-ispass ');
            $this->bm->where('uid='.$uid)->save($data);
            $this->success('恭喜你，成功改变状态！');
        }else{
            $this->error('非法操作，请联系管理员！');
        }
    }

    /*
     * 漏洞列表
     * */
    public function ldlist(){
        $keyword = $_GET['keyword']?$_GET['keyword']:'';
        $tid = $_GET['task_id'];
        if(IS_POST){
            $where = array();
            $where['a.taskid'] = array('eq',$tid);
            if (isset($keyword) && $keyword) {
                $where["a.title|a.test_ip|b.email"] = array("like", "%" . $keyword . "%");
            }
            $pagenum = isset($_POST['page']) ? intval($_POST['page']) : 1;
            $rowsnum = isset($_POST['rows']) && (int)($_POST['rows']) != 0 ? intval($_POST['rows']) : PAGE_SIZE;
            $data = $this->bug->getBugList($where, $pagenum, $rowsnum);
            if(!$data['rows']){
                $data['rows'] = array();
            }
            echo json_encode($data);
        }else{
            include $this->admin_tpl('task_ldlist');
        }
    }

    //审核漏洞
    public function ldshenhe(){
          if($_POST){
            $taskid = $_POST['taskid'];
            $uid = $_POST['uid'];
            $where['bugid'] = array('eq', $_POST['bugid']);
            $status = $_POST['ispass'];
            $data['admin_1st_timestamp'] = time();
            $data['admin_last_timestamp'] = time();
            $data['admin_1st_level'] = isset($_POST['admin_1st_level'])?$_POST['admin_1st_level']:"";
            $data['admin_1st_feedback'] = isset($_POST['admin_1st_feedback'])?$_POST['admin_1st_feedback']:"";
            $message = '';
            $data['adminid_1st'] = $_SESSION['ADMIN_ID']; //管理员ID
            $data['adminid_last'] = $_SESSION['ADMIN_ID']; //管理员ID
            $data['admin_level'] = $_POST['admin_level'];
            $data['feedback'] = $_POST['feedback'];
            switch ($status) {
                case '1':
                    $data['ispass'] = 1;
                    $message = "平台初审通过！";
                    break;
                case "2":
                    $data['ispass'] = 2;
                    $message = "平台初审驳回！";
                    break;
                case '6':
                    $data['ispass'] = 6;
                    $message = "平台终审中！";
                    break;
                case '7':
                    $data['ispass'] = 7;
                    $message = "平台终审驳回！";
                    break;
                case '8':
                    $data['ispass'] = 8;
                    $message = "平台终审通过！";
                    $msg = $_POST['title'];
                    $type = 5;
                    $this->sendMes($uid,$type,$msg);
                    break;
            }
            $this->bug->where($where)->save($data);
            if(!empty($message)){
                showmessage($message, U('lists'), 2);
            }
        }else{
            $bugid= $_GET['bugid'];
            $info = $this->bug->getBugInfo($bugid);
            include $this->admin_tpl("task_bugshenhe");
        }
    }
}
