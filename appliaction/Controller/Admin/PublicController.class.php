<?php
class PublicController extends BaseController {
    public function _initialize() {
        parent::_initialize();
        $this->db = model('AdminUser');
        $this->sms=model("SendmsgLog");
    }

    public function login() {


    	if(session('?ADMIN_ID')){
    		$this->redirect(U('Index/index'));
    	}
        if (IS_POST) {
            if (strtolower(I('userverify')) != session('verify')) {
                showmessage('验证码错误！');
            }
            //和数据库校对
            $username = $_GET['username'];
            $userpass = $_GET['userpass'];
            $code = $_GET['code'];
            if (C('SentVerifyCode.sent')==1) {
                $result = $this->db->Safelogin($username,$userpass,$code);
            }else{
                $result = $this->db->login($username, $userpass);
            }
            if (!$result) {
                showmessage($this->db->getError());
            } else {
            	/* 检查缓存 */
				R('Admin/Cache/check_cache');
                showmessage('后台登录成功', U('Index/index'), 1);
            }
        } else {
            if (C('SentVerifyCode.sent')==1) {
                include $this->admin_tpl('login2');
            }else{
                include $this->admin_tpl('login');
            }
        }
    }

    public function SendCode() {
        $username = I('username');
        if(!preg_match("/^[A-Za-z0-9]+$/",$username)){
            echo 0;exit();
        }
        $result = $this->db->getMobileByUser($username);
        if (!$result) {
            echo 0;exit();
        }
        $data = sendMsgByMobile($result['phone'],$type=1);
        $res =  $this->sms->add_sendsmglog($result['phone']);
        if ($data) {
            echo 1;
        }else{
            echo 0;
        }

    }


    /**
     * 验证码
     */
    public function verify() {
        libfile('Verify');
        ob_clean();
        $verify = new Verify($width=90,$height=24,$fontSize=14);
        $verify->doimage();
    }

    /**
     * 退出登录
     */
    public function logout() {
        $this->db->logout();
        $this->redirect(U('Public/login'));
    }

    /**
     * 清除缓存
     */
    public function clearCache(){
        clearCache();
		showmessage('更新缓存成功', '', 1);
    }
}
