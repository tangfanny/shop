<?php
/**
 *      [Haidao] (C)2013-2099 Dmibox Science and technology co., LTD.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      http://www.haidao.la
 *      tel:400-600-2042
 */
libfile('notify_abstract');
class email extends notify_abstract {
	public $order_info = array();
	public $send = '';
	public function __construct($param) {
		if (!empty($param['config'])) $this->set_config($param['config']);
		$this->param = $param;
		$this->order_info = model('order')->where(array('order_sn' => $param['param']['order_sn']))->find();
		$this->template = model('notify_template')->find($param['param']['id']);
		$this->template = json_decode($this->template['template'],TRUE);
		$this->email = model('user')->where(array('id'=>$this->order_info['user_id']))->getfield('email');
		$this->username=model('user')->where(array('id'=>$this->order_info['user_id']))->getfield('username');
		$this->$param['param']['id']($param);
	}

	/* 确认订单 */
	public function n_confirm_order($param) {
		$content=dstripslashes($this->template['email']);
		$content=str_replace('{order}',$this->order_info['order_sn'], $content);
		$content=str_replace('{user}',$this->username, $content);
		$content=str_replace('{site_name}',C('site_name'), $content);
		$message=array();
		$message=array(
			'to' => $this->email,
			'sender'=> $param['config']['mail_formmail'],
			'subject' => '来自'.C('site_name').'的邮件@'.date('Y-m-d H:i:s',  time()),
			'body' => $content,
			'mailtype'=>'HTML'
			);
		$this->send($param,$message);
	}
    /* 订单发货 */	
	public function n_order_delivery($param) {
		$content=dstripslashes($this->template['email']);
		$content=str_replace('{order}',$this->order_info['order_sn'], $content);
		$content=str_replace('{user}',$this->username, $content);
		$content=str_replace('{site_name}',C('site_name'), $content);
		$message=array();
		$message=array(
			'to' => $this->email,
			'sender'=> $param['config']['mail_formmail'],
			'subject' => '来自'.C('site_name').'的邮件@'.date('Y-m-d H:i:s',  time()),
			'body' => $content,
			'mailtype'=>'HTML'
			);
			$this->send($param,$message);
	}

	/* 下单成功 */
	public function n_order_success($param) {
	    $content=dstripslashes($this->template['email']);
		$content=str_replace('{order}',$this->order_info['order_sn'], $content);
		$content=str_replace('{pay_style}',(($this->order_info['pay_code'] == 0) ? '在线支付' : '货到付款'), $content);
		$content=str_replace('{user}',$this->username, $content);
		$content=str_replace('{site_name}',C('site_name'), $content);
		$message=array();
		$message=array(
			'to' => $this->email,
			'sender'=> $param['config']['mail_formmail'],
			'subject' => '来自'.C('site_name').'的邮件@'.date('Y-m-d H:i:s',  time()),
			'body' => $content,
			'mailtype'=>'HTML'
			);
			$this->send($param,$message);
	}
    /* 付款成功 */
	public function n_pay_success($param) {
	    $content=dstripslashes($this->template['email']);
		$content=str_replace('{order}',$this->order_info['order_sn'], $content);
		$content=str_replace('{user}',$this->username, $content);
		$content=str_replace('{site_name}',C('site_name'), $content);
		$message=array();
		$message=array(
			'to' => $this->email,
			'sender'=> $param['config']['mail_formmail'],
			'subject' => '来自'.C('site_name').'的邮件@'.date('Y-m-d H:i:s',  time()),
			'body' => $content,
			'mailtype'=>'HTML'
			);
			$this->send($param,$message);
	}

	/* 充值成功 */
	public function n_recharge_success($param) {
		$pay_info = model('pay')->where(array('trade_sn' => $param['param']['order_sn']))->find();
	    $content=dstripslashes($this->template['email']);
		$content=str_replace('{total_fee}',$pay_info['total_fee'], $content);
		$content=str_replace('{user}',getMemberfield($this->param['param']['user_id'],'username'), $content);
		$content=str_replace('{site_name}',C('site_name'), $content);
		$message=array();
		$message=array(
			'to' => getMemberfield($param['param']['user_id'],'email'),
			'sender'=> $param['config']['mail_formmail'],
			'subject' => '来自'.C('site_name').'的邮件@'.date('Y-m-d H:i:s',  time()),
			'body' => $content,
			'mailtype'=>'HTML'
			);
			$this->send($param,$message);
	}

	/* 余额变动 */
	public function n_money_change($param) {
		$money_log = model('user_moneylog')->find($this->param['param']['log_id']);
		$content=dstripslashes($this->template['email']);
		$content=str_replace('{money}',getMemberfield($this->param['param']['user_id'],'user_money'), $content);
		$content=str_replace('{msg}',$money_log['msg'], $content);
		$content=str_replace('{user}',getMemberfield($this->param['param']['user_id'],'username'), $content);
		$content=str_replace('{site_name}',C('site_name'), $content);
		$message=array();
		$message=array(
			'to' => getMemberfield($param['param']['user_id'],'email'),
			'sender'=> $param['config']['mail_formmail'],
			'subject' => '来自'.C('site_name').'的邮件@'.date('Y-m-d H:i:s',  time()),
			'body' => $content,
			'mailtype'=>'HTML'
			);
			$this->send($param,$message);
	}
	/* 注册成功 */
	public function n_reg_success($param) {
		$content=dstripslashes($this->template['email']);
		$content=str_replace('{user}',getMemberfield($param['param']['user_id'],'username'), $content);
		$content=str_replace('{site_name}',C('site_name'), $content);
		$message=array();
		$message=array(
			'to' => getMemberfield($param['param']['user_id'],'email'),
			'sender'=> $param['config']['mail_formmail'],
			'subject' => '来自'.C('site_name').'的邮件@'.date('Y-m-d H:i:s',  time()),
			'body' => $content,
			'mailtype'=>'HTML'
			);
			$this->send($param,$message);
	}
	
	/* 执行发送模版信息 */
	public function send($param,$message) {
		libfile('Smtp');
		$smtp = new Smtp($param['config']['mail_smtpserver'],$param['config']['mail_smtpport'],$param['config']['mail_auth'],$param['config']['mail_mailuser'],$param['config']['mail_mailpass'],$param['config']['mail_formmail']);
		$send = $smtp->sendmail($message['to'],$message['sender'],$message['subject'],$message['body'],$message['mailtype']);
	}
}

