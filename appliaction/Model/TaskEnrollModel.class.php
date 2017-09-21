<?php
/**
 *
 * 众测报名表模型
 * @author TXL
 * @date 2016-4-27
 *
 */
class TaskEnrollModel extends MysqlModel
{
    public function getBmList($where, $order, $pagenum, $rowsnum)
    {
        $data = array();
        $data['total'] = $this->alias('a')->field('a.task_id')->join('__USER__ as b on a.uid = b.id')->where($where)->count();
        $data['rows'] = $this->alias('a')
            ->field('a.task_id,a.uid,a.ispass,a.create_time,b.nikename,b.mobile,b.email')
            ->join('__USER__ as b on a.uid = b.id')
            ->where($where)
            ->order($order)
            ->limit(($pagenum - 1) * $rowsnum . ',' . $rowsnum)
            ->select();
        return $data;
    }

}