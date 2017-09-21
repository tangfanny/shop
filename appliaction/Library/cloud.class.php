<?php
class cloud
{
    protected $_api = 'http://www.haidao.la/api.php?';
    protected $_params = array();
    protected $error = '';
    
    public function __construct() {
        $this->_params['format'] = 'json';
        $this->_params['charset'] = CHARSET;
        $this->_params['timestamp'] = NOW_TIME;
        $this->_params['site'] = $this->_getApiSite();
    }

    /**
     * 获取用户信息
     * @return boolean
     */
    public function getAccountInfo() {
        $_account = getcache('account', 'cloud');
        if($_account) {
            return authcode($_account, 'DECODE');
        }
        return FALSE;
    }
    
    /**
     * 登陆远程用户
     * @param type $account
     * @param type $password
     */
    public function getMemberLogin($account, $password) {
        $this->_params['method'] = 'api.member.login';
        $this->_params['account'] = $account;
        $this->_params['password'] = $password;
        $this->_params['sign'] = $this->create_sign();
        $result = $this->getHttpResponse($this->_api, $this->_params);
        return $this->_response($result);
    }
    
    /**
     * 组装数据返回格式
     * @param type $result
     * @return type
     */
    private function _response($result) {
        if(!$result) {
            return array('code' => -10000, 'msg' => '接口网络异常，请稍后。');
        } else {
            return json_decode($result, TRUE);
        }
    }
    
    /**
     * 获取接口返回值
     * @param type $url
     * @param type $params
     * @return type
     */
    private function getHttpResponse($url, $params) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//SSL证书认证
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);//严格认证
        curl_setopt($curl, CURLOPT_HEADER, 0 ); // 过滤HTTP头
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
        curl_setopt($curl,CURLOPT_POST, FALSE); // post传输数据
        curl_setopt($curl,CURLOPT_POSTFIELDS,$params);// post传输数据
        $responseText = curl_exec($curl);
        return $responseText;
    }
    
    /**
     * 创建接口签名
     * @return type
     */
    private function create_sign() {
        $array = $this->_params;
        ksort($array,SORT_STRING);
        $arg  = "";
        while (list ($key, $val) = each ($array)) {
            $arg.=$key."=".$val."&";
        }
        $arg = substr($arg,0,count($arg)-2);
        return strtolower(md5($arg.$array['timestamp']));        
    }
    
    private function _getApiSite() {
        $_site = array();
        $_site['site_name'] = C('site_name');
        $_site['site_url'] = $_SERVER['HTTP_HOST'];
        $_site['install_ip'] = get_client_ip();
        $_site['last_var'] = C('VERSION');
        return base64_encode(serialize($_site));
    }
    
}
/* end of file cloud.class.php */
/* location: ./appliaction./Library/cloud.class.php */