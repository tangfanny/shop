<?php
class BrandRankEditModel extends SystemModel
{

    public function get_brand_rank_edit($brand_id){

        $param["brand_id"]=$brand_id;
        return $this->where($param)->find();

    }
    public function get_edit_data($where){
        $field = "id,sale_rate,sale_start_time,sale_end_time,hit_rate,hit_start_time,hit_end_time";
        return $this->field($field)->where($where)->find();
    }
}