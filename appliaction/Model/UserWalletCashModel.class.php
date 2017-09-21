<?php

/**
 * 用户提现管理
 */
class UserWalletCashModel extends MysqlModel {

    public function getUserCashInfo($cid) {

        $cash_info = $this->alias("b")
                ->field('b.*,a.email,a.mobile,a.nikename,c.balance,c.prepaid,c.income,c.expense,d.account_type,d.account_user,d.account_id,d.account_address')
                ->join('t_user as a on a.id = b.uid')
                ->join('t_user_wallet as c on c.uid = b.uid')
                ->join('t_user_wallet_account as d on d.uid = b.uid')
                ->where(array('b.id' => $cid))
                ->find();
        return $cash_info;
    }

    public function CashAudit($arr) {
        $result = 0;
        $data = array();
        $data['id'] = $arr['id'];
        $data['status'] = $arr['status'];
        if ($arr['status'] == 4) {
            $data['check_time'] = time();
            $data['refusal'] = $arr['refusal'];
            $this->startTrans();
            $res = $this->save($data);
            $con['balance'] = $arr['balance'] + $arr['money'];
            $con['expense'] = $arr['expense'] - $arr['money'];
            $con['uid'] = $arr['uid'];
            $con['update_time'] = time();
            $res2 = D('UserWallet')->updateWallet($con);
            if ($res && $res2) {
                $this->commit();
                $result = 1;
            } else {
                $this->rollback();
            }
        } else {
            if (empty($arr['check_time'])) {
                $data['check_time'] = time();
            }
            if ($arr['status'] == 3) {  //如果是出款，保留其审核时间不修改。并增加出款时间。
                $data['cash_time'] = time();
            }
            if ($this->save($data)) {
                $result = 1;
            }
            if ($arr['status'] == 3 && $result == 1) {  //短信提示用户提现成功
                $type = 10;
                $msg['username'] = isset($arr['nikename']) ? $arr['nikename'] : " ";
                $msg['money'] = $arr['money'];
                sendPublicMsgByMobile($arr['mobile'], $type, $msg);
            }
        }
        return $result;
    }

}
