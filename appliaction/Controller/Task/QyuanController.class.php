<?php
/**
 * 请愿项目管理
 */
class QyuanController extends AdminBaseController{
    public function _initialize() {
        parent::_initialize();
        $this->db = model('task_qy');
        $this->bug = model('qy_bug');
        $this->user = model("User");
    }

    public function lists(){
        $keyword = $_GET['keyword']?$_GET['keyword']:'';
        $ispass = $_GET['ispass']?$_GET['ispass']:'';
        if (IS_POST) {
            $where = array();
            $_order = isset($_POST['order']) ? ($_POST['order']) : NULL;
            $_sort = isset($_POST['sort']) ? ($_POST['sort']) : NULL;
            if ($_order && $_sort) {
                $order[$_sort] = $_order;
            } else {
                $order['a.create_time'] = 'DESC';
            }
            if (isset($keyword) && $keyword) {
                $where["b.nikename|a.title|b.email"] = array("like", "%" . $keyword . "%");
            }
            $pagenum = isset($_POST['page']) ? intval($_POST['page']) : 1;
            $rowsnum = isset($_POST['rows']) && (int)($_POST['rows']) != 0 ? intval($_POST['rows']) : PAGE_SIZE;
            $data = $this->db->getQyList($where, $order, $pagenum, $rowsnum);
            if (!$data['rows']) {
                $data["rows"] = array();
            }
            echo json_encode($data);
        } else {
            include $this->admin_tpl("qyuan_lists");
        }
    }
    public function qyuaninfo(){
        $idx = $_GET['idx'];
        $info = $this->db->getInfoByidx($idx);
        $info['email'] = isset($info['email'])?$info['email']:"当前未认证邮箱";
        $info['nikename'] = isset($info['nikename'])?$info['nikename']:"默认昵称";
        include $this->admin_tpl("qyuan_info");
    }

    public function qypass(){
        $idx = $_GET['idx'];
        $data['ispass'] = $_GET['tid'];
        $this->db->where('idx='.$idx)->save($data);
        if($data['ispass']==1){
            showmessage('审核已通过', U('lists'), 2);
        }elseif($data['ispass']==2){
            showmessage('审核已驳回', U('lists'), 2);
        }

    }

    //漏洞列表
    public function ldlist(){
        $keyword = $_GET['keyword']?$_GET['keyword']:'';
        $idx = $_GET['idx'];
        if(IS_POST){
            $where = array();
            $where['idx'] = array('eq',$idx);
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
            include $this->admin_tpl('qyuan_ldlist');
        }
    }

    //漏洞审核查看
    public function ldshenhe(){
        if($_POST){
            $uid = $_POST['uid'];
            $where['idx'] = array('eq', $_POST['idx']);
            $status = $_POST['ispass'];
            $data['feeback'] = $_POST['feeback'];
            $data['updata_time'] = time();
            $message = '';
            $data['adminid'] = $_SESSION['ADMIN_ID']; //管理员ID
            switch ($status) {
                case '0':
                    $data['ispass'] = 0;
                    $message = "审核中！";
                    break;
                case '1':
                    $data['ispass'] = 1;
                    $message = "审核已通过！";
                    break;
                case "2":
                    $data['ispass'] = 2;
                    $message = "审核被驳回！";
                    break;
                case '3':
                    $data['ispass'] = 3;
                    $message = "厂商认证中！";
                    break;
                case '4':
                    $data['ispass'] = 4;
                    $message = "厂商通过！";
                    break;
                case '5':
                    $data['ispass'] = 5;
                    $message = "厂商驳回！";
                    break;
            }
            $this->bug->where($where)->save($data);
            if(!empty($message)){
                showmessage($message, U('lists'), 2);
            }
        }else{
            $idx = $_GET['idx'];
            $info = $this->bug->getBuginfoByidx($idx);
            include $this->admin_tpl("qyuan_bugshenhe");
        }
    }

    public function edit(){
        if(IS_POST){
            $where['idx'] = array('eq',$_POST['idx']);
            $_POST['update_time'] = time();
            $this->db->where($where)->save($_POST);
            showmessage('修改成功！', U('lists'), 2);
        }else{
            $idx = $_GET['idx'];
            $info = $this->db->getInfoByidx($idx);
            include $this->admin_tpl('qyuan_edit');
        }
    }
}