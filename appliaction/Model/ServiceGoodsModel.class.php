<?php

class ServiceGoodsModel extends Model {

    /**
     * 商品列表
     * 
     * @param unknown $page
     * @param string $page_size
     */
    public function getList($page, $page_size = PAGE_SIZE) {
        $start = ($page - 1) * $page_size;
        $data = array('total' => 0, 'rows' => array());

        $data['total'] = $this->count();
        $rows = $this->limit($start, $page_size)->select();

        //查询品类，品牌名称
        for ($i = 0; $i < count($rows); $i++) {
            $gid = $rows[$i]['id'];

            $map = array();
            $map['gcr.goods_id'] = $gid;
            $b_c = $this->Table('t_goods_cate_relation gcr, t_skill gc')
                    ->field('name,type')
                    ->where('gcr.brand_cate_id = gc.id')
                    ->where($map)
                    ->select();

            //品牌
            $s_c = $this->Table('t_goods_cate_relation gcr, t_brand gc')
                    ->field('id,name,type')
                    ->where('gcr.brand_cate_id = gc.id and gcr.type=2')
                    ->where($map)
                    ->select();

            if ($b_c) {
                $rows[$i]['category'] = $b_c;
                
            } else {
                $rows[$i]['category'] = array();
               
            }
            if($s_c){
                $rows[$i]['brand'] = $s_c;
            }else{
                 $rows[$i]['brand'] = array();
            }
        }

        $data['rows'] = $rows;

        if ($data['rows'] == null)
            $data['rows'] = array();
        return $data;
    }

    /**
     * 商品查询列表
     *
     * @param unknown $page
     * @param string $page_size
     */
    public function getListByAids($aids) {
        $start = ($page - 1) * $page_size;
        $data = array('total' => 0, 'rows' => array());

        $map['advisor_id'] = array('in', implode(',', $aids));
        $rows = $this->where($map)->select();

        //查询品类，品牌名称
        for ($i = 0; $i < count($rows); $i++) {
            $gid = $rows[$i]['id'];

            $map = array();
            $map['gcr.goods_id'] = $gid;
            $b_c = $this->Table('t_goods_cate_relation gcr, t_goods_category gc')
                    ->field('name,type')
                    ->where('gcr.brand_cate_id = gc.id')
                    ->where($map)
                    ->select();
            if ($b_c) {
                $rows[$i]['category'] = $b_c;
                $rows[$i]['brand'] = $b_c;
            } else {
                $rows[$i]['category'] = array();
                $rows[$i]['brand'] = array();
            }
        }

        $data['rows'] = $rows;

        if ($data['rows'] == null)
            $data['rows'] = array();
        return $data;
    }

    public function getInfo($id) {
        $data = $this->where('id=' . $id)->select();
        $map = array();
        $map['gcr.goods_id'] = $id;
        //技能
        $b_c = $this->Table('t_goods_cate_relation gcr, t_skill gc')
                ->field('id,name,type')
                ->where('gcr.brand_cate_id = gc.id and gcr.type=1')
                ->where($map)
                ->select();
        //品牌
        $s_c = $this->Table('t_goods_cate_relation gcr, t_brand gc')
                ->field('id,name,type')
                ->where('gcr.brand_cate_id = gc.id and gcr.type=2')
                ->where($map)
                ->select();
        if ($b_c) {
            $data[0]['category'] = $b_c;
        } else {
            $data[0]['category'] = array();
        }
        if ($s_c) {
            $data[0]["brand"] = $s_c;
        } else {
            $data[0]["brand"] = array();
        }
        return $data[0];
    }

    public function changeStatus($id, $status) {
        $data = array();
        $data['goods_status'] = $status;
        return $this->where('id=' . $id)->save($data);
    }

    public function updateInfo($id, $data) {
        return $this->where('id=' . $id)->save($data);
    }

    public function getAdvisorId($goods_id) {
        return $this->where('id=' . $goods_id)->getField('advisor_id');
    }

}

