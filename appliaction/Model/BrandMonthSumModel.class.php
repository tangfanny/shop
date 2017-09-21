<?php
class BrandMonthSumModel extends SystemModel
{

    /*
  * 时间获取
  * */
    public function getTime($m = 'm',$d= 'd',$y= 'y'){
        return strtotime(date("Y-m-d H:i:s",mktime(0, 0 , 0,date($m),date($d),date($y))));
    }
    public function add_brand_month_rank($data){

        return $this->data($data)->add();
    }

    /**
     * 查询天表求和的数据
     * @return mixed
     */
    public function get_month_data(){
        $field = "b_name,bid,sum(real_sale),sum(sale_rate),sum(hit_rate),sum(real_hit),sum(display_hit),sum(display_sale)";
        $where = $this->month_time();
        $this->where($where)->delete();
        return model("brand_day_rank")->field($field)->where($where)->group('bid')->select();
    }
    public  function month_time()
    {
        //求出当前几号
        $date = date("d");
        $year= date("Y");
        //根据当前时间算出本月的开始时间和结束时间
        //当今天为月末date("t")的时候
        if ($date == date("t")) {
            $end_time = $this->getTime($m="m",$d = date("t"));  //当前时间月末0点为结束时间
            $start_time = $this->getTime($m="m",$d = 1);  //月初0点为开始时间
        }else{//当今天不为月末的时候
            $end_time = $this->getTime(); //今天0点为结束时间
            $start_time = $this->getTime($m="m",$d = 1);  //月初0点为开始时间
        }
        $where["time"]=array(array('egt',$start_time),array('elt',$end_time));
        return $where;
    }

    public function lastmonth_data(){
        //求出当前几号
        $end_time = $this->getTime($m="m",$d = 1);//上月的月末为结束时间
        $start_time = $this->getTime($m=date("m")-1,$d = 1);//上月月初为开始时间
        $where["time"]=array(array('egt',$start_time),array('elt',$end_time));
        return $this->where($where)->select();
    }

}