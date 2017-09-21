<?php
/**
 *
 * Yu Wei
 * 2016年4月24日
 */

class GoodsCateRelationModel extends Model
{
    
    public function updateCate($aid, $goods_id, $cate, $brand)
    {
        //删除商品所有品牌品类
        $this->deleteGoodsCate($goods_id);

        //添加变更后的品牌品类
        $data = array(
                'advisor_id' => $aid,
                'goods_id' => $goods_id,
                'type' => 0,
                'brand_cate_id' => 0
        );

        foreach($cate as $c) {
            $data['type'] = 1;
            $data['brand_cate_id'] = $c;
            $this->add($data);
        }

        foreach($brand as $b) {
            $data['type'] = 2;
            $data['brand_cate_id'] = $b;
            $this->add($data);
        }
    }

    //删除商品品牌品类
    public function deleteGoodsCate($goods_id)
    {
        $this->where('goods_id='.$goods_id)->delete();
    }
}