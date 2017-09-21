<?php

class ServiceGoodsController extends AdminBaseController {

    public function _initialize() {
        parent::_initialize();
        $this->model = model('ServiceGoods');
        $this->skill = model("Skill");
        $this->brand = model("Brand");
    }

    public function index() {
        include $this->admin_tpl('index');
    }

    /**
     * 服务商品列表
     */
    public function lists() {
        //if(IS_POST) {
        $page = I("post.page", 1);
        $rows = I("post.rows", 30);

        $keyword = I("post.keyword", '');

        //有条件
        if ($keyword) {
            $saModel = model('SafetyAdvisor');
            //符合条件的售前,分页
            $sa_list = $saModel->getAdvisorByNameMobile($keyword, $page, ceil($rows / 3));
            //个数
            $count = $saModel->getAdvisorCountByNameMobile($keyword);
            $aids = array();
            foreach ($sa_list as $sa) {
                $aids[] = $sa['id'];
            }
            $data = $this->model->getListByAids($aids);
            $data['total'] = $count * 3;
            for ($i = 0; $i < count($data['rows']); $i++) {
                $row = $data['rows'][$i];
                $uinfo = model('SafetyAdvisor')->getBriefInfo($row['advisor_id']);
                $data['rows'][$i] = array_merge($row, $uinfo);
            }
        } else {
            $data = $this->model->getList($page, $rows);
            for ($i = 0; $i < count($data['rows']); $i++) {
                $row = $data['rows'][$i];
                $uinfo = model('SafetyAdvisor')->getBriefInfo($row['advisor_id']);
                $data['rows'][$i] = array_merge($row, $uinfo);
            }
        }
//         var_dump($data['rows']);
        echo json_encode($data);
        //}
    }

    /**
     * 服务商品详情
     */
    public function info() {
        $id = I("get.id", 0);
        $data = $this->model->getInfo($id);
        $uinfo = model('SafetyAdvisor')->getBriefInfo($data['advisor_id']);
        $certs = model('AuthCertificate')->getGoodsCertifcate($id);
        $certificate = array();
        foreach ($certs as $c) {
            $certificate[] = $c['certificate'];
        }
        $data['certificate'] = $certificate;
        $data = array_merge($data, $uinfo);
        $this->assign('data', $data);
        include $this->admin_tpl('info');
    }

    /**
     * 编辑商品
     */
    public function edit() {
        $id = I("get.id", 0);
        $data = $this->model->getInfo($id);
        $certificate = model("AuthCertificate")->getGoodsCertifcate($id);
        if ($certificate) {
            $data["certificate"] = $certificate;
        } else {
            $data["certificate"] = array();
        }
        $uinfo = model('SafetyAdvisor')->getBriefInfo($data['advisor_id']);
        $data = array_merge($data, $uinfo);
        //获取照片
        $this->assign('data', $data);
        //技能
        $skill_array = $this->skill->get_all_skill();
        $this->assign('skill_array', $skill_array);
        //品牌
        $brand_array = $this->brand->get_brand_all();
        $this->assign("brand_array", $brand_array);
        include $this->admin_tpl('edit');
    }

    /**
     * 更新提交
     */
    public function update() {
        if (IS_POST) {
            $id = I("post.id", 0);

            $data = array();
            $data['title'] = I("post.title", '');
            $data['price'] = I("post.price", 0);
            $data["detail_desc"] = I("post.detail_desc",'');
            $data["brief_desc"] = I("post.brief_desc","");
            $data['work_year'] = I("post.work_year", 0);
            $status = I("post.status");
            $cate = I("post.category");
            $brand = I("post.skill_array");

            $aid = Model('ServiceGoods')->getAdvisorId($id);
            Model('GoodsCateRelation')->updateCate($aid, $id, $cate, $brand);

            $this->model->updateInfo($id, $data);
            
            $this->model->changeStatus($id, $status);

            $this->redirect(U('index'));
        }
    }

    /**
     * 服务商品上下架
     */
    public function changeStatus() {
        if (IS_POST) {
            $id = I("post.id");
            $status = I("post.status");
            if ($this->model->changeStatus($id, $status)) {
                $this->redirect(U('index'));
            } else {
                echo '保存失败';
            }
        }
    }

}
