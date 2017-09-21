<?php
class GoodsRankSumModel extends SystemModel {
    public function  getAllData($where, $field,$id,$order,$page)
    {
        return  $this->field($field)->where($where)->where("status=1")->group($id)->order($order)->limit($page)->select();

    }
    public function total(){
        return $this->where('status=1')->count();
    }
    public function add_goods_rank_sum_data($data){
        return $this->data($data)->add();
    }

    public function delete_goods_rank_sum_data(){
         return $this->where("1=1")->delete();
    }
    /**
     * 查询天表求和的数据
     * @return mixed
     */
    public function get_rank_sum_data(){
        $field = "g_name,b_name,gid,cid,bid,sum(real_sale),sum(sale_rate),sum(hit_rate),sum(real_hit),sum(display_hit),sum(display_sale)";
        return model("goods_day_rank")->field($field)->group('gid')->select();
    }
}