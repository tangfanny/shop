<?php

class AdminUserModel extends SystemModel {

    //自动完成
    protected $_auto = array(
        array('add_time', NOW_TIME, 1),
        array('last_ip', 'get_client_ip', 3, 'function'), // 对password字段在新增的时候使md5函数处理
        array('password', 'md5', 3, 'function'), // 对password字段在新增的时候使md5函数处理
    );
    //自动验证
    protected $_validate = array(
        array('name', '2,10', '昵称长度为4-10个字符', self::EXISTS_VALIDATE, 'length'),
        array('name', '', '帐号名称已经存在！', 0, 'unique'),
        array('password', 'require', '密码不能为空'), //用户名被占用
    );

    /**
     * 登录指定用户
     * @param  integer $uid 用户ID
     * @return boolean	  ture-登录成功，false-登录失败
     */
    public function login($username, $password) {
        if (empty($username) || !preg_match("/^[A-Za-z0-9]+$/", $username)) {
            $this->error = '用户名或密码错误';
        }
        if (empty($password)) {
            $this->error = '用户名或密码错误';
        }
        $sqlmap = array();
        $sqlmap['name'] = $username;
        //$sqlmap['password'] = md5($password);
        /* 检测是否在当前应用注册 */
        $user = $this->where($sqlmap)->find($uid, $valid);
        if (!$user || 1 != $user['status']) {
            $this->error = '用户不存在或已被禁用！'; //应用级别禁用*/
            return false;
        }
        if ($user['password'] != md5($password . $user['valid'])) {
            $this->error = '用户名或密码错误'; //应用级别禁用*/
            return false;
        }
        session('ADMIN_ID', $user['id']);
        session('ADMIN_UNAME', $user['name']);
        session('ADMIN_EMAIL', $user['email']);
        //记录IP和次数
        /* 更新登录信息 */
        $data = array(
            'id' => $user['id'],
            'login_num' => array('exp', '`login_num`+1'),
            'last_login' => NOW_TIME,
            'last_ip' => get_client_ip(0),
        );
        $this->save($data);

        return true;
    }

    /**
     * 短信验证码安全登录
     * @param  $username,$password,$code
     * @return boolean	ture 成功,false 失败
     */
    public function Safelogin($username, $password, $code) {
        if (empty($username) || !preg_match("/^[A-Za-z0-9]+$/", $username)) {
            $this->error = '用户名字不存在！';
        }
        if (empty($password)) {
            $this->error = '密码错误或为空！';
        }
        if (empty($code)) {
            $this->error = '验证码错误！';
        }
        $sqlmap = array();
        $sqlmap['name'] = $username;
        /* 检测是否在当前应用注册 */
        $user = $this->field('id,name,email,valid,password,status,phone')->where($sqlmap)->find();
        if (!$user || 1 != $user['status']) {
            $this->error = '用户名错误！';
            return false;
        }
        if ($user['password'] != md5($password . $user['valid'])) {
            $this->error = '密码错误！';
            return false;
        }
        $redis = new Redis();
        $redis->connect(C('redis_config.host'), C('redis_config.port'));
        $redis->auth(C('redis_config.password'));
        $mobile = $user['phone'];
        $code2 = $redis->get($mobile . "_verify_code");
        if ($code != $code2) {
            $this->error = '验证码错误！';
            return false;
        }
        session('ADMIN_ID', $user['id']);
        session('ADMIN_UNAME', $user['name']);
        session('ADMIN_EMAIL', $user['email']);
        //记录IP和次数
        /* 更新登录信息 */
        $data = array(
            'id' => $user['id'],
            'login_num' => array('exp', '`login_num`+1'),
            'last_login' => NOW_TIME,
            'last_ip' => get_client_ip(0),
        );
        $this->save($data);

        return true;
    }

    /**
     * 注销当前用户
     * @return void
     */
    public function logout() {
        session(null);
        action_log('user_login', 'admin', $uid, $uid);
    }

    /**
     * 自动登录用户
     * @param  integer $user 用户信息数组
     */
    private function autoLogin($user) {
        /* 更新登录信息 */
        $data = array(
            'id' => $user['id'],
            'login_num' => array('exp', '`login_num`+1'),
            'last_login' => NOW_TIME,
            'last_ip' => get_client_ip(1),
        );
        $this->save($data);
        /* 记录登录SESSION和COOKIES */
        $auth = array(
            'uid' => $user['id'],
            'username' => $user['name'],
            'last_login_time' => $user['last_login'],
        );
        session('user_auth', $auth);
        session('user_auth_sign', data_auth_sign($auth));
    }

    public function getNickName($uid) {
        return $this->where(array('uid' => (int) $uid))->getField('nickname');
    }

    //获取管理员手机号
    public function getMobileByUser($username) {
        return $this->field('phone')->where(array('name' => $username))->find();
    }

}
