<?php
class GoodsRankEditModel extends SystemModel
{
//    //自动验证
//    protected $_validate = array(
//        array('hit_rate', '^(0|[1-9][0-9]{0,2})$', '请填写1到3位数字！'),
//        array('sale_rate', '^(0|[1-9][0-9]{0,2})$', '请填写1到3位数字！'),
//    );


    public function get_goods_rank_edit($goods_id){

        $param["goods_id"]=array('eq',$goods_id);
        return $this->where($param)->find();

    }
    public function get_edit_data($where){
        $field = "id,sale_rate,sale_start_time,sale_end_time,hit_rate,hit_start_time,hit_end_time";
        return $this->field($field)->where($where)->find();
    }
    public function day_join_edit_data($sqlmap){
        $field = " edit.id,day.display_sale,day.display_hit,edit.sale_rate,edit.sale_start_time,edit.sale_end_time,edit.hit_rate,edit.hit_start_time,edit.hit_end_time";
        $join = 'LEFT JOIN __GOODS_RANK_EDIT__ AS edit ON day.gid = edit.goods_id';
        return model('goods_day_rank')->alias('day')->join($join)->field($field)->where($sqlmap)->find();
//        echo $this->alias('day')->join($join)->field($field)->where($sqlmap)->_sql();exit;
    }
}