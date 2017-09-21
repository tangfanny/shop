<?php

/**
 * 用户审核功能
 *
 * @author Administrator
 */
class VerifyController extends AdminBaseController {

    /**
     * 开始执行方法方法给要执行的方法初始化
     */
    public function _initialize() {
        parent::_initialize();
        $this->db = model("user");
        $this->user_wallet = model("User_Wallet"); //认证白帽子
        $this->user_auth = model("User_Auth"); //基本身份信息表
        $this->saler = model("UserSales");
        $this->child = model("InviteChild");
        $this->parent = model("InviteParent");
        $this->Integral = model("Integral"); //积分日志表
        $this->UserGroup = model("UserGroup"); //用户分组等级表
        $this->Rebate = model("Rebate");
        $this->SaleRankExc = model("SaleRankExc"); //获取消费积分返利比
        $this->SaleIntegral = model("SaleIntegral"); //积分分成关系表
        $this->SaleLogs = model("SaleLogs"); //积分日志表
    }

    /**
     * 获取列表信息
     */
    public function lists() {
        $type = isset($_GET['type']) ? $_GET['type'] : -1; //获取类型 主要分为-1为全部类型 1为白帽子 2为企业 3为销售主要用于区分各个行业状态
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : ''; //检索字段主要可以收索用户名、电子邮件、电话
        $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : 0; //用户Id
        if (IS_POST) {
            $sqlmap = array();
            $_order = isset($_POST['order']) ? ($_POST['order']) : NULL;
            $_sort = isset($_POST['sort']) ? ($_POST['sort']) : NULL;
            if ($_order && $_sort) {
                $order[$_sort] = $_order;
            } else {
                $order['a.create_time'] = 'DESC';
            }
            if (isset($user_id) && $user_id > 0) {
                $sqlmap['a.id'] = $user_id;
            }
            if (isset($keyword) && $keyword) {
                $sqlmap['a.nikename|a.email|a.mobile'] = array("LIKE", "%" . $keyword . "%");
            }
            switch ($type) {
                /* 查询全部 */
                case '-1':
                    $field = "a.id,
                            a.email,
                            a.mobile,
                            a.is_whitehat_auth,
                            a.is_company_auth,
                            a.is_saler_auth,
                            a.nikename,
                            a.create_time,
                            tus.status AS tusstatus,
                            tuc.status AS tucstatus,
                            tuw.status AS tuwstatus ,
                            tuw.status AS tuwsatus ,
                            tua.`name`,
                            tuc.company,
                            tua.`identity`,
                            tua.`identity_image1`";
                    $sqlmap["a.is_whitehat_auth|a.is_saler_auth|a.is_company_auth"] = array("neq", "0");
                    $join = "LEFT JOIN __USER_SALES__  AS tus ON a.id=tus.uid
                            LEFT JOIN __USER_WHITEHAT__  AS tuw ON a.id = tuw.uid
                            LEFT JOIN __USER_COMPANY__  AS tuc ON a.id = tuc.uid
                            LEFT JOIN __USER_AUTH__  AS tua on a.id= tua.uid";
                    break;
                /* 白帽子认证 */
                case '1':
                    $field = " a.id,
                            a.email,
                            a.mobile,
                            a.nikename,
                            tuw.status AS tuwstatus ,
                            tuw.create_time,
                            tuw.check_time,
                            tua.`identity`,
                            tua.`identity_image1`,
                            a.is_whitehat_auth,
                            a.is_company_auth,
                            a.is_saler_auth,
                            tua.name,
                            tuw.status AS tuwsatus ";
                    $sqlmap["a.is_whitehat_auth"] = array("neq", "0");
                    $join = "RIGHT JOIN __USER_WHITEHAT__ AS tuw ON a.id = tuw.uid
                            LEFT JOIN __USER_AUTH__ AS tua on a.id= tua.uid";
                    break;
                /* 销售认证 */
                case '2':
                    $field = "a.id,
                            a.email,
                            a.mobile,
                            a.nikename,
                            tus.create_time,
                            tus.check_time,
                            tua.`identity`,
                            tua.`identity_image1`,
                            a.is_whitehat_auth,
                            a.is_company_auth,
                            a.is_saler_auth,
                            tua.name,
                            tus.status AS tusstatus ";
                    $sqlmap["a.is_saler_auth"] = array("neq", "0");
                    $join = "RIGHT JOIN __USER_SALES__  AS tus ON a.id=tus.uid
                            LEFT JOIN __USER_AUTH__ AS tua on a.id= tua.uid";
                    break;
                /* 已作废 */
                case '3':
                    $field = "a.id,
                            a.email,
                            a.mobile,
                            a.nikename,
                            tuc.create_time,
                            tuc.check_time,
                            tuc.`check_time` AS tucchecktime,
                            tua.`identity`,
                            tua.`identity_image1`,
                            a.is_whitehat_auth,
                            a.is_company_auth,
                            a.is_saler_auth,
                            tuc.company,
                            tua.name,
                            tuc.status AS tucstatus";
                    $sqlmap["a.is_company_auth"] = array("neq", "0");
                    $join = "RIGHT JOIN __USER_COMPANY__ AS tuc ON a.id = tuc.uid
                            LEFT JOIN __USER_AUTH__ AS tua on a.id= tua.uid";
                    break;
                default:
                    break;
            }
            //分页
            $pagenum = isset($_GET['page']) ? intval($_GET['page']) : 1;
            $rowsnum = isset($_GET['rows']) && (int) ($_GET['rows']) != 0 ? intval($_GET['rows']) : PAGE_SIZE;
            //获取记录数
            $data['total'] = $this->db->getVerifyCount($sqlmap, $join);
            $data['rows'] = $this->db->getVerifyAll($sqlmap, $order, $pagenum, $rowsnum, $join, $field);
//                echo $this->db->_sql();
            if (!$data['rows']) {
                $data['rows'] = array();
            }
            foreach ($data['rows'] as $k => $v) {
                if ($v["company"]) {
                    $data["rows"][$k]["name"] = $v["company"];
                }
                if (empty($v["mobile"])) {
                    $data["rows"][$k]["mobile"] = $v["email"];
                } else {
                    $data["rows"][$k]["mobile"] = $v["mobile"];
                }
                if ($v["is_whitehat_auth"] == 2 || $v["is_whitehat_auth"] == 9) {
                    $data["rows"][$k]["roles"] = "白帽子未认证";
                }
                if ($v["is_saler_auth"] == 2 || $v["is_whitehat_auth"] == 9) {
                    $data["rows"][$k]["roles"] = "销售未认证";
                }
                if ($v["is_company_auth"] == 2 || $v["is_whitehat_auth"] == 9) {
                    $data["rows"][$k]["roles"] = "企业未认证";
                }
                if ($v["is_whitehat_auth"] == 1) {
                    $data["rows"][$k]["roles"] = "已认证白帽子";
                }
                if ($v["is_saler_auth"] == 1) {
                    $data["rows"][$k]["roles"] = "已认证销售";
                }
                if ($v["is_company_auth"] == 1) {
                    $data["rows"][$k]["roles"] = "已认证企业";
                }
                //认证信息
                if ($v["tusstatus"]) {
                    if ($v["tusstatus"] == 1) {
                        $data["rows"][$k]["roles_flag"] = "销售未认证";
                    }
                    if ($v["tusstatus"] == 2) {
                        $data["rows"][$k]["roles_flag"] = "销售已认证";
                    }
                    if ($v["tusstatus"] == 3) {
                        $data["rows"][$k]["roles_flag"] = "销售已驳回";
                    }
                }
                if ($v["tucstatus"]) {
                    if ($v["tucstatus"] == 1) {
                        $data["rows"][$k]["roles_flag"] = "企业未认证";
                    }
                    if ($v["tucstatus"] == 2) {
                        $data["rows"][$k]["roles_flag"] = "企业已认证";
                    }
                    if ($v["tucstatus"] == 3) {
                        $data["rows"][$k]["roles_flag"] = "企业已驳回";
                    }
                }
                if ($v["tuwstatus"]) {
                    if ($v["tuwstatus"] == 1) {
                        $data["rows"][$k]["roles_flag"] = "白帽子未认证";
                    }
                    if ($v["tuwstatus"] == 2) {
                        $data["rows"][$k]["roles_flag"] = "白帽子已认证";
                    }
                    if ($v["tuwstatus"] == 3) {
                        $data["rows"][$k]["roles_flag"] = "白帽子已驳回";
                    }
                }
            }
            echo json_encode($data);
        } else {
            include $this->admin_tpl('verify_lists');
        }
    }

    /**
     * 编辑审核
     */
    public function edit() {
        $id = $_GET["id"];
        $is_whitehat_auth = $_GET["is_whitehat_auth"]; //白帽子认证
        $is_company_auth = $_GET["is_company_auth"]; //认证企业
        $is_saler_auth = $_GET["is_saler_auth"]; //认证销售
        //获取白帽子基本信息
        if ($is_whitehat_auth != 0) {
            $info = $this->db->get_user_whitehat_by_id($id);
            if (!$info) {
                showmessage('没有白帽子认证数据');
            } else {
                $info["login"] = $this->email_mobile($info["email"], $info["mobile"]);
            }
            include $this->admin_tpl('verify_edit');
        }
        //企业认证基本信息
        if ($is_company_auth != 0) {
            $info = $this->db->get_user_company_auth_by_id($id);
            if (!$info) {
                showmessage('没有企业认证数据');
            } else {
                $info["login"] = $this->email_mobile($info["email"], $info["mobile"]);
            }
            include $this->admin_tpl('verify_edit_company');
        }
        //销售认证基本信息
        if ($is_saler_auth != 0) {
            $info = $this->db->get_user_sales_auth_by_id($id);
            if (!$info) {
                showmessage('没有销售认证数据');
            } else {
                $info["login"] = $this->email_mobile($info["email"], $info["mobile"]);
            }
            include $this->admin_tpl('verify_edit');
        }
    }

    public function verifysava() {
        $id = $_POST["id"];
        $is_whitehat_auth = $_POST["is_whitehat_auth"]; //白帽子认证
        $is_company_auth = $_POST["is_company_auth"]; //认证企业
        $is_saler_auth = $_POST["is_saler_auth"]; //认证销售
        //白帽子认证功能
        if ($is_whitehat_auth != 0) {
            $this->db->update_user_verify_by_id($id, $_POST["status"], $_POST["refusal"]);
            if ($_POST["status"] == 2) {
                $message = "亲爱的威客安全用户，您申请的白帽子认证已经成功，请尽快登陆www.secwk.com进行查看。";
                $test = sendPublicMsgByMobile($_POST["mobile"], "11", "", $message);
            } else {
                $message = "亲爱的威客安全用户，您申请的白帽子认证被驳回，请尽快登陆www.secwk.com进行查看。";
                $test = sendPublicMsgByMobile($_POST["mobile"], "11", "", $message);
            }
            showmessage('操作成功', '', 1);
        }
        //企业认证信息
        if ($is_company_auth != 0) {
            $this->db->update_user_company_verify($id, $_POST["status"], $_POST["refusal"]);
            if ($_POST["status"] == 2) {
                $message = "亲爱的威客安全用户，您申请的企业认证已经成功，请尽快登陆www.secwk.com进行查看。";
                $test = sendPublicMsgByMobile($_POST["mobile"], "11", "", $message);
                $user_wallet_info = $this->user_wallet->get_user_wallet_by_userid($id);
                if (!$user_wallet_info) {
                    $this->user_wallet->inser_user_wallet($id);
                }
            } else {
                $message = "亲爱的威客安全用户，您申请的企业认证被驳回，请尽快登陆www.secwk.com进行查看。";
                $test = sendPublicMsgByMobile($_POST["mobile"], "11", "", $message);
            }
            showmessage('操作成功', '', 1);
        }
        if ($is_saler_auth != 0) {
            $array_saler = $this->saler->get_user_sales_by_uid($id);
            if ($array_saler) {
                $parent = $this->parent->get_invite_parent($id);
                if (!$parent) {
                    $array_user = $this->db->get_user_mobile($array_saler["referrer"]);
                }else{
                    $array_user = $this->db->getUserByUserId($parent["par_id"]);
                }
                if ($array_user && $array_user["is_saler_auth"] == 1 && $_POST["status"] == 2) {
                    $array_saler_parent = $this->parent->get_invite_parent($id);
                    if (!$array_saler_parent) {
                        $this->parent->add_parent($array_user["id"], $id);
                        $this->child->add_child($array_user["id"], $id);
                    }
                    //获取基本返利比数据
                    $sale_rank_exc = $this->sale_rank_exc_all();
                    //获取积分数据用来判断循环递归次数
                    $rebate_all = $this->rebate_all();
                    //递归查询获取层级关系结构
                    $array = $this->tree_desc($rebate_all["integral_hierarchy"], $id);
                    //计算层级关系返利积分
                    $this->user_insert_sum($array, $sale_rank_exc, 0, "");
                }
            }
            
            $this->db->update_user_saler_verify($id, $_POST["status"], $_POST["refusal"]);
            if ($_POST["status"] == 2) {
                $message = "亲爱的威客安全用户，您申请的销售认证已经成功；请重新登录APP，尽享威客价~";
                $test = sendPublicMsgByMobile($_POST["mobile"], "11", "", $message);
                $user_wallet_info = $this->user_wallet->get_user_wallet_by_userid($id);
                if (!$user_wallet_info) {
                    $this->user_wallet->inser_user_wallet($id);
                }
            } else {
                $message = "亲爱的威客安全用户，您申请的销售认证被驳回，请尽快登陆www.secwk.com进行查看。";
                $test = sendPublicMsgByMobile($_POST["mobile"], "11", "", $message);
            }
            showmessage('操作成功', '', 1);
        }
    }

    /**
     * 计算层级关系返利积分
     * @param type $array 层级关系结果
     * @param type $user_id 要返利
     */
    private function user_insert_sum($array, $sale_rank_exc, $money, $order_sn = 0) {
        if (count($array) > 0) {
            $data = $this->SaleIntegral->get_sale_integral_id(count($array));
            for ($i = 0; $i < count($array); $i++) {
                $user_list = $this->order_integral_user($array[$i]);
                if ($user_list["is_saler_auth"] != 0) {
                    //计算总积分
                    $user_integral = $user_list["integral"] + (($sale_rank_exc["rank"] / $sale_rank_exc["sale_key_value"])) * ($data["integral_" . ($i + 1)] / 100);
//                    echo $user_integral;
                    //计算获得积分
                    $user_integral_have = (($sale_rank_exc["rank"] / $sale_rank_exc["sale_key_value"])) * ($data["integral_" . ($i + 1)] / 100); //计算获取得积分
                    //修改积分日志表       
                    $this->order_money_integral($user_integral_have, $user_list, $order_sn, $array[$i]);
                    //修改销售日志表
                    $this->sale_logs_insert($user_integral_have, $user_list, $order_sn, $array[$i], 4);
                    //获取用户积分等级
                    $rank = $this->UserGroup->get_user_gourp_leven($user_integral);
                    //修改用户等级及其积分
                    $this->order_integral_user_update($user_list["id"], $user_integral, $rank["id"]);
                }
            }
        }
    }

    /**
     * 向日志表中写入数据
     * 表t_sale_logs
     */
    private function sale_logs_insert($user_integral_flag, $userdata, $order_sn = 0, $relation_id = 0, $type) {
//            echo var_dump($userdata);
        $param["number"] = $user_integral_flag;
        $param["type"] = $type;
        $param["uid"] = $userdata["id"];
        $param["order_sn"] = $order_sn;
        $param["relation_id"] = $relation_id;
        $param["create_time"] = time();
        if ($type == 4) {
            $name = "积分";
        }
        if ($type == 5) {
            $name = "金额";
        }
        if ($relation_id != 0) {
            $param["desc"] = "您的订单" . $order_sn . "已确认，获得" . $name . "" . floor($user_integral_flag);
        } else {
            $param["desc"] = "您获得邀请积分" . $name . "" . floor($user_integral_flag);
        }
        $data = $this->SaleLogs->add_sale_logs($param);
//            echo $this->SaleLogs->_sql();
        return $data;
    }

    /**
     * 根据金额计算返利积分,
     * 针对当前用户不包括上级关系用户，
     * 插入t_integral积分日志表数据
     * @param type $data 订单分期集合
     * @param type $userdata 用户数据集合
     * @param type $order_sn 点单编号
     * @param type $user_integral_flag 获得积分总额度
     */
    private function order_money_integral($user_integral_flag, $userdata, $order_sn = 0, $relation_id = 0) {
        $param["integral"] = $user_integral_flag;
        $param["source"] = 1;
        $param["uid"] = $userdata["id"];
        $param["relation_id"] = $relation_id;
        $param["order_sn"] = $order_sn;
        $param["create_time"] = time();
        if ($relation_id != 0) {
            $param["desc"] = "您获得邀请积分" . floor($user_integral_flag);
        } else {
            $param["desc"] = "您的订单" . $order_sn . "已确认，获得积分" . floor($user_integral_flag);
        }
        $data = $this->Integral->add_integral($param);
        return $data;
    }

    /**
     * 通过用户ID查询相关用户积分数据
     * 表t_user
     */
    private function order_integral_user($user_id) {
        $data = $this->db->getUserByUserId($user_id);
        return $data;
    }

    /**
     * 查询递归父子关系，并且反向处理
     * @param type $num 要处理递归层数
     * @param type $user_id 下订单id
     * @return type 返货结果集合
     */
    private function tree_desc($num, $user_id) {
        $out = $this->insert_tree($num, $user_id);
        $array = array();
        if ($num > count($out)) {
            $j = 0;
        } else {
            $j = 1;
        }
        for ($i = count($out); $i > $j; $i--) {
            $array[] = $out[$i - 1];
        }
        return $array;
    }

    /**
     * 查询消费积分返利比
     */
    private function sale_rank_exc_all() {
        $data = $this->SaleRankExc->get_sale_rank_exc_sale_key("SALE");
        return $data;
    }

    /**
     * 查询积分返利功能设置参数
     * 表:t_rebate
     */
    private function rebate_all() {
        $data = $this->Rebate->getBysalerebate();
        return $data;
    }

    /**
     * 递归查询所在关系返回结果集合
     * @param type $num
     * @param type $user_id
     * @return array
     */
    private function insert_tree($num, $user_id) {
        $out = array();
        if ($num == 0) {
            return $out;
        } else {
            $par_id = $this->parent->get_invite_parent($user_id);
            if (empty($par_id["par_id"])) {
                return $out;
            }
            $out = $this->insert_tree($num - 1, $par_id["par_id"]);
        }
        $out[] = $par_id["par_id"];
        return $out;
    }

    /**
     * 修改用户积分
     * @param type $user_id 用户id
     * @param type $integral 修改积分数据
     * @return int 1成功，0失败
     */
    public function order_integral_user_update($user_id, $integral, $rank) {
        $data = $this->db->updateIntegralUserByUserId($user_id, $integral, $rank);
        if ($data) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * 处理用户电子邮件、电话是否为空
     * @param type $email
     * @param type $mobile
     * @return type
     */
    private function email_mobile($email, $mobile) {
        if ($email) {
            return $email;
        }
        if ($mobile) {
            return $mobile;
        }
    }

}

?>
