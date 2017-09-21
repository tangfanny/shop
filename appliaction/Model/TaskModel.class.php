<?php
/**
 *
 * 众测表模型
 * @author TXL
 * @date 2016-4-27
 *
 */
class TaskModel extends MysqlModel
{
    public function getTaskList($where, $order, $pagenum, $rowsnum)
    {
        $data = array();
        $data['total'] = $this->alias('a')->field('a.task_id')->join('__USER__ as b on a.create_user_id = b.id')->where($where)->count();
        $data['rows'] = $this->alias('a')
            ->field('a.task_id,a.title,a.sec_price,a.pub_status,a.create_time,b.mobile,b.email')
            ->join('__USER__ as b on a.create_user_id = b.id')
            ->where($where)
            ->order($order)
            ->limit(($pagenum - 1) * $rowsnum . ',' . $rowsnum)
            ->select();
        return $data;
    }

    public function getInfoByTaskid($taskid){
        return $this->where('task_id='.$taskid)->find();
    }

}