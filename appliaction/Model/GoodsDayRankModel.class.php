<?php
class GoodsDayRankModel extends SystemModel
{

    public function get_day_data($gid){
        $field = 'display_sale,display_hit';
        $where['gid'] = array('eq',$gid);
        return  $this->field($field)->where($where)->find();
    }

    public function add_goods_day_rank($data){

      return $this->add($data);

    }
    /**
     * 查询goods表的数据
     * @return mixed
     */
    public function get_goods_array(){
        $join = "LEFT JOIN __BRAND__   AS b ON b.id=g.brand_id";
        $field="b.name as b_name, g.name  as g_name, g.id as gid ,g.brand_id as bid
                ,g.cat_ids  as cid,g.display_sale as display_sale,g.buy_num as real_sale,g.display_hit as display_hit,g.status as status
                ";
         return model("goods")->alias("g")->field($field)->join($join)->where("g.brand_id != 0 AND g.status = 1")->select();
    }
    /*
   * 时间获取
   * */
    public function getTime($m = 'm',$d= 'd',$y= 'y'){
        return strtotime(date("Y-m-d H:i:s",mktime(0, 0 , 0,date($m),date($d),date($y))));
    }
    public function getField(){
        $field = "d.id as id,d.cid as cid,d.g_name as g_name,d.gid as gid,d.bid as bid,d.b_name as b_name,d.display_sale as display_sale,e.sale_rate  as sale_rate,d.display_hit as display_hit,d.real_hit as real_hit,d.real_sale as real_sale,e.hit_rate  as hit_rate";
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