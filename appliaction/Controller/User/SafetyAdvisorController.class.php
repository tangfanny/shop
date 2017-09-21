<?php

class SafetyAdvisorController extends AdminBaseController
{
    public function _initialize()
    {
        parent::_initialize();
        $this->model = model("SafetyAdvisor");
        $this->user = model("User");
    }

    public function index()
    {
        include $this->admin_tpl('sa_index');
    }

    /**
     * 安全顾问列表
     */
    public function lists()
    {
        if(IS_POST) {
            $page = I("post.page", 1);
            $rows = I("post.rows", 30);
            $keyword = I("post.keyword", '');
            $condition = array();
            if($keyword != '') {
                $condition['keyword'] = $keyword;
            }
            $data = $this->model->getList($page, $rows, $condition);
            echo json_encode($data);
        }
    }

    /**
     * 安全顾问详情
     */
    public function info()
    {
        $id = I("get.id", 0);
        $data = $this->model->getInfo($id);
        $uid = $data['uid'];
        $ac = D("AuthCertificate");
        $certs = $ac->getAdvisorCertifcate($uid);
        $certificate = array();
        foreach($certs as $c) {
            $certificate[] = $c['certificate'];
        }
        $data['certificate'] = $certificate;
        $this->assign('data', $data);
        include $this->admin_tpl('sa_info');
    }

    /**
     * 安全顾问认证 
     */
    public function auth()
    {
       if(IS_POST) {
           $id = I("post.id");
           $auth_status = I("post.auth_status");
           $message = I("post.message");
           if($this->model->auth($id, $auth_status, $message)) {
               $uid = $this->model->getUid($id);
               $data['is_safety_adviser'] = 1;
               $where['id'] = $uid;
               $user = $this->user->safety_adviser_save($where,$data);
               $this->redirect(U('index'));
           } else {
               echo 'false';
           }
       }
    }
}
