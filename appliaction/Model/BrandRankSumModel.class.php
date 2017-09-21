<?php
class BrandRankSumModel extends SystemModel {
    public function addSumData(){
        $day = new GoodsDayRankModel();
        $data['re'] = $day->getDayData();
        foreach($data['re'] as $k=>$v){
            $info['real_sale'] = $data['re'][$k]['sum(real_sale)'];
            $info['real_hit'] = $data['re'][$k]['sum(real_hit)'];
            $info['bid'] = $data['re'][$k]['bid'];
            $info['display_hit'] = $data['re'][$k]['sum(display_hit)'];
            $info['display_sale'] = $data['re'][$k]['sum(display_sale)'];
            $re = $this->addAll($info);
        }
    }
    public function add_brand_rank_sum_data($data){

        return $this->data($data)->add();
    }
    public function delete_brand_rank_sum_data(){
        return $this->where("1=1")->delete();
    }
    /**
     * 查询天表求和的数据
     * @return mixed
     */
    public function get_rank_sum_data(){
        $field = "b_name,bid,sum(real_sale),sum(sale_rate),sum(hit_rate),sum(real_hit),sum(display_hit),sum(display_sale)";
        return model("brand_day_rank")->field($field)->group('bid')->select();
    }
}