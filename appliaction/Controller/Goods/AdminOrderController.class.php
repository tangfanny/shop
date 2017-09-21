<?php

class AdminOrderController extends AdminBaseController {

    protected $_config = array();

    /* 初始化 */

    public function _initialize() {
        parent::_initialize();
        $this->db = model('order');
        $this->log_db = model('order_log');
        $this->goods_db = model('order_goods');
        $this->goods = model("Goods");
        $this->goods_day_rank = model("Goods_day_rank");
        $this->parcel_db = model('order_parcel');
        $this->goods_kc = model("goods_products");
        $this->_order_staging = model('order_staging'); //订单分期表查询
        $this->_order_pact = model("order_pact"); //订单合同表查询
        $this->_order_goods_staging = model("order_goods_staging"); //订单商品分期表
        $this->_config = $this->load_config('status');
        $this->deliverys = getcache('deliverys', 'site');
        $this->usermsg = model("user_msg");
        $this->user = model("User");
        $this->SaleRankExc = model("SaleRankExc"); //获取消费积分返利比
        $this->Integral = model("Integral"); //积分日志表
        $this->SaleLogs = model("SaleLogs"); //积分日志表
        $this->Rebate = model("Rebate"); //销售体系设置表
        $this->InviteParent = model("InviteParent"); //关系父表
        $this->SaleIntegral = model("SaleIntegral"); //积分分成关系表
        $this->UserGroup = model("UserGroup"); //用户分组等级表
        $this->Income = model("Income"); //返利收益表
        $this->UserWallet = model("UserWallet"); //用户余额表
        $this->SaleRebate = model("SaleRebate"); //用户返利金额结构表InviteChild
        $this->InviteChild = model("InviteChild");
    }

    /**
     * 订单列表
     */
    public function lists() {
        $type = isset($_GET['type']) ? $_GET['type'] : -1;
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        $region_arr = getcache('region', 'region');
        $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : 0;
        if (IS_POST) {
            $sqlmap = array();
            $field = "a.*, 
				e.name AS delivery_name,
				f.pay_name AS payment_name";
            $join = "
				LEFT JOIN `__DELIVERY__` AS e ON a.delivery_id = e.id
				LEFT JOIN `__PAYMENT__` AS f ON a.pay_code = f.pay_code";
            //排序
            $_order = isset($_POST['order']) ? ($_POST['order']) : NULL;
            $_sort = isset($_POST['sort']) ? ($_POST['sort']) : NULL;
            if ($_order && $_sort) {
                $order[$_sort] = $_order;
            } else {
                $order['id'] = 'DESC';
            }
            //筛选
            if (isset($user_id) && $user_id > 0) {
                $sqlmap['a.user_id'] = $user_id;
            }
            if (isset($keyword) && $keyword) {
                $sqlmap['_string'] = "a.order_sn LIKE '%{$keyword}%' OR a.accept_name LIKE '%{$keyword}%' OR a.mobile LIKE '%{$keyword}%' ";
            }
            switch ($type) {
                /* 未处理 */
                case '6':
                    $sqlmap['a.order_status'] = 0;
                    break;
                /* 已发货 */
                case '5':
                    $sqlmap['a.order_status'] = 1;
                    $sqlmap['a.delivery_status'] = 1;
                    break;
                /* 代发货 */
                case '4':
                    $sqlmap['a.order_status'] = 1;
                    $sqlmap['a.delivery_status'] = 0;
                    break;
                /* 已作废 */
                case '3':
                    $sqlmap['a.order_status'] = 3;
                    break;
                case '1':
                    $sqlmap['a.order_status'] = 2;
                    break;
                case '7':
                    $sqlmap["a.order_status"] = 7;
                default:
                    break;
            }

            //分页
            $pagenum = isset($_GET['page']) ? intval($_GET['page']) : 1;
            $rowsnum = isset($_GET['rows']) && (int) ($_GET['rows']) != 0 ? intval($_GET['rows']) : PAGE_SIZE;
            //计算总数 
            $data['total'] = $this->db->alias('a')->where($sqlmap)->count();
            $data['rows'] = $this->db->alias('a')->field($field)->join($join)->where($sqlmap)->limit(($pagenum - 1) * $rowsnum . ',' . $rowsnum)->order($order)->select();
//                        echo $this->db->getLastSql();

            if (!$data['rows'])
                $data['rows'] = array();
//                        echo count($data["rows"]);
            for ($i = 0; $i < count($data["rows"]); $i++) {
                $data["rows"][$i]["accept_name"] = base64_decode($data["rows"][$i]["accept_name"]);
                $data["rows"][$i]["mobile"] = base64_decode($data["rows"][$i]["mobile"]);
                $data["rows"][$i]["zipcode"] = base64_decode($data["rows"][$i]["zipcode"]);
                $data["rows"][$i]["telphone"] = base64_decode($data["rows"][$i]["telphone"]);
                $data["rows"][$i]["province"] = base64_decode($data["rows"][$i]["province"]);
                $data["rows"][$i]["city"] = base64_decode($data["rows"][$i]["city"]);
                $data["rows"][$i]["area"] = base64_decode($data["rows"][$i]["area"]);
                $data["rows"][$i]["address"] = base64_decode($data["rows"][$i]["address"]);
                $data["rows"][$i]["invoice_title"] = base64_decode($data["rows"][$i]["invoice_title"]);
            }
//                        echo var_dump($data["rows"]);
            echo json_encode($data);
        } else {
            include $this->admin_tpl('admin_order_lists');
        }
    }

    /**
     * 更新订单数据
     * @param  $data : 确认发货时所传参数
     */
    public function update() {
        extract($_GET);
        switch ($action) {
            /* 确认订单 */
            case 'order':
                $result = $this->setOrder($order_sn, $order_status);
                $type = $this->_config['log_order_status'][$order_status];
                $oid = $this->db->field('id')->where('order_sn='.$_GET['order_sn'])->select();
                $goods_id = $this->goods_db->where('order_id='.$oid[0]['id'])->select();
                $goods_info = $this->goods_day_rank->where('gid='.$goods_id[0]['goods_id'])->select();
                $info['real_sale'] = $goods_info[0]['real_sale'] + $goods_id[0]['shop_number'];
                $info['display_sale'] = $goods_info[0]['display_sale'] + $goods_id[0]['shop_number'];
                $t['time'] = array('eq',strtotime(date('Y-m-d',time())));
                $this->goods_day_rank->where($t)->where('gid='.$goods_id[0]['goods_id'])->save($info);
                if (!$result)
                    break;
                /* 通知推送 */
                runhook('n_confirm_order', array('order_sn' => $order_sn));
                break;
            /* 确认发货 */
            case 'delivery':
                $msg = $this->editDelivery();
                $result = $this->setDelivery($order_sn, $delivery_status, $delivery_sn);
                $type = $this->_config['log_delivery_status'][$delivery_status];
                if (!$result)
                    break;
                /* 通知推送 */
                runhook('n_order_delivery', array('order_sn' => $order_sn));
                break;
            /* 支付状态 */
            case 'pay':
                $result = $this->setPay($order_sn, $pay_status);
                $type = $this->_config['log_pay_status'][$pay_status];
                break;
            default:
                showmessage('请勿非法访问', '', 1);
                break;
        }

        if (!$result)
            showmessage('操作失败');
        $this->write_log($order_sn, $type, $msg);
        showmessage('操作成功', '', 1);
    }

    /**
     * 生成发货单
     */
    public function setparcel() {
        $sqlmap = array();
        $sqlmap['order_sn'] = $_GET['order_sn'];
        $orderinfo = $this->db->where($sqlmap)->field('id,accept_name,mobile,address,province,city,area,delivery_txt,real_amount')->find();
        $ordermap = array();
        $ordermap['order_id'] = $orderinfo['id'];
        $goodsinfo = array();
        $ordergoodsinfo = $this->goods_db->join("hd_goods ON hd_order_goods.goods_id=hd_goods.id")->join("hd_goods_products ON hd_goods.id=hd_goods_products.goods_id and hd_order_goods.spec_array=hd_goods_products.spec_array")->where($ordermap)->select();
        $total_number = array();
        foreach ($ordergoodsinfo as $k => $v) {
            $goodsinfo[$k]['goods_name'] = $v['name'];
            $goodsinfo[$k]['shop_price'] = $v['shop_price'];
            $goodsinfo[$k]['shop_number'] = $v['shop_number'];
            $goodsinfo[$k]['products_sn'] = $v['products_sn'];
            $total_number[] = $v['shop_number'];
        }
        $goodslist = str_replace('/', '//', json_encode($goodsinfo));
        $data = array();
        $data['order_sn'] = $_GET['order_sn'];
        $data['address'] = $orderinfo['address'];
        $data['total_number'] = array_sum($total_number);
        $data['real_amount'] = $orderinfo['real_amount'];
        $data['accept_name'] = $orderinfo['accept_name'];
        $data['mobile'] = $orderinfo['mobile'];
        $data['province'] = $orderinfo['province'];
        $data['city'] = $orderinfo['city'];
        $data['area'] = $orderinfo['area'];
        $data['delivery_txt'] = $orderinfo['delivery_txt'];
        $data['goods_list'] = $goodslist;
        $result = $this->parcel_db->update($data);
        if (!$result)
            showmessage('生成发货单失败');
        return TRUE;
    }

    /**
     * 添加订单
     */
    public function add() {
        if (IS_POST) {
            $jsonstring = $_POST;
            $_POST['order_sn'] = build_order_no();
            self::update();
        } else {
            $submit_url = U('AdminOrder/add');
            $region = model('Region')->select();
            $payment = model('Payment')->select();
            include $this->admin_tpl('admin_order_add');
        }
    }

    /* 查看&编辑订单 */

    public function edit() {
        $dialog = TRUE;
        $validform = TRUE;
        $info = $this->db->detail($_GET['order_sn']);
        $info['id'] = $info['id'];
        $info['user_name'] = get_nickname($info['user_id']);
        $info["newsinfo"] = $this->db->detailleft($_GET['order_sn']);
        $info['_delivery'] = $this->deliverys[$info['delivery_id']];
        $info['_goods'] = $this->goods_db->where(array('order_id' => $info['id']))->select();
        $info['front_id'] = $this->db->where(array("id" => array("LT", $info['id'])))->order("id DESC")->find();
        $info['after_id'] = $this->db->where(array("id" => array("GT", $info['id'])))->order("id ASC")->find();
        $info["order_staging"] = $this->_order_staging->getOrderStagingAll($info['id']);
        //合同列表
        $info["order_pact"] = $this->_order_pact->getOrderPactById($info['id']);
        $info["admin_extension"] = $this->_order_pact->field('admin_extension')->getOrderPactById($info['id']);
//        var_dump($info["admin_extension"][0]['admin_extension']);die;
        $info["order_pact_offo"] = $this->_order_pact->getOrderGroupByOrderid($info["id"]);        if(IS_POST){
            $where['orderid'] = array('eq',$_POST['id']);
            $array_pact = explode(".",$_POST['official_pact_url']);
            $data['official_pact_url'] = $array_pact[0];
            $data['admin_extension'] = $array_pact[1];
            $re = $this->_order_pact->where($where)->save($data);
            if($re){
                echo  '1';
            }else{
                echo '0';
            }
        }
        $payment = getcache('payment', 'pay');
        $deliverys = $this->deliverys;
        include $this->admin_tpl('admin_order_edit');
    }

    /* 修改订单价格 */

    public function editPrice() {
        extract($_GET);
        $real_amount = sprintf('%.2f', $real_amount);
        if (empty($order_sn))
            showmessage('订单号参数错误');
        $sqlmap = array();
        $sqlmap['order_sn'] = $order_sn;
        $result = $this->db->where($sqlmap)->setField('real_amount', $real_amount);
        if (!$result) {
            showmessage('订单价格修改失败');
        } else {
            $this->write_log($order_sn, '修改价格', '从「' . $oldPrice . '」修改到「' . $real_amount . '」');
            showmessage('订单价格修改成功', '', 1);
        }
    }

    /* 修改配送方式 */

    public function editDelivery() {
        $order_sn = trim($_GET['order_sn']);
        $data = $this->db->getOrderByOrdersn($order_sn);
        $usermsg["order_sn"] = $order_sn;
        $usermsg["uid"] = $data["user_id"];
        $usermsg["create_time"] = time();
        $usermsg["mobile"] = $data["mobile"];
        if (empty($order_sn))
            showmessage('订单号参数错误！');
        if (!trim($_GET['delivery_sn']))
            showmessage('请填写快递单号');
        $order_info = $this->db->detail($_GET['order_sn']);
        $sqlmap = array();
        $sqlmap['order_sn'] = $order_sn;
        $result = $this->db->where($sqlmap)->setField(array('delivery_id' => $_GET['delivery_id'], 'delivery_txt' => $_GET['delivery_txt'], 'delivery_sn' => $_GET['delivery_sn']));
        if (!$result)
            showmessage('订单配送方式修改失败');
        if ($order_info['delivery_id'] != $_GET['delivery_id']) {
            $msg = '从「' . $order_info['delivery_txt'] . '」修改到「' . $_GET['delivery_txt'] . '」;快递单号：' . trim($_GET['delivery_sn']);
            $usermsg["message"] = "您的订单【" . $order_sn . "】已经发货,「" . $_GET['delivery_txt'] . '」;快递单号：' . trim($_GET['delivery_sn']);
        } else {
            $msg = '快递单号：' . trim($_GET['delivery_sn']);
            $usermsg["message"] = "您的订单【" . $order_sn . "】已经发货,快递单号：" . trim($_GET['delivery_sn']);
        }

//                if(sendPublicMsgByMobile(base64_decode($data["mobile"]),"11","",$usermsg["message"])){
        if(C('Messageflag.order_sent') !=0){
            $test = sendPublicMsgByMobile(base64_decode($data["mobile"]), "11", "", $usermsg["message"]);
            $userdata = $this->usermsg->addUserMsg($usermsg);
            return $msg;
        }


//                }
//                     $userdata=  $this->usermsg->addUserMsg($usermsg);
//                    return $msg;
//                }
    }

    /* 快递查询 */

    public function kuaidi() {
        extract($_GET);
        if (IS_POST) {
            libfile('kuaidi');
            $kuaidi = new kuaidi();
            $result = $kuaidi->query($com, $nu);
            if (!$result) {
                showmessage($kuaidi->getError());
            } else {
                showmessage('查询成功', '', 1, '', '', '', $result);
            }
        } else {
            include $this->admin_tpl('admin_order_kuaidi');
        }
    }

    public function testgoodsnum() {
        $sqlmap['order_sn'] = '151010004721574'; //$order_sn;
        $data = $this->db->getOrderByOrdersn($sqlmap['order_sn']);
        $datakc = $this->goods_db->getOrder_sn($data["id"]);

        foreach ($datakc as $value => $key) {
            $datapro = $this->goods_kc->getGoodsProductsByGoodsidAndproid($datakc[$value]["goods_id"], $datakc[$value]["product_id"]);
            foreach ($datapro as $value => $key) {
                $num = $datapro[$value]["goods_number"] - $datakc[$value]["shop_number"];
                if ($num > 0) {
                    $this->goods_kc->updateGoodsbyNum($datapro[$value]["goods_id"], $datapro[$value]["id"], $num);
                }
            }
        }
    }

    /* 设定订单状态 */

    private function setOrder($order_sn, $order_status) {
        $sqlmap = array();
        $sqlmap['order_sn'] = $order_sn;
        $info['order_status'] = (int) $order_status;
        $data = $this->db->getOrderByOrdersn($order_sn);
        $usermsg["order_sn"] = $order_sn;
        $usermsg["uid"] = $data["user_id"];
        $usermsg["create_time"] = time();


        if ($order_status == 2) {
            $info['pay_status'] = 1;
            $info['completion_time'] = NOW_TIME;
        } elseif ($order_status == 1) {
            $info['confirm_time'] = NOW_TIME;
        }
        $result = $this->db->where($sqlmap)->save($info);

        if (!$result) {
            return $this->db->getError();
        } else {
            if ($order_status == 1) {
                $this->setparcel();
                $usermsg["message"] = "您的订单【" . $order_sn . "】已经确认，您的订单正在配货";
                model('order_track')->update(array('order_sn' => $order_sn, 'track_msg' => '您的订单正在配货'));

                $datakc = $this->goods_db->getOrder_sn($data["id"]);
                foreach ($datakc as $value => $key) {
                    $datapro = $this->goods_kc->getGoodsProductsByGoodsidAndproid($datakc[$value]["goods_id"], $datakc[$value]["product_id"]);
                    foreach ($datapro as $value => $key) {
                        $num = $datapro[$value]["goods_number"] - $datakc[$value]["shop_number"];
                        $this->goods_kc->updateGoodsbyNum($datapro[$value]["goods_id"], $datapro[$value]["id"], $num);
                        $num1=$this->goods->select_googds_by_id($datapro[$value]["goods_id"]);
                        $this->goods->update_goods_xl($datapro[$value]["goods_id"],$num1["buy_num"],$datakc[$value]["shop_number"]);

                    }
                }
            } elseif ($order_status == 2) {
                $usermsg["message"] = "您的订单【" . $order_sn . "】已经完成";
                runhook('order_finished', $order_sn);
            } elseif ($order_status == 4) {
                $usermsg["message"] = "您的订单【" . $order_sn . "】已经取消";
                $rs = model('order')->where(array('order_sn' => $order_sn))->find();
                // 减去冻结金并加上会员余额
                if ($rs['balance_amount'] > 0) {
                    model('user')->where(array('id' => $rs['user_id']))->setDec('freeze_money', $rs['balance_amount']);
                    model('user')->where(array('id' => $rs['user_id']))->setInc('user_money', $rs['balance_amount']);
                    // 写入财务变动记录
                    $data = array();
                    $data['user_id'] = $rs['user_id'];
                    $data['money'] = $rs['balance_amount'];
                    $data['msg'] = '取消订单，并退回冻结金额';
                    $data['dateline'] = NOW_TIME;
                    model('user_moneylog')->add($data);
                }
            } elseif ($order_status == 3) {
                $usermsg["message"] = "您的订单【" . $order_sn . "】已经作废";
            }
            if(C('Messageflag.order_sent')!=0) {
                $test = sendPublicMsgByMobile(base64_decode($data["mobile"]), "11", "", $usermsg["message"]);
                $userdata = $this->usermsg->addUserMsg($usermsg);

            }
        }
        return TRUE;
    }


    /* 设定订单发货状态 */

    private function setDelivery($order_sn, $delivery_status, $delivery_sn) {
        $pays = getcache('payment', 'pay');
        $sqlmap = array();
        $sqlmap['order_sn'] = $order_sn;


//                
        $o_info = $this->db->where($sqlmap)->find();
        $info['delivery_status'] = (int) $delivery_status;
        if ($delivery_status == 1) {
            $info['delivery_sn'] = $delivery_sn;
            $info['send_time'] = NOW_TIME;
            if ($pays[$o_info['pay_code']]) {
                libfile('pay_factory');
                $product_info = array(
                    'trade_no' => $o_info['trade_no'],
                    'delivery_txt' => $o_info['delivery_txt'],
                    'delivery_sn' => $info['delivery_sn']
                );
                $pay_factory = new pay_factory($o_info['pay_code']);
                $pay_factory->set_productinfo($product_info);
                $pay_factory->_delivery();
            }
        }
        $result = $this->db->where($sqlmap)->save($info);
        if ($result) {
            model('order_track')->update(array('order_sn' => $order_sn, 'track_msg' => '您的订单已经发货'));
            return TRUE;
        } else {
            return $this->db->getError();
        }



        return (!$result) ? $this->db->getError() : TRUE;
    }

    /* 设定订单支付状态 */

    private function setPay($order_sn, $pay_status) {
        $sqlmap = array();
        $sqlmap['order_sn'] = $order_sn;
        $info['pay_status'] = (int) $pay_status;
        if ($pay_status == 1) {
            model('order_track')->update(array('order_sn' => $order_sn, 'track_msg' => '您的订单已付款，请等待系统确认'));
            $info['pay_time'] = NOW_TIME;
        }
        $result = $this->db->where($sqlmap)->save($info);
        return (!$result) ? $this->db->getError() : TRUE;
    }

    /**
     * 显示订单日志
     */
    public function view_log() {
        libfile('Dir');
        extract($_GET);
        if (empty($order_sn))
            showmessage('订单号参数错误');
        $sqlmap = array();
        $sqlmap['order_sn'] = $order_sn;
        $result = $this->log_db->where($sqlmap)->order("id DESC")->select();
        if (!$result) {
            showmessage('暂无任何订单操作日志信息');
        } else {
            foreach ($result as $key => $value) {
                $value['dateline'] = mdate($value['dateline'], 'Y/m/d H:i');
                $result[$key] = $value;
            }
            $return['data'] = $result;
            showmessage('订单操作日志查阅成功', '', 1, 1, 1, 1, $return);
        }
    }

    /* 写入订单日志 */

    private function write_log($order_sn, $action, $msg) {
        $log = array(
            'order_sn' => $order_sn,
            'action' => $action,
            'msg' => $msg,
        );
        $this->log_db->update($log);
    }

    /* 打印快递信息 */

    public function print_kd($order_id = 0) {
        if ((int) $order_id < 1)
            showmessage('您的订单号有误');
        /* 查找该订单的快递图片名称 */
        $info = model('order')->where(array('id' => $order_id))->find();

        /* 读取该快递模版的编辑信息 */
        $content = json_decode(model('print_tpl_delivery')->getFieldByDelivery_id($info['delivery_id'], 'content'), TURE);
        // 替换值
        foreach ($content['list'] as $k => $v) {
            $str = str_replace('left', 'x', json_encode($v));
            // $str = str_replace('top','y',$str);
            // $str = str_replace('txt','typeText',$str);
            $str = str_replace('{accept_name}', $info['accept_name'], $v);
            $str = str_replace('{province}', getAreaNameById($info['city']), $str);
            $str = str_replace('{address}', getAreaNameById($info['province']) . ' ' . getAreaNameById($info['city']) . ' ' . getAreaNameById($info['area']) . ' ' . $info['address'], $str);
            $str = str_replace('{mobile}', $info['mobile'], $str);
            $str = str_replace('{postscript}', $info['postscript'], $str);
            $str = str_replace('{insured}', $info['insured'], $str);
            $str = str_replace('{real_amount}', $info['real_amount'], $str);
            $str = str_replace('{payable_amount}', $info['payable_amount'], $str);
            $str = str_replace('{from_site_company}', C('from_site_company'), $str);
            $str = str_replace('{from_tel}', C('from_tel'), $str);
            $str = str_replace('{from_address}', C('from_address'), $str);
            $content['list'][$k] = $str;
        }
        include $this->admin_tpl('admin_order_print_kd');
    }

    public function ajaxstaging() {
        $id = $_POST["id"];
        $admin["adminname"] = session("ADMIN_UNAME");
        $admin["adminid"] = session("ADMIN_ID");
        $admin["finance_time"] = time();
        $flag = $this->_order_staging->updateOrderStagingUser($id, $admin);
        if ($flag != 0) {
            echo '1';
        } else {
            echo '0';
        }
    }

    /**
     * 修改合同状态
     */
    public function ajaxpact() {
        $order_sn = $_POST["order_sn"];
        $data = $this->db->getOrderByOrdersn($order_sn);
        $id = $_POST["id"];
        $status = $_POST["type"];
        $reject = $_POST["msg"];
        $admin["adminname"] = session("ADMIN_UNAME");
        $admin["adminid"] = session("ADMIN_ID");
        $admin["pact_status"] = $status;
        $admin["reject"] = $reject;
        $flag = $this->_order_pact->updateOrderPactByOrderid($id, $admin);
        $usermsg["order_sn"] = $order_sn;
        $usermsg["uid"] = $data["user_id"];
        $usermsg["create_time"] = time();
        $where['orderid'] = array('eq',$id);
        if ($status == 3) {
            $usermsg["message"] = "您的订单您的合同已经确认";
        }
        if ($status == 0) {
            $usermsg["message"] = "您的订单您的合同已经被驳回，具体驳回合同具体驳回原因" . $reject;
            $this->_order_pact->where($where)->delete();
        }
        $userdata = $this->usermsg->addUserMsg($usermsg);
        if ($flag != 0 && $userdata) {
            echo "1";
        } else {
            echo '0';
        }
    }

    public function ajaxpacturl() {
        $id = $_POST["id"];
        $order_sn = $_POST["order_sn"];
        $extension = $_POST["extension"];
        $data = $this->db->getOrderByOrdersn($order_sn);
        $usermsg["order_sn"] = $order_sn;
        $usermsg["uid"] = $data["user_id"];
        $info["admin_extension"] = $extension;
        $usermsg["create_time"] = time();
        $usermsg["message"] = "您的订单官方合同已回传请查收";
        $userdata = $this->usermsg->addUserMsg($usermsg);
        $this->_order_pact->where('uid='.$usermsg["uid"])->save($info);
        $admin["official_pact_url"] = $_POST["pacturl"];
        $admin["official_pact_time"] = time();
        $flag = $this->_order_pact->updateOrderPactByOrderid($id, $admin);
        if ($flag != 0) {
            echo "1";
        } else {
            echo '0';
        }
    }

    public function ajaxsubimtmoney() {
        $order_sn = $_POST["order_sn"];
//          $order_sn=$_GET["order_sn"];
        $data = $this->db->getOrderByOrdersn($order_sn);
        $usermsg["order_sn"] = $order_sn;
        $usermsg["uid"] = $data["user_id"];
        $usermsg["create_time"] = time();
        $usermsg["message"] = "您的订单付款已经确认收款";
        $userdata = $this->usermsg->addUserMsg($usermsg);
//
        $id = $_POST["id"];
//             $id=$_GET["id"];//测试专用
        $datalist = $this->_order_staging->getOrderSangtingById($id);
        //计算返利
        $this->order_sale_rebate_money($order_sn, $datalist);
        //计算返积分
        $this->order_sn_insert($datalist, $order_sn);
        //解除关系
        $this->relieve_relationship($datalist["userid"]);
        $orderstaging["finance_time"] = time();
        $orderstaging["finance_type"] = 1;
        $orderstaging["adminname"] = session("ADMIN_UNAME");
        $orderstaging["adminid"] = session("ADMIN_ID");
        $orderstagingflag = $this->_order_staging->updateOrderSangingById($id, $orderstaging);
        $ordergoodsstaging["pay_time"] = time();
        $ordergoodsstaging["pay_flag"] = 1;
        $ordergoodsstagingflag = $this->_order_goods_staging->updateOrderGoodsSatging($datalist["orderid"], $datalist["staging_num"], $ordergoodsstaging);
        $order["pay_status"] = 1;
        $order["pay_time"] = time();
        $oderflag = $this->db->updateorderpay($datalist["orderid"], $order);
        if ($orderstagingflag != 0 && $ordergoodsstagingflag != 0 && $oderflag != 0) {
            echo '1';
        } else {
            echo '0';
        }
    }

    /**
     * 
     * @param type $user_id
     */
    private function relieve_relationship($user_id) {
        $rebate_all = $this->rebate_all();
        $user_array = $this->tree_desc($rebate_all["integral_hierarchy"], $user_id);
        /**
         * 获取用户积分
         */
        foreach ($user_array as $k => $v) {
            $user_data[] = $this->order_integral_user($v);
        }
        /**
         * 判断是否超越积分
         */
        for ($i = 0; $i < count($user_data); $i++) {
            for ($j = ($i + 1); $j < count($user_data); $j++) {
                if ($user_data[$i]["integral"] > $user_data[$j]["integral"]) {
                    $this->delete_relieve($user_data[$i]["id"], $user_data[$j]["id"]);
                }
            }
        }
//            echo var_dump($user_data);
    }

    /**
     * 删除关系，传入相关节点
     * @param type $par_id
     * @param type $child_id
     */
    private function delete_relieve($par_id, $child_id) {
        $this->InviteParent->delete_parent($par_id, $child_id);
        $this->InviteChild->delete_child($par_id, $child_id);
    }

    /**
     * 计算要通过总价的百分比,做为返利 获取要返利的百分比，获取返利金额，获取递归层次关系
     * @param type $order_sn
     * @param type $datalist
     */
    private function order_sale_rebate_money($order_sn, $datalist) {
        //获取总价的百分比,做为返利
        $rebate_all = $this->rebate_all();
        //获取返利金额
        $sale_rebate_money = $datalist["money"] * ($rebate_all["rebate"] / 100);
        //递归查询获取层级关系结构
        $array = $this->tree_desc($rebate_all["rebate_hierarchy"], $datalist["userid"]);

        $this->order_sale_rebate_money_sum($sale_rebate_money, $array, $order_sn, $datalist["money"]);
    }

    private function order_sale_rebate_money_sum($sale_rebate_money, $array, $order_sn, $money) {
        if (count($array) > 0) {
            $data = $this->SaleRebate->get_sale_rebats_id(count($array));
            for ($i = 0; $i < count($array); $i++) {
                $user_list = $this->order_integral_user($array[$i]);
                if ($user_list["is_saler_auth"] != 0) {
                    //计算返现金额
                    $user_money_have = $sale_rebate_money * ($data["rebate_" . ($i + 1)] / 100);
                    //修改销售日志表
                    $this->sale_logs_insert($user_money_have, $user_list, $order_sn, $array[$i], 5);
                    //修改收益表
                    $this->sale_rebate_money_income($user_money_have, $sale_rebate_money, $order_sn, $money, $user_list, $data["rebate_" . ($i + 1)]);
//                    //修改用户修改余额表
                    $this->user_wallet($user_list, $user_money_have);
                }
            }
        }
    }

    /**
     * 修改余额表
     * @param type $user_array
     * @param type $user_money_have
     */
    private function user_wallet($user_array, $user_money_have) {
        $user_wallet = $this->UserWallet->get_user_wallet_by_userid($user_array["id"]);
        $user_wallet_income = $user_wallet["income"] + $user_money_have;
        $user_wallet_balance = $user_wallet["balance"] + $user_money_have;
        $params["income"] = $user_wallet_income;
        $params["balance"] = $user_wallet_balance;
        $params["update_time"] = time();
        $data = $this->UserWallet->update_user_wallet($user_array["id"], $params);
    }

    /**
     * 写入收益记录表
     * @param type $income 收益金额
     * @param type $rebate_money 返利金额
     * @param type $order_sn 订单编号
     * @param type $money 订单应付金额
     * @param type $user_array 用户列表
     */
    private function sale_rebate_money_income($income, $rebate_money, $order_sn, $money, $user_array, $percentage) {
        $params["income"] = $income;
        $params["rebate_money"] = $rebate_money;
        $params["order_sn"] = $order_sn;
        $params["money"] = $money;
        $params["percentage"] = $percentage;
        $params["uid"] = $user_array["id"];
        $params["child_id"] = $user_array["id"];
        $params["desc"] = "获得返利金额" . $income;
        $params["create_time"] = time();
        $this->Income->add_Income($params);
    }

    /**
     * 通过订单分期金额计算要分给的总分数
     * $id:订单分期
     * 表：t_order_staging
     * 返回值：订单分期表中list数据
     */
    private function order_sn_insert($datalist, $order_sn) {
//            $datalist = $this->_order_staging->getOrderSangtingById($id);//获取订单分期数据
        //获取用户积分
//            $user_integral_find= $this->order_integral_user($datalist["userid"]);
        //获取基本返利比数据
        $sale_rank_exc = $this->sale_rank_exc_all();
        //计算获取应该获取的积分
//            $user_integral = $user_integral_find["integral"]+$datalist["money"]*($sale_rank_exc["rank"]/$sale_rank_exc["sale_key_value"]);
//            $user_integral_have = $datalist["money"]*($sale_rank_exc["rank"]/$sale_rank_exc["sale_key_value"]);
        //修改用户积分
//            $user_integral_flag = $this->order_integral_user_update($datalist["userid"],$user_integral);
        //写入积分日志表
//            $order_money_integral = $this->order_money_integral($user_integral_have,$user_integral_find,$order_sn);
        //写入销售日志表
//            $sale_logs_insert=  $this->sale_logs_insert($user_integral_have,$user_integral_find,$order_sn);
        //获取积分数据用来判断循环递归次数
        $rebate_all = $this->rebate_all();
        //递归查询获取层级关系结构
        $array = $this->tree_desc($rebate_all["integral_hierarchy"], $datalist["userid"]);
        //计算层级关系返利积分
        $this->user_insert_sum($array, $sale_rank_exc, $datalist["money"], $order_sn);
//            return $datalist;
    }

    /**
     * 计算层级关系返利积分
     * @param type $array 层级关系结果
     * @param type $user_id 要返利
     */
    private function user_insert_sum($array, $sale_rank_exc, $money, $order_sn) {
        if (count($array) > 0) {
            $data = $this->SaleIntegral->get_sale_integral_id(count($array));
            for ($i = 0; $i < count($array); $i++) {
                $user_list = $this->order_integral_user($array[$i]);
                if ($user_list["is_saler_auth"]!=0) {
                    //计算总积分
                    $user_integral = $user_list["integral"] + ($money * ($sale_rank_exc["rank"] / $sale_rank_exc["sale_key_value"])) * ($data["integral_" . ($i + 1)] / 100);
                    //计算获得积分
                    $user_integral_have = ($money * ($sale_rank_exc["rank"] / $sale_rank_exc["sale_key_value"])) * ($data["integral_" . ($i + 1)] / 100); //计算获取得积分
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
        $array[0] = $user_id;
        for ($i = count($out); $i > $j; $i--) {
            $array[] = $out[$i - 1];
        }
        return $array;
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
            $par_id = $this->InviteParent->get_invite_parent($user_id);
            if (empty($par_id["par_id"])) {
                return $out;
            }
            $out = $this->insert_tree($num - 1, $par_id["par_id"]);
        }
        $out[] = $par_id["par_id"];
        return $out;
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
        $param["source"] = 2;
        $param["uid"] = $userdata["id"];
        $param["relation_id"] = $relation_id;
        $param["order_sn"] = $order_sn;
        $param["create_time"] = time();
        if ($relation_id != 0) {
            $param["desc"] = "您获得返利积分" . floor($user_integral_flag);
        } else {
            $param["desc"] = "您的订单" . $order_sn . "已确认，获得积分" . floor($user_integral_flag);
        }
        $data = $this->Integral->add_integral($param);
        return $data;
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
            $param["desc"] = "您的订单" . $order_sn . "已确认，获得" . $name . "" . $user_integral_flag;
        } else {
            $param["desc"] = "您获得返利积分" . $name . "" . $user_integral_flag;
        }
        $data = $this->SaleLogs->add_sale_logs($param);
//            echo $this->SaleLogs->_sql();
        return $data;
    }

    /**
     * 通过用户ID查询相关用户积分数据
     * 表t_user
     */
    private function order_integral_user($user_id) {
        $data = $this->user->getUserByUserId($user_id);
        return $data;
    }

    /**
     * 修改用户积分
     * @param type $user_id 用户id
     * @param type $integral 修改积分数据
     * @return int 1成功，0失败
     */
    public function order_integral_user_update($user_id, $integral, $rank) {
        $data = $this->user->updateIntegralUserByUserId($user_id, $integral, $rank);
        if ($data) {
            return 1;
        } else {
            return 0;
        }
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
     * 查询消费积分返利比
     */
    private function sale_rank_exc_all() {
        $data = $this->SaleRankExc->get_sale_rank_exc_sale_key("GOODS");
        return $data;
    }

    /**
     * 订单列表  
     */
    public function ordergoodslists() {
        $type = isset($_GET['type']) ? $_GET['type'] : -1;
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        $region_arr = getcache('region', 'region');
        $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : 0;
        if (IS_POST) {
            $sqlmap = array();
            $field = "SUM(ordergoods.shop_number) AS number, 
				ordergoods.name AS sgoodsname,goodsproducts.spec_array,
				brand.name AS bname";
            $join = "
				LEFT JOIN s_goods_products AS goodsproducts ON goodsproducts.id= ordergoods.product_id 
				LEFT JOIN s_goods AS goods ON ordergoods.goods_id = goods.id
                                LEFT JOIN s_brand AS brand ON goods.brand_id = brand.id
                                LEFT JOIN s_order AS sorder ON ordergoods.order_id = sorder.id";
            //排序
            $_order = isset($_POST['order']) ? ($_POST['order']) : NULL;
            $_sort = isset($_POST['sort']) ? ($_POST['sort']) : NULL;
            if ($_order && $_sort) {
                $order[$_sort] = $_order;
            } else {
                $order['brand.name'] = 'DESC';
            }
            //筛选
            //分页
            $pagenum = isset($_GET['page']) ? intval($_GET['page']) : 1;
            $rowsnum = isset($_GET['rows']) && (int) ($_GET['rows']) != 0 ? intval($_GET['rows']) : PAGE_SIZE;
            //计算总数 
            $arraylist = $this->goods_db->alias('ordergoods')->join($join)->where($sqlmap)->group("ordergoods.goods_id,ordergoods.product_id")->order($order)->select();
            $data['total'] = count($arraylist);
            $data['rows'] = $this->goods_db->alias('ordergoods')->field($field)->join($join)->where($sqlmap)->limit(($pagenum - 1) * $rowsnum . ',' . $rowsnum)->group("ordergoods.goods_id,ordergoods.product_id")->order($order)->select();
            if (!$data['rows'])
                $data['rows'] = array();
            foreach ($data['rows'] as $k => $v) {
                $spec_array = unserialize($v["spec_array"]);
                foreach ($spec_array as $kk => $vv) {
//                                echo $vv["name"];
                    $data["rows"][$k]['name'] = $vv["name"];
                    $data["rows"][$k]['value'] = $vv["value"];
                }
            }
            echo json_encode($data);
        } else {
            include $this->admin_tpl('admin_order_goodslists');
        }
    }
    
    public function aaa(){
        echo floor("10.655");
    }

}
