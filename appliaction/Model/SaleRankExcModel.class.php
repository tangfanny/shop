<?php
/**
 * 设置积分兑换比例Model类
 *
 * @author 吴枫
 */
class SaleRankExcModel extends MysqlModel{
    //自动验证
    protected $_validate = array(
        array('sale_key_value', 'require', '数量必须填写！'),
        array('rank', 'require', '对应积分必须填写！'),
    );
  /**
   * 查询全部积分兑换比例
   * @return type
   */
   public function getSaleRankExcAll(){
      return  $this->order("id desc")->select();
   }
   /**
    * 根据设置积分兑换比例id进行查询，返回相应数据
    * @param type $id 设置积分兑换比例id
    * @return type 返回对应数据集合
    */
   public function getSaleRankExcById($id){
       $param["id"]=$id;
       return $this->where($param)->find();
       
   }
   /**
    * 根据设置积分返利比ID进行修改，相关数据
    * @param type $id 设置积分返利比ID
    * @param type $column 要修的字段的列的字段 
    * @return type
    */
   public function saveSaleRankExcById($id,$column){
       $param["id"]=$id;
       $data=  $this->where($param)->save($column);
       return $data;
   }
   
   /**
    * 通过数据字典查询积分返利比
    * @param type $sale_key 数据字典关键字
    * @return $data 积分返利比相关数据集合
    */
   public function get_sale_rank_exc_sale_key($sale_key){
       $param["sale_key"]=$sale_key;
       $data=  $this->where($param)->find();
       return $data;
   }
   
}

?>
