<?php

/**
 * 
 * user表模型
 * @author wj
 * @date 2014-10-14
 *
 */
class UserModel extends MysqlModel {

    //自动完成

    protected $_auto = array(
        array('reg_time', 'time', 1, 'function'), //新增数据是插入注册时间
            //array('password', 'md5', 1, 'function'), //插入时加密密码
    );
//    protected $connection = array(
//        'db_type'  => 'mysql',
//        'db_user'  => 'root',
//        'db_pwd'   => '1234',
//        'db_host'  => 'localhost',
//        'db_port'  => '3306',
//        'db_name'  => 'thinkphp'
//    );
    //自动验证
    protected $_validate = array(
        array('username', 'require', '用户名必须！'),
        array('password', 'require', '密码必须！'),
        array('userpassword2', 'require', '确认密码必须填写！'),
        array('userpassword2', 'password', '确认密码不正确', 0, 'confirm'),
        array('mobile_phone', 'require', '手机必须填写！'),
        array('mobile_phone', '/^(1[0-9][0-9])\d{8}$/', '手机号格式错误！', '0', 'regex', 1),
        array('mobile_phone', '', '手机已经存在！', 2, 'unique', 3),
        array('email', 'email', '邮箱格式错误！'),
        array('username', '', '用户名已经存在！', 0, 'unique', 1),
        array('email', '', '邮箱已经存在！', 2, 'unique', 3),
    );

    /**
     * ajax验证字段
     */
    function checkKey($val, $key) {
        $map[$key] = array(array('eq', $val));
        $res = $this->where($map)->count();
        if ($res > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 
     * 获取用户详细信息
     * @param  $uid 用户id
     * @author wj
     * @date 2014-10-14
     */
    public function getUserInfo($uid) {
        $map['id'] = array('eq', $uid);
        $list = $this->relation(true)->where($map)->find();
        $list['in']['c'] = D('Order')->getCommentNum($uid, 1); //未评论数
        $list['in']['notPay'] = D('Order')->getNOpayNum($uid); //未支付条数
        $list['in']['notGoods'] = D('Order')->getNOgoodsNum($uid); //未收货条数getDeliveryNum
        $list['in']['delivery'] = D('Order')->getDeliveryNum($uid); //未收货条数getDeliveryNum
        return $list;
    }

    /**
     * 
     * 通过地址编号获取城市名称
     * @param  $id 地址编号
     * @author wj
     * @date 2014-10-14
     */
    public function getCityByid($id) {
        $list = model('region')->field('area_name')->where(array('area_id' => $id))->find();
        return $list['area_name'];
    }

    public function getTest() {


        $data = $this->where("id=645491049")->select();
//        $data = $this->where(array('id'=>'645491049'))->select();

        return $data;
    }

    /**
     * 
     * 检查密码是否争取
     * @param $password 密码
     * @param $uid 用户id
     * @author wj
     * @date 2014-10-20
     */
    public function chekPassword($uid, $password) {
        $map['id'] = array('eq', $uid);
        $valid = $this->getFieldById($uid, 'valid');
        $map['password'] = array('eq', md5($valid . $password));
        $r = $this->where($map)->find();
        if (empty($r)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 
     * 检查当前用户登录记录的login_cookie和当前浏览器的cookie是否一致 - 来判断该账号在其他地方是否登录 
     * @param $uid 用户id
     * @author wj
     * @date 2014-10-21 
     */
    public function checkSession($uid) {
        $map['id'] = array('eq', $uid);
        $r = $this->field('last_session')->where($map)->find();
        if (session_id() == $r['last_session'] || session_id() == '') {
            return true;
        } else {
            return false;
        }
    }

    /*
     * 判断名称是否唯一
     */

    function unique_name($user_name, $user_id = 0) {
        if ($user_id < 1 || empty($user_name))
            return FALSE;
        $sqlmap = array();
        $sqlmap['id'] = array("NEQ", $user_id);
        $sqlmap['username'] = $user_name;
        if (!$this->where($sqlmap)->count()) {
            return TRUE;
        }
        return FALSE;
    }

    /* ========== 后台 ========== */

    public function getList($map) {
        $count = $this->where($map)->count();
        libfile('Page');
        $pagesize = $_GET['pagesize'];
        $pagesize = $pagesize ? $pagesize : getconfig('page_num');
        $page = new Page($count, $pagesize);
        $list['list'] = $this->where($map)->limit($page->firstRow . ',' . $page->listRows)->select();
        $list['page'] = $page->show();
        return $list;
    }

    public function push_userids($param) {
        $keyword = $param['keyword'];
        $group_id = $param['group_id'];
        $ordermap['dateline'] = $param['order_time'];
        $ordermap['cat_ids'] = $param['cat_ids'];
        $ordermap['brand_id'] = $param['brand_id'];
//        $User = M('User', DB_PREFIX, DB_URL); //连接其他数据库接口
        foreach ($ordermap as $k => $v) {
            if ($v == 0)
                unset($ordermap[$k]);
        }

        if (!empty($ordermap)) {
            $ordermap['_string'] = "1 = 1 ";
        }

        //分类
//		if($ordermap['cat_ids']){
//			//子级分类
//			$cat_ids = D('Admin/Category')->getChild($ordermap['cat_ids']);
//			$_join = array("find_in_set('".$ordermap['cat_ids']."',cat_ids)");
//			foreach ($cat_ids as $key => $value) {
//				$_join[] = "find_in_set('{$value}',cat_ids)";
//			}
//			$join_str = implode(' OR ', $_join);
//			if(isset($ordermap['_string'])){
//				$ordermap['_string'] .= " AND (".$join_str.")";
//			}else{
//				$ordermap['_string'] = $join_str;
//			}
//			unset ($ordermap['cat_ids']);
//		}
        //购买时间
//		if($ordermap['dateline']){
//			$ordermap['_string'] .= " AND DATE_SUB(CURDATE(), INTERVAL {$ordermap['dateline']} DAY) <= date(FROM_UNIXTIME(dateline)) ";
//			unset ($ordermap['dateline']);
//		}
        //搜索会员
        if (isset($keyword) && $keyword) {
            $field = "id,email,mobile,nikename";
            $where['status'] = array('gt', -1);
            $where['_string'] = " email = '{$keyword}' OR mobile = '{$keyword}' ";
            $info = $this->field($field)->where($where)->find();
//            $info = $this->get_user_info($field,$where);
//			$info = $this -> field($field) -> where($where) -> find();
        }
        //会员等级
//		if (isset($group_id)) {
//			unset($where);
//			if ($group_id) {
//				$where['group_id'] = $group_id;
//			}
//			$info = $this -> where($where) -> order("id ASC") -> getField("id", true);
//		}
        //查询全部用户按照7一天进行统计
        if (isset($group_id)) {
            switch ($group_id) {
                case 7:
                    $stime = time() - 3600 * 24 * $group_id;
                    break;
                case 30:
                    $stime = time() - 3600 * 24 * $group_id;
                    break;
                case 90:
                    $stime = time() - 3600 * 24 * $group_id;
                    break;
                case 180:
                    $stime = time() - 3600 * 24 * $group_id;
                    break;
                case 365:
                    $stime = time() - 3600 * 24 * $group_id;
                    break;
                case 0:
                    $stime = strtotime($param['start']);
                    $etime = strtotime($param['end']);
                    break;
                default:
                    echo 'sorry none is the same!';
                    break;
            }
            $etime = time();
            $where[]["create_time"] = array(array("egt", $stime), array("elt", $etime));
            $info = $User->where($where)->order("id asc")->getField("id", true);
        }

        if (isset($param["order_count"])) {
            if ($param["order_count"] && $param["order_count_num"]) {
                switch ($param["order_count"]) {
                    case 1:
                        $order_flag = ">";
                        break;
                    case 2:
                        $order_flag = "<";
                        break;
                    default:
                        $order_flag = "=";
                        break;
                }
                $user_idArr = $this->query("select user_id as id from t_order group by user_id HAVING COUNT(*)" . $order_flag . $param["order_count_num"]);
                $user_idArrs = array();
                foreach ($user_idArr as $key => $value) {
                    $user_idArrs[$key] = $value["id"];
                }
                $info = array_intersect($info, $user_idArrs);
            }
        }



        if (isset($param["order_moyen"])) {
            if ($param["order_moyen"] && $param["order_moyen_sum"]) {
                switch ($param["order_moyen"]) {
                    case 1:
                        $order_flag = ">";
                        break;
                    case 2:
                        $order_flag = "<";
                        break;
                    default:
                        $order_flag = "=";
                        break;
                }
                $user_idArr = $this->query("select user_id as id from t_order group by user_id HAVING SUM(payable_amount)" . $order_flag . $param["order_moyen_sum"]);
                $user_idArrs = array();
                foreach ($user_idArr as $key => $value) {
                    $user_idArrs[$key] = $value["id"];
                }
                $info = array_intersect($info, $user_idArrs);
            }
        }


//		if(!empty($ordermap)){
//			$user_idArr = D('Admin/OrderGoods')->where($ordermap)->getField("user_id",true);
//			$user_idArr = array_unique($user_idArr);	
//			$info = array_intersect($info, $user_idArr);	//取交集
//		}

        return $info;
    }

    /**
     * 查询用户记录数，用于优惠券派发
     */
//    public function get_user_info($field,$where){
//        return $this->field($field)->where($where)->find();
//
//    }

    /**
     * 查询用户条数
     * @param type $sqlmap 检索条件
     * @param type $_order 排序
     * @param type $pagenum 开始页面
     * @param type $rowsnum 一页显示多少条 
     * @return type list记录数
     */
    public function getVerifyAll($sqlmap, $_order, $pagenum, $rowsnum, $join, $field) {
        $data = $this->alias("a")->field($field)->join($join)->where($sqlmap)->limit(($pagenum - 1) * $rowsnum . ',' . $rowsnum)->order($_order)->select();
        return $data;
    }

    /**
     * 统计用户相关信息
     * @param type $sqlmap 检索条件
     * @return type 返回总记录数
     */
    public function getVerifyCount($sqlmap, $join) {
        $data = $this->alias("a")->join($join)->where($sqlmap)->count();
        return $data;
    }

    /**
     * 通过用户ID查询用户数据
     * @param type $user_id 用户id
     * @return $data 相关用户数据
     */
    public function getUserByUserId($user_id) {
        $param["id"] = $user_id;
        $data = $this->where($param)->find();
        return $data;
    }

    /**
     * 修改用户积分
     * @param type $user_id 用户id
     * @param type $integral 要修改的积分
     * @return type 成返回主要ID，失败返回0
     */
    public function updateIntegralUserByUserId($user_id, $integral, $rank) {
        $param["id"] = $user_id;
        $colum["integral"] = $integral;
        $colum["rank"] = $rank;
        $colum["update_time"] = time();
        $data = $this->where($param)->save($colum);
        return $data;
    }

    /**
     * 
     * 通过手机号查询用户相关记录数
     * @param type $mobile 用户注册手机号
     * @return type 相应计算结果集合
     */
    public function get_user_mobile($mobile) {
        $param["mobile"] = $mobile;
        return $this->where($param)->find();
    }

    /**
     * 获取用户白帽子相关信息
     * @param type $uid
     * @return type
     */
    public function get_user_whitehat_by_id($uid) {
        $field = "a.`nikename`,a.id,a.`email`,a.`mobile`,a.`create_time` AS acreate_time,tuw.create_time,tuw.`check_time`,tuw.`status`,tuw.`refusal`,tua.`name`,tua.`identity`,tua.`identity_image1`";
        $join = "LEFT JOIN __USER_AUTH__ as tua ON  a.id= tua.uid
                     LEFT JOIN __USER_WHITEHAT__ AS tuw ON a.id = tuw.uid";
        $param["a.id"] = $uid;
        //  $data = $this->alias("a")->field($field)->join($join)->where($sqlmap)->limit(($pagenum-1)*$rowsnum.','.$rowsnum)->order($_order)->select();
        $data = $this->alias("a")->field($field)->join($join)->where($param)->find();
        return $data;
    }

    /**
     * 销售认证
     * @return type
     */
    public function get_user_sales_auth_by_id($uid) {
        $field = "a.`nikename`,a.id,a.`email`,a.`mobile`,a.`create_time` AS acreate_time,tuw.create_time,tuw.`check_time`,tuw.`status`,tuw.`refusal`,tua.`name`,tua.`identity`,tua.`identity_image1`";
        $join = "LEFT JOIN __USER_AUTH__ as tua ON  a.id= tua.uid
                     LEFT JOIN __USER_SALES__ AS tuw ON a.id = tuw.uid";
        $param["a.id"] = $uid;
        //  $data = $this->alias("a")->field($field)->join($join)->where($sqlmap)->limit(($pagenum-1)*$rowsnum.','.$rowsnum)->order($_order)->select();
        $data = $this->alias("a")->field($field)->join($join)->where($param)->find();
        return $data;
    }

    /**
     * 认证企业
     * @param type $uid
     * @return type
     */
    public function get_user_company_auth_by_id($uid) {
        $field = "a.`nikename`,a.id,a.`email`,a.`mobile`,a.`create_time` AS acreate_time,tuw.*";
        $join = " LEFT JOIN __USER_COMPANY__ AS tuw ON a.id = tuw.uid";
        $param["a.id"] = $uid;
        //  $data = $this->alias("a")->field($field)->join($join)->where($sqlmap)->limit(($pagenum-1)*$rowsnum.','.$rowsnum)->order($_order)->select();
        $data = $this->alias("a")->field($field)->join($join)->where($param)->find();
        return $data;
    }

    public function update_user_verify_by_id($id, $status, $refusal) {
        $this->startTrans();
        $user_auth = D("UserAuth");
        $user_auth_flag = $user_auth->update_user_auth_by_uid($id, $status);
        if ($user_auth_flag) {
            $this->commit();
        } else {
            $this->rollback();
        }
        $user_whitehat = D("UserWhitehat");
        $user_whitehat_flag = $user_whitehat->update_user_whitehat_by_id($id, $status, $refusal);
        if ($user_whitehat_flag) {
            $this->commit();
        } else {
            $this->rollback();
        }
        if ($status != 3) {
            $param["id"] = $id;
            $data["is_whitehat_auth"] = 1;
            $this->where($param)->data($data)->save();
        }
    }

    public function update_user_company_verify($id, $status, $refusal) {
        $this->startTrans();
        $user_whitehat = D("UserCompany");
        $user_whitehat_flag = $user_whitehat->update_user_company_by_id($id, $status, $refusal);
        if ($user_whitehat_flag) {
            $this->commit();
        } else {
            $this->rollback();
        }
        if ($status != 3) {
            $param["id"] = $id;
            $data["is_company_auth"] = 1;
            $this->where($param)->data($data)->save();
        }
    }

    public function update_user_saler_verify($id, $status, $refusal) {
        $this->startTrans();
        $user_auth = D("UserAuth");
        $user_auth_flag = $user_auth->update_user_auth_by_uid($id, $status);
        if ($user_auth_flag) {
            $this->commit();
        } else {
            $this->rollback();
        }
        $user_whitehat = D("UserSales");
        $user_whitehat_flag = $user_whitehat->update_user_sales_by_id($id, $status, $refusal);
        if ($user_whitehat_flag) {
            $this->commit();
        } else {
            $this->rollback();
        }
        if ($status != 3) {
            $param["id"] = $id;
            $data["is_saler_auth"] = 1;
            $this->where($param)->data($data)->save();
        }
    }

    public function get_user_info($id) {
        $rs = $this->field('nikename, mobile')->where('id=' . $id)->select();
        return $rs[0];
    }
    
    public function safety_adviser_save($where,$data){
        return $this->where($where)->data($data)->save();
    }

    /*
     * 众测会员信息
     * */
    public function  getBmInfo($uid){
        $field = "email,mobile,nikename,from_unixtime(create_time,'%Y-%m-%d %H:%i') as time,avatars";
        return $this->field($field)->where('id='.$uid)->find();
    }
}

?>
