<?php
/**
 *
 * 请愿表模型
 * @author TXL
 * @date 2016-5-11
 *
 */
class QyBugModel extends MysqlModel
{
    public function getBugList($where,  $pagenum, $rowsnum)
    {
        $data = array();
        $data['total'] = $this->alias('a')->field('a.idx')->join('__USER__ as b on b.id = a.uid')->where($where)->count();
        $data['rows'] = $this->alias('a')
            ->field('a.idx,a.title,a.test_ip,a.level,a.bug_class,b.email')
            ->join('__USER__ as b on b.id = a.uid')
            ->where($where)
            ->limit(($pagenum - 1) * $rowsnum . ',' . $rowsnum)
            ->select();
        return $data;
    }

    public function getBuginfoByidx($idx){
        return $this->where('idx='.$idx)->find();
    }
}