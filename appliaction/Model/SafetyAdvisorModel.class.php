<?php

class SafetyAdvisorModel extends MysqlModel
{

    public function getList($page, $page_size=PAGE_SIZE, $condition)
    {
        $start = ($page-1)*$page_size;
        $data = array('total' => 0, 'rows' => array());

        $map = array();
        if(is_array($condition) && count($condition) > 0) {
            $where['u.mobile'] = array('like', '%'.$condition['keyword']."%");
            $where['sa.name'] = array('like', "%".$condition['keyword']."%");
            $where['_logic'] = 'or';
            $map['_complex'] = $where;
        }

        $data['total'] = $this->Table('t_user u, t_safety_advisor sa')
            ->where('sa.uid=u.id')
            ->where($map)
            ->count();
        $data['rows'] = $this->Table('t_user u, t_safety_advisor sa')
            ->where('sa.uid=u.id')
            ->where($map)
            ->limit($start, $page_size)
            ->select();

        if($data['rows'] == null)
            $data['rows'] = array();
        return $data;
    }

    /**
     * 查询售前全部信息
     * 
     * @param unknown $id
     * @return unknown
     */
    public function getInfo($id)
    {
        $data = $this->Table('t_user u, t_safety_advisor sa')
            ->where('sa.uid=u.id and sa.id='.$id)
            ->select();
        return $data[0];
    }

    /**
     * 查询售前部分信息
     * @param unknown $id
     * @return unknown
     */
    public function getBriefInfo($id)
    {
        $data = $this->Table('t_user u, t_safety_advisor sa')
            ->where('sa.uid=u.id and sa.id='.$id)
            ->field("u.mobile, sa.name, sa.createtime")
            ->select();
//        echo $this->_sql();
        return $data[0];
    }

    public function auth($id, $status, $message)
    {
        $data = array();
        $data['auth_status'] = $status;
        $data['auth_message'] = $message;
        if($status == 1) {
            $now = time();
            $data['auth_time'] = $now;
            $data['authtime'] = date('Y-m-d H:i:s', $now);
        }
        return $this->where('id='.$id)->save($data);
    }

    /**
     * 查询用户ID
     * 
     * @param unknown $id
     * @return unknown
     */
    public function getUid($id)
    {
        $data = $this->Table('t_user u, t_safety_advisor sa')
            ->where('sa.uid=u.id and sa.id='.$id)
            ->getField('u.id');
        return $data;
    }

    /**
     * 条件查询 售前ID
     * @param unknown $keyword
     * @return unknown
     */
    public function getAdvisorByNameMobile($keyword, $page, $page_size)
    {
        $start = ($page-1)*$page_size;
        $data = $this->Table('t_user u, t_safety_advisor sa')
            ->where("sa.uid=u.id and (sa.name like '%{$keyword}%' or u.mobile like '%{$keyword}%')")
            ->limit($start, $page_size)
            ->select();
        //echo $this->getLastSql();
        return $data;
    }

    /**
     * 条件查询 售前ID
     * @param unknown $keyword
     * @return unknown
     */
    public function getAdvisorCountByNameMobile($keyword)
    {
        $data = $this->Table('t_user u, t_safety_advisor sa')
        ->where("sa.uid=u.id and (sa.name like '%{$keyword}%' or u.mobile like '%{$keyword}%')")
        ->count('sa.id');
        return $data;
    }
}