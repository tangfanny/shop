<?php

class ActivityNavController extends AdminBaseController {

	public function _initialize() {
        parent::_initialize();
        $this->comp = M('act_comp'); //部件实例
        $this->nav = model('ActivityNav'); //导航实例
        $this->banner = model('ActivityBanner');
        $this->tag = model('goods_label');
    }

    /**
     * 导航展现
     * @param  [type] $id [活动ID]
     * @return [type]     [description]
     */
    public function navList($id){
        if(IS_POST){
            if(!empty($id) && is_numeric($id)){
                //var_dump($this->nav);
                $arrN = $this->nav->where('aid='.$id)->select();//导航
                foreach($arrN as $k=>$v){
                    $arrC = $this->comp->where('id='.$v['cid'])->find();
                    $arrN[$k]['com'] = $arrC;
                }
                echo json_encode($arrN);
            }else{
                showmessage('关键参数出错',NULL,0);
            }            
        }else{
            include $this->admin_tpl('activity_nav_list');  
        }
    }

    /**
     * 获取部件列表
     * @return [type] [description]
     */
    public function compList(){
        if(IS_POST){
            $arrC = $this->comp->select();
            echo json_encode($arrC);
        }else{
           showmessage('关键参数出错',NULL,0); 
        }
    }

    /**
     * 导航发布
     * @return 3456     [description]
     */
    public function navUpdate($id){
        $opt = $_GET['opt'];
        $id = $_GET['id'];
        if(IS_POST){
                $this->navsave();
        }else{
            if(isset($opt) && $opt){
                //编辑
                if($opt=='update' && $id>0){
                    $info = $this->nav->where('id='.$id)->find();
//                    var_dump($info);die;
                    $this->info = $info ;
                }
                //删除
                if($opt == 'del' && $id ){
                    unset($where);
                    $where['id']=array('in',$id);
                    $this->nav->where($where)->delete();
                    showmessage('恭喜你，删除成功！',U('ActivityNav/navList'),1); 
                }
                //修改状态
                if($opt == 'ajax_status' && $id ){
                    unset($where);
                    $data['status']=array('exp',' 1-is_show ');;
                    $this->nav->where('id='.$id)->save($data);
                    showmessage('恭喜你，成功改变状态！',U('ActivityNav/navList'),1); 
                }
                include $this->admin_tpl('activity_nav_edit');
            }else{
                showmessage('参数错误,请联系管理员!',NULL,0);
            }
        } 

    }


    /**
     *	  保存
     */
    protected function navsave(){
        $id = $_POST['id'];
        $_POST = daddslashes($_POST);
        //处理
        if (isset($id) && $id) {
            if ($this->nav->create()) {
                $this->nav->save();
                showmessage("修改导航成功", U('ActivityNav/navList',array('id'=>$_POST['aid'])),1);
            } else {
                $this->error($this->nav->getError(),U('ActivityNav/navList',array('id'=>$_POST['id'])),0);
            }
        } else {

            if($this->nav->create($_POST)){

                $this->nav->add();
                showmessage("添加导航成功", U('ActivityNav/navList',array('id'=>$_POST['aid'])),1);
            }else{
                showmessage($this->nav->getError(), U('ActivityNav/navList',array('id'=>$_POST['aid'])),0);
            }
        }
    }

    /**
     * 设置Banner图片展示
     * @param [type] $id [description]
     */
    public function bannerDisplay($id){
        if(!empty($id) && is_numeric($id)){
            $data = $this->banner->select();
            include $this->admin_tpl('activity_banner_list');
        }else{
            showmessage('关键参数错误',NULL,0);
        }
    }

    /**
     * Banner 图片展示
     * @param [type] $id [description]
     */
    public function bannerList($id){
        if(IS_POST){
            if(!empty($id) && is_numeric($id)){
                $order['rankid'] = 'ASC';
                $arr = $this->banner->where('aid='.$id)->order($order)->select();
                echo json_encode($arr);
            }else{
                showmessage('关键参数错误',NULL,0);
            }
        }else{
            include $this->admin_tpl('activity_banner_list');  
        }
    }




    /**
     * 保存，删除Banner
     * @param [type] $id [Banner主键ID]
     */
    public function bannerUpdate($id){
        $opt = $_GET['opt'];
        $id = $_GET['id'];
        if(IS_POST){
                $this->save();
        }else{
            if(isset($opt) && $opt){
                //编辑
                if($opt=='update' && $id>0){
                    $info = $this->banner->where('id='.$id)->find();
                    $this->info = $info ;
                }
                //删除
                if($opt == 'del' && $id ){
                    unset($where);
                    $where['id']=array('in',$id);
                    $this->banner->where($where)->delete();
                    showmessage('恭喜你，删除成功！',U('ActivityNav/BannerList'),1);
                }
                //修改状态
                if($opt == 'ajax_status' && $id ){
                    unset($where);
                    $data['is_show']=array('exp',' 1-is_show ');;
                    $this->banner->where('id='.$id)->save($data);
                    showmessage('恭喜你，成功改变状态！',U('ActivityNav/BannerList'),1); 
                }
                include $this->admin_tpl('activity_banner_edit');
            }else{
                showmessage('参数错误,请联系管理员!',NULL,0);
            }
        }  
    }



    /**
     *	  保存
     */
    protected function save(){
        $id = $_POST['id'];
        $_POST['addtime']=strtotime(I('addtime'));
        $_POST = daddslashes($_POST);
        //处理
        if (isset($id) && $id) {
            if ($this->banner->create()) {
                $this->banner->save();
                showmessage("修改banner成功", U('ActivityNav/BannerList',array('id'=>$_POST['aid'])),1);
            } else {
                $this->error($this->banner->getError(),U('ActivityNav/BannerList',array('id'=>$_POST['id'])),0);
            }
        } else {

            if($this->banner->create($_POST)){

                $this->banner->add();
//                var_dump($_POST);die;
                showmessage("添加banner成功", U('ActivityNav/BannerList',array('id'=>$_POST['aid'])),1);
            }else{
                showmessage($this->banner->getError(), U('ActivityNav/BannerList',array('id'=>$_POST['aid'])),0);
            }
        }
    }

    /**
     * 活动标签
     * @return [type] [description]
     */
    public function taglists(){
        if(IS_POST){
                //var_dump($this->nav);
                $arrT = $this->tag->select();//导航
                echo json_encode($arrT);          
        }else{
            include $this->admin_tpl('activity_tag_list');  
        }
    }



    public function tagUpdate(){
        $opt = $_GET['opt'];
        $id=I("id",0);
        if(IS_POST){
            $this->tagsave();
        }else{
            if(isset($opt) && $opt){
                //编辑
                if($opt=='update' && $id>0){
                    $info = $this->tag->where('id='.$id)->find();
                    $this->info = $info ;
                }
                //删除
                if($opt == 'del' && $id ){
                    unset($where);
                    $where['id']=array('in',$id);
                    $this->tag->where($where)->delete();
                    showmessage('恭喜你，删除成功！',U('ActivityNav/taglists'),1);
                }
                //修改状态
                if($opt == 'ajax_status' && $id ){
                    unset($where);
                    $data['status']=array('exp',' 1-status ');;
                    $this->tag->where('id='.$id)->save($data);
                    showmessage('恭喜你，成功改变状态！',U('ActivityNav/taglists'),1); 
                }
                include $this->admin_tpl('activity_tag_edit');
            }else{
                showmessage('参数错误,请联系管理员!',NULL,0);
            }
        }        
    }


    /**
     *	  保存
     */
    protected function tagsave(){
        $id = $_POST['id'];
        $_POST = daddslashes($_POST);
        //处理
        if (isset($id) && $id) {
            if ($this->tag->create()) {
                $this->tag->save();
                showmessage("修改标签成功", U('ActivityNav/taglists',array('id'=>$_POST['aid'])),1);
            } else {
                $this->error($this->tag->getError(),U('ActivityNav/taglists',array('id'=>$_POST['id'])),0);
            }
        } else {

            if($this->tag->create($_POST)){

                $this->tag->add();
                showmessage("添加标签成功", U('ActivityNav/taglists',array('id'=>$_POST['aid'])),1);
            }else{
                showmessage($this->tag->getError(), U('ActivityNav/taglists',array('id'=>$_POST['aid'])),0);
            }
        }
    }
}



?>