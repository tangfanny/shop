<?php
/**
 *
 * 众测漏洞表模型
 * @author TXL
 * @date 2016-5-4
 *
 */
class TaskBugModel extends MysqlModel
{
    public function getBugList($where, $pagenum, $rowsnum)
    {
        $data = array();
        $data['total'] = $this->alias('a')->field('a.idx')->join('t_user as b on b.id = a.uid')->where($where)->count();
        $data['rows'] = $this->alias('a')
            ->field('a.idx,a.bugid,a.title,a.test_ip,a.level,a.bug_class,b.email')
            ->join('t_user as b on b.id = a.uid')
            ->where($where)
            ->limit(($pagenum - 1) * $rowsnum . ',' . $rowsnum)
            ->select();
        return $data;
    }

    public function getBugInfo($bugid)
    {
        return $this->where('bugid='.$bugid)->find();
    }


}
