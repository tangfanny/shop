<?php
class GoodsWeekSumModel extends SystemModel
{

    /**
     * 查询天表求和的数据
     * @return mixed
     */
    public function get_week_data(){
        $field = "g_name,b_name,gid,cid,bid,sum(real_sale),sum(sale_rate),sum(hit_rate),sum(real_hit),sum(display_hit),sum(display_sale)";
        $where = $this->week_time(7);
        $this->where($where)->delete();
        return model("goods_day_rank")->field($field)->where($where)->group('gid')->select();
    }

    /*
     * 时间获取
     * */
    public  function week_time($data){
        $date = date('w');
        //根据当前时间算出本周的开始时间和结束时间
        if ($date == 0) { //当今天为星期天的时候
            $start_time = $this->getTime($m="m",$d = date("d")+1-$data);  //上一周的末尾 也就是周一0点为开始时间
            $end_time =  $this->getTime();
        }elseif($data==1){//当今天为周一
            $start_time = $this->getTime($m="m",$d = date("d")-7);//上周一0点
            $end_time =  $this->getTime();
        }else{//当今天不为星期天的时候
            $start_time = $this->getTime($m="m",$d = date("d")-date("w")+1);//周一0点
            $end_time =  $this->getTime();
        }
        $where["time"]=array(array('egt',$start_time),array('elt',$end_time));
        return $where;
    }
    /*
        * 时间获取
         * */
    public function getTime($m = 'm',$d= 'd',$y= 'y'){
        return strtotime(date("Y-m-d H:i:s",mktime(0, 0 , 0,date($m),date($d),date($y))));
    }


    public function add_goods_week_rank($data){

        return $this->data($data)->add();
    }
    public function lastweek_data(){
        $end_time = $this->getTime($m="m",$d = date("d")-7);//上周日的0点为结束时间
        $start_time = $this->getTime($m="m",$d = date("d")+1-14);//上上周一的0点
        $where["time"]=array(array('egt',$start_time),array('elt',$end_time));
        return $this->where($where)->select();
    }


}