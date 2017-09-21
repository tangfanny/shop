<?php

/**
 * 用户提现管理
 */
class FinanceController extends AdminBaseController {

    public function _initialize() {
        parent::_initialize();
        $this->db = model('UserWalletCash');
    }

    public function lists() {
        $keyword = $_GET['keyword']?$_GET['keyword']:'';
        $status = $_GET['status']?$_GET['status']:'';
        if (IS_POST) {
            $con = array();
        switch ($status) {
            case '1':
                $con['b.status'] = 1; //申请中
                break;
            case '2':
                $con['b.status'] = 2; //审核中
                break;
            case '3':
                $con['b.status'] = 3; //出款
                break;
            case '4':
                $con['b.status'] = 4; //驳回
                break;
            default:
                break;
        }
        if (isset($keyword) && $keyword) {
            $con["b.cash_id|a.email|a.mobile"] = array("like", "%" . $keyword . "%");
        }
        $pagenum = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rowsnum = isset($_POST['rows']) && (int) ($_POST['rows']) != 0 ? intval($_POST['rows']) : PAGE_SIZE;
        $data['total'] = $this->db->alias("b")->field('b.id')->join('t_user as a on a.id = b.uid')->where($con)->count();
        $data['rows'] = $this->db->alias("b")
                ->field('b.id,b.cash_id,a.email,a.mobile,a.nikename,b.apply_time,b.check_time,b.cash_time,b.money,b.status')
                ->join('t_user as a on a.id = b.uid')
                ->order('b.apply_time desc')
                ->where($con)
                ->limit(($pagenum - 1) * $rowsnum . ',' . $rowsnum)
                ->select();
        if (!$data['rows']) {
            $data["rows"] = array();
        }
            echo json_encode($data);
        } else {
            include $this->admin_tpl("cash_list");
        }
    }

    public function edit() {
        if (IS_POST) {
            $id = (int) $_POST['id'];
            $res = $this->db->CashAudit($_POST);
            if ($res == 1) {
                showmessage('恭喜你，审核成功！', U('lists'), 2);
            } else {
                showmessage('非法操作，请联系管理员！');
            }
        } else {
            $cid = $_GET['id'];
            $info = $this->db->getUserCashInfo($cid);
            include $this->admin_tpl("cash_edit");
        }
    }

}

?>
