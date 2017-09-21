<?php
/**
 *
 * 请愿表模型
 * @author TXL
 * @date 2016-5-11
 *
 */
class TaskQyModel extends MysqlModel
{
    public function getQyList($where, $order, $pagenum, $rowsnum)
    {
        $data = array();
        $data['total'] = $this->alias('a')->field('a.idx')->join('t_user as b on b.id = a.uid')->where($where)->count();
        $data['rows'] = $this->alias('a')
            ->field('a.idx,a.title,a.create_time,a.ispass,a.isok,a.hits,a.logo,b.email,b.nikename')
            ->join('t_user as b on b.id = a.uid')
            ->where($where)
            ->order($order)
            ->limit(($pagenum - 1) * $rowsnum . ',' . $rowsnum)
            ->select();
        return $data;
    }

    public function getInfoByidx($idx){
        return $this->where('idx='.$idx)->find();
    }
}