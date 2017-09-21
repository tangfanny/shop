<?php

/*
 * 会员发票模型
 */
class BillInvoiceModel extends MysqlModel{
    /**
     * 根据用户ID获取相关用户的填写发票查询
     * @param type $user_id 用户id
     * @param type $pagenum 起始页面
     * @param type $rowsnum 每页显示的总条数
     * @return type 发票结果集合
     */
    public function getInvoiceList($user_id,$pagenum,$rowsnum){
        $where[uid]=$user_id;
        $data = $this->where($where)->limit(($pagenum-1)*$rowsnum.','.$rowsnum)->select();
        return $data;
    }
    /**
     * 统计用户填写发票数量
     * @param type $user_id 用户id
     * @return type 返回总记录数
     */
    public function getCount($user_id){
        $where["uid"]=$user_id;
        $data = $this->where($where)->count();
        return $data;
    }
}
?>
