<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OrderDdController
 *
 * @author Administrator
 */
class OrderDdController extends AdminBaseController{
    //put your code here
    public function _initialize() {
                parent::_initialize();
		$this->db = model('order');
		$this->log_db = model('order_log');
		$this->order_goods = model('order_goods');
		$this->parcel_db=model('order_parcel');
                $this->goods_kc = model("goods_products");
                $this->goods = model("goods");
                $this->_order_staging = model('order_staging');//订单分期表查询
                $this->_order_pact =model("order_pact");//订单合同表查询
                $this->_order_goods_staging=model("order_goods_staging");//订单商品分期表
                $this->user=  model("User");
                $this->order = model("Order");
        }
        
        public function daoru(){
           include $this->admin_tpl('daoru');
        }
        
        public function save_daoru(){
            $mobile = $_POST["mobile"];
            $user_list = $this->user->get_user_mobile($mobile);
//            if(!$user_list){
//                showmessage("用户手机号查询不到！",NULL,0);
//            }else{
                $order_sn = $_POST["order_sn"];
                $param["order_sn"]=$order_sn;
                $param["user_id"]=$user_list["id"];
                $param["pay_code"]=1;
                $param["delivery_id"]=14;
                $param["delivery_txt"]="客户自取";
                $param["source"]=0;
                $param["order_status"]=0;
                $param["pay_status"]=0;
                $param["pay_type"]=1;
                $param["delivery_status"]=0;
                $param["accept_name"]=  base64_encode($_POST["accept_name"]);
                $param["mobile"]= base64_encode($_POST["mobile"]);
                $param["zipcode"]=  base64_encode($_POST["zipcode"]);
                $param["telphone"] = base64_encode($_POST["telphone"]);
                $param["province"] = base64_encode($_POST["province"]);
                $param["city"] = base64_encode($_POST["city"]);
                $param["area"] = base64_encode($_POST["area"]);
                $param["address"] = base64_encode($_POST["address"]);
                $param["payable_amount"] =$_POST["payable_amount"];
                $param["real_amount"] =$_POST["payable_amount"];
                $param["create_time"] =strtotime($_POST["cretae_time"]);
                $order_id =  $this->order->add_order($param);
                if($order_id){
                    $staging_array=explode(",",$_POST["staging"]);//分期百分比
                    $staging_money_array =  explode(",", $_POST["staging_money"]);//分期金额
                    $goods_name_array = explode(",", $_POST["goods_name"]);//商品名称
                    $goods_num_array = explode(",", $_POST["goods_num"]);//购买数量
                    $products_sn_array = explode(",", $_POST["products_sn"]);//规格编号
                    foreach ($goods_name_array as $k=>$v){
                        $goods_data_array = $this->goods->get_goods_name($v);
                        $order_goods_param["order_id"] = $order_id;
                        $order_goods_param["user_id"] = $user_list["id"];
                        $order_goods_param["goods_id"]=$goods_data_array["id"];
                        $order_goods_param["thumb"] = $goods_data_array["thumb"];
                        $order_goods_param["name"] = $goods_data_array["name"];
                        $order_goods_param["shop_number"] = $goods_num_array[$k];
                        $goods_products = $products_sn_array[$k];
                        $order_products_array =  $this->goods_kc->get_goods_products_sn($goods_products);
                        $order_goods_param["product_id"] = $order_products_array["id"];
                        $order_goods_param["dateline"] = $param["create_time"];
                        $order_goods_param["spec_array"]= $order_products_array["spec_array"];
                        $order_goods_param["status"] = 1;
                        $order_goods_param["shop_price"] = $order_products_array["market_price"]*$goods_num_array[$k];
                        $order_goods_id=$this->order_goods->insert_order_goods($order_goods_param);
                        foreach ($staging_array as $k1=>$v1){
                            $order_goods_staging["user_id"] = $user_list["id"];
                            $order_goods_staging["goods_id"] =$goods_data_array["id"];
                            $order_goods_staging["order_goods_id"]=$order_goods_id;
                            $order_goods_staging["order_id"]=$order_id;
                            $order_goods_staging["products_id"]=$order_products_array["id"];
                            $order_goods_staging["name"]=$goods_data_array["name"];
                            $order_goods_staging["dateline"]=$param["create_time"];
                            $order_goods_staging["staging_percent"] = $v1;
                            $order_goods_staging["staging_num"] = ($k1+1);
                            $order_goods_staging["money"] = $order_goods_param["shop_price"]*($v1/100);
                            $order_goods_staging["pay_time"]=$param["cretae_time"];
                            $order_goods_staging["pay_flag"]=1;
                            $this->_order_goods_staging->insert_order_goods_staging($order_goods_staging);
                        }
                    }
                    foreach ($staging_money_array as $k2=>$v2){
                        $order_staging["orderid"]=$order_id;
                        $order_staging["staging_type"]=0;
                        $order_staging["staging_percent"]=$staging_array[$k2];
                        $order_staging["money"]=$v2;
                        $order_staging["payment_time"]=$param["create_time"];
                        $order_staging["payment_money"]=$v2;
                        $order_staging["create_time"]=$param["create_time"];
                        $order_staging["pay_status"]=1;
                        $order_staging["staging_num"]=($k2+1);
                        $this->_order_staging->insert_order_staging($order_staging);
                    }
                    showmessage('操作成功', '', 1);
               }else{
                   showmessage('操作失败');
               }
            }
}
?>
