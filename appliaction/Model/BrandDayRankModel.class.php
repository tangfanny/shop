<?php
class BrandDayRankModel extends SystemModel
{

    public function get_day_data($bid){
        $field = 'bid,sum(display_sale) as display_sale,sum(display_hit) as display_hit';
        $where['bid'] = array('eq',$bid);
        return  $this->field($field)->where($where)->group('bid')->find();
    }
    public function add_brand_day_rank($data){
        $this->data($data)->add();
    }

    /**
     * 查询goods表的数据
     * @return mixed
     */
    public function get_goods_array(){
        $join = "LEFT JOIN  __BRAND__   AS b ON b.id=g.brand_id";
        $field="b.name as b_name, g.brand_id as bid,sum(g.display_sale) as display_sale,sum(g.buy_num) as real_sale,sum(g.display_hit) as display_hit,sum(g.hits) as real_hit";
        return model("goods")->alias("g")->field($field)->join($join)->where("g.brand_id != 0 AND g.status = 1")->group('g.brand_id')->select();
    }
    /*
     * 时间获取
     * */
    public function getTime($m = 'm',$d= 'd',$y= 'y'){
        return strtotime(date("Y-m-d H:i:s",mktime(0, 0 , 0,date($m),date($d),date($y))));
    }
    public function getField(){
        $field = "d.id as id,d.bid as bid,d.b_name as b_name,d.display_sale as display_sale,e.sale_rate  as sale_rate,d.display_hit as display_hit,d.real_hit as real_hit,d.real_sale as real_sale,e.hit_rate  as hit_rate";
        return $field;
    }

    public function yesterday_data(){
        $where['time'] = $this->getTime($m="m",$d = date("d")-1);//昨天0点
        return $this->where($where)->select();
    }


    public function count(){
        $count = $this->select();
        return count($count);
    }

}