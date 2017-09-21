<?php
/**
 *   每天每周每月数据排行
 *
 */
class TimingController extends Action{

    private function getTime($m = 'm',$d= 'd',$y= 'y'){
        return strtotime(date("Y-m-d H:i:s",mktime(0, 0 , 0,date($m),date($d),date($y))));
    }

    private function testTime($date){

        return  strtotime(date("Y-m-d H:i:s", strtotime($date)));
    }

    //初始化goods表中显示人气和显示销量
//     public function sale(){
//         $field = "buy_num,hits,id";
//         $goods = D('Goods');
//         $info = $goods->field($field)->select();
//         foreach($info as $k=>$v){
//             $id['id'] =array('eq',$v['id']) ;
//             $data['display_hit'] = $v['hits'];
//             $data['display_sale'] = $v['buy_num'];
//             $goods->where($id)->save($data);
//         }
//     }

//    public function task_time_update(){
//        $qy = D('TaskQy');
//        $data['rows'] = $qy->field('creat_time,idx')->select();
//        foreach($data['rows'] as $k=>$v){
//            $info['creat_time'] = strtotime($v['creat_time']);
//            $qy->where('idx='.$v['idx'])->save($info);
//            echo $qy->_sql();die;
//        }
//    }

    //产品天汇总
    public function timing_day_rank(){
        $goods_data = D("GoodsDayRank");
        $goods_list = $goods_data->get_goods_array();
        $this->insert_goods_data_rank($goods_list);//同步数据进行初始化天表
    }
    /**
     * 同步goods_day_rank产品天汇总数据
     * @param $goods_list goods表中数据
     */
    private function insert_goods_data_rank($goods_list){
        $goods_data = D("GoodsDayRank");
        $goods_rank_edit = D("GoodsRankEdit");
//        var_dump($goods_list);die;
        foreach($goods_list as $k=>$v){
            $param["b_name"] = $v["b_name"];
            $param["g_name"] = $v["g_name"];
            $param["gid"] = $v["gid"];
            $param["bid"] = $v["bid"];
            $param["cid"] = $v["cid"];
            $param["real_hit"] = getData("goods.".$param["gid"]);
//             $param["real_hit"] = $v["real_hit"];
            $t_yester = $this->getTime($m = 'm',$d= date('d')-1);
            $t['time'] = array('eq',$t_yester);
//            $v['display_hit'] = getData("goods.".$param["gid"]);
            $data = $goods_data->where($t)->get_day_data($param["gid"]);
            $v['display_hit'] = $data['display_hit'];
            $v['display_sale'] = $data['display_sale'];
            $info = $goods_rank_edit->get_goods_rank_edit($v["gid"]);
            if($info){
                $time = time();
                //人气
                if($time >= $info['hit_start_time'] && $time<=$info['hit_end_time']){
                    $param['display_hit'] = round(($v['display_hit'] * $info['hit_rate'])/100).'%';
                    $param['display_hit'] = $v['display_hit']+$param['display_hit'];
                }else{
                    $param["display_hit"] = $v["display_hit"];
                }
                //销量
                if($time >= $info['sale_start_time'] && $time <= $info['sale_end_time']){
                    $param['display_sale'] = round(($v['display_sale'] * $info['sale_rate'])/100).'%';
                    $param['display_sale'] = $v['display_sale']+$param['display_sale'];
                }else{
                    $param['display_sale'] = $v['display_sale'] ;
                }
            }else{
                $param["display_hit"] = $v["display_hit"];
                $param['display_sale'] = $v['display_sale'] ;
            }
            $param["real_sale"] = $v["real_sale"];
            $param["status"] = $v["status"];
            $datatime = "0:0:0";//测试方法
            $date = $_GET["data"].$datatime;//测试方法
            $param["time"] = $this->testTime($date);//测试方法
//            $param["time"] = $this->getTime();//真实环境生产方法
            $goods_data->add_goods_day_rank($param);
        }
    }



    //产品周汇总
    public function timing_goods_week_rank(){

        $goods_data = D("GoodsWeekSum");
        $goods_list = $goods_data->get_week_data();
        $this->insert_get_week_data($goods_list);//同步数据进行初始化产品周汇总表

    }
    /**
     * 同步goods_week_sum产品周汇总数据
     * @param $goods_list goods_day_rank表中数据
     */
    private function insert_get_week_data($goods_list){
        $week_data = D("GoodsWeekSum");
        foreach($goods_list as $k=>$v){
            $param["b_name"] = $v["b_name"];
            $param["g_name"] = $v["g_name"];
            $param["gid"] = $v["gid"];
            $param["bid"] = $v["bid"];
            $param["cid"] = $v["cid"];
            $param["display_sale"] = $v["sum(real_sale)"];
            $param["real_sale"] = $v["sum(real_sale)"];
            $param["display_hit"] = $v["sum(display_hit)"];
            $param["real_hit"] = $v["sum(real_hit)"];
            $param["status"] = $v["status"];
            $param["time"] = $this->getTime($m="m",$d = date("d")-date("w")+1);
            $week_data->add_goods_week_rank($param);
        }
    }



    //产品月汇总
    public function timing_goods_month_rank(){

        $goods_data = D("GoodsMonthSum");
        $goods_list = $goods_data->get_month_data();
        $this->insert_get_month_data($goods_list);//同步数据进行初始化产品月汇总表

    }
    /**
     * 同步goods_month_sum产品月汇总数据
     * @param $goods_list goods_day_rank表中数据
     */
    private function insert_get_month_data($goods_list){
        $month_data = D("GoodsMonthSum");
        foreach($goods_list as $k=>$v){
            $param["b_name"] = $v["b_name"];
            $param["g_name"] = $v["g_name"];
            $param["gid"] = $v["gid"];
            $param["bid"] = $v["bid"];
            $param["cid"] = $v["cid"];
            $param["display_sale"] = $v["sum(real_sale)"];
            $param["real_sale"] = $v["sum(real_sale)"];
            $param["display_hit"] = $v["sum(display_hit)"];
            $param["real_hit"] = $v["sum(real_hit)"];
            $param["status"] = $v["status"];
            $param["time"] = $this->getTime($m="m",$d = 1);
            $month_data->add_goods_month_rank($param);
        }
    }



    //产品全部汇总
    public function timing_goods_sum_rank(){
        $goods_data = D("GoodsRankSum");
        $goods_list = $goods_data->get_rank_sum_data();
        $goods_data->delete_goods_rank_sum_data();
        $this->insert_goods_sum_data($goods_list);//同步数据进行初始化产品全部汇总表

    }
    /**
     * 同步goods_rank_sum产品全部汇总数据
     * @param $goods_list goods_day_rank表中数据
     */
    private function insert_goods_sum_data($goods_list){
        $month_data = D("GoodsRankSum");
        foreach($goods_list as $k=>$v){
            $param["b_name"] = $v["b_name"];
            $param["g_name"] = $v["g_name"];
            $param["gid"] = $v["gid"];
            $param["bid"] = $v["bid"];
            $param["cid"] = $v["cid"];
            $param["display_sale"] = $v["sum(real_sale)"];
            $param["real_sale"] = $v["sum(real_sale)"];
            $param["display_hit"] = $v["sum(display_hit)"];
            $param["real_hit"] = $v["sum(real_hit)"];
            $param["status"] = $v["status"];
            $where['gid'] = array('eq',$v['gid']);
            $month_data->add_goods_rank_sum_data($param);
        }
    }



    //品牌天汇总
    public function b_timing_day_rank(){

        $brand_data = D("BrandDayRank");
        $brand_list = $brand_data->get_goods_array();
        $this->insert_brand_data_rank($brand_list);//同步数据进行初始化品牌天汇总表
    }
    /**
     * 同步brand_day_rank品牌天汇总数据
     * @param $goods_list goods表中数据
     */
    private function insert_brand_data_rank($brand_list){
        $brand_data = D("BrandDayRank");
        $brand_rank_edit = D("BrandRankEdit");
        foreach($brand_list as $k=>$v){
            $param["b_name"] = $v["b_name"];
            $param["bid"] = $v["bid"];
            $param["real_hit"] = getData("brand.".$param["bid"]);
//             $param["real_hit"] = $v["real_hit"];
            $t_yester = $this->getTime($m = 'm',$d= date('d')-1);
            $t['time'] = array('eq',$t_yester);
//            $v['display_hit'] = getData("goods.".$param["gid"]);
            $data = $brand_data->where($t)->get_day_data($param["bid"]);
            $v['display_hit'] = $data['display_hit'];
            $v['display_sale'] = $data['display_sale'];
            $info = $brand_rank_edit->get_brand_rank_edit($v["bid"]);
            if($info){
                $time = time();
                //人气
                if($time >= $info['hit_start_time'] && $time<=$info['hit_end_time']){
                    $param['display_hit'] = round(($v['display_hit'] * $info['hit_rate'])/100).'%';
                    $param['display_hit'] = $v['display_hit']+$param['display_hit'];
                }else{
                    $param["display_hit"] = $v["display_hit"];
                }
                //销量
                if($time >= $info['sale_start_time'] && $time <= $info['sale_end_time']){
                    $param['display_sale'] = round(($v['display_sale'] * $info['sale_rate'])/100).'%';
                    $param['display_sale'] = $v['display_sale']+$param['display_sale'];
                }else{
                    $param['display_sale'] = $v['display_sale'] ;
                }
            }else{
                $param["display_hit"] = $v["display_hit"];
                $param['display_sale'] = $v['display_sale'] ;
            }
            $param["real_sale"] = $v["real_sale"];
//            $param["real_hit"] = $v["real_hit"];
            $param["status"] = $v["status"];
            $datatime = "0:0:0";//测试方法
            $date = $_GET["data"].$datatime;//测试方法
            $param["time"] = $this->testTime($date);//测试方法
            $brand_data->add_brand_day_rank($param);
        }
    }



    //品牌周汇总
    public function timing_brand_week_rank(){

        $brand_data = D("BrandWeekSum");
        $brand_list = $brand_data->get_week_data();
        $this->insert_brand_week_data($brand_list);//同步数据进行初始化品牌周汇总表

    }
    /**
     * 同步brand_week_sum品牌周汇总数据
     * @param $goods_list brand_day_rank表中数据
     */
    private function insert_brand_week_data($brand_list){
        $week_data = D("BrandWeekSum");
        foreach($brand_list as $k=>$v){
            $param["b_name"] = $v["b_name"];
            $param["bid"] = $v["bid"];
            $param["display_sale"] = $v["sum(real_sale)"];
            $param["real_sale"] = $v["sum(real_sale)"];
            $param["display_hit"] = $v["sum(display_hit)"];
            $param["real_hit"] = $v["sum(real_hit)"];
            $param["status"] = $v["status"];
            $param["time"] = $this->getTime($m="m",$d = date("d")-date("w")+1);
            $week_data->add_brand_week_rank($param);
        }
    }



    //品牌月汇总
    public function timing_brand_month_rank(){

        $brand_data = D("BrandMonthSum");
        $brand_list = $brand_data->get_month_data();
        $this->insert_brand_month_data($brand_list);//同步数据进行初始化品牌月汇总表

    }
    /**
     * 同步brand_month_sum品牌月汇总数据
     * @param $goods_list brand_day_rank表中数据
     */
    private function insert_brand_month_data($brand_list){
        $month_data = D("BrandMonthSum");
        foreach($brand_list as $k=>$v){
            $param["b_name"] = $v["b_name"];
            $param["bid"] = $v["bid"];
            $param["display_sale"] = $v["sum(real_sale)"];
            $param["real_sale"] = $v["sum(real_sale)"];
            $param["display_hit"] = $v["sum(display_hit)"];
            $param["real_hit"] = $v["sum(real_hit)"];
            $param["status"] = $v["status"];
            $param["time"] = $this->getTime($m="m",$d = 1);
            $month_data->add_brand_month_rank($param);
        }
    }



    //品牌全部汇总
    public function timing_brand_sum_rank(){

        $brand_data = D("BrandRankSum");
        $brand_list = $brand_data->get_rank_sum_data();
        $brand_data->delete_brand_rank_sum_data();
        $this->insert_brand_sum_data($brand_list);//同步数据进行初始化品牌全部汇总表

    }
    /**
     * 同步goods_rank_sum品牌全部汇总数据
     * @param $goods_list goods_day_rank表中数据
     */
    private function insert_brand_sum_data($brand_list){
        $month_data = D("BrandRankSum");
        foreach($brand_list as $k=>$v){
            $param["b_name"] = $v["b_name"];
            $param["g_name"] = $v["g_name"];
            $param["gid"] = $v["gid"];
            $param["bid"] = $v["bid"];
            $param["cid"] = $v["cid"];
            $param["display_sale"] = $v["sum(real_sale)"];
            $param["real_sale"] = $v["sum(real_sale)"];
            $param["display_hit"] = $v["sum(display_hit)"];
            $param["real_hit"] = $v["sum(real_hit)"];
            $param["status"] = $v["status"];
            $month_data->add_brand_rank_sum_data($param);
        }
    }

}


?>
