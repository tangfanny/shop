<?php
/**
 * 线下充值管理
 */
class UserWalletPrepayModel extends MysqlModel {
	
	public function getUserPrepayList($con,$order,$pagenum,$rowsnum){
		$data = array();
		$con['b.type'] = array(2,3,"or");
		$data['total'] = $this->alias("b")->field('b.id')->join('t_user as a on a.id = b.uid')->where($con)->count();
		 $data['rows'] = $this->alias("b")
		->field('b.id,b.uid,b.trade_no,a.email,a.mobile,a.nikename,b.ordtotal_fee,b.check_time,b.prepay_suc,b.create_time')
		->join('t_user as a on a.id = b.uid')
		->where($con)
	        ->order($order)
		->limit(($pagenum-1)*$rowsnum.','.$rowsnum)
		->select();
	    return $data;
	}
        

	public function getUserCashInfo($cid) {
		$cash_info = $this->alias("b")
				->field('b.id,b.uid,b.pay_images,c.balance,c.prepaid,c.expense,b.ordtotal_fee,b.ordsubject,b.ordbody,b.create_time,b.check_time,b.prepay_suc,b.trade_no,b.refusal')
				->join('t_user as a on a.id = b.uid')
				->join('t_user_wallet as c on c.uid = b.uid')
				->join('t_user_wallet_account as d on d.uid = b.uid')
				->where(array('b.id' => $cid))
				->find();
		return $cash_info;
	}
}
