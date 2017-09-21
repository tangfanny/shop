<?php

class ActivityController extends AdminBaseController {

    public function _initialize() {
        parent::_initialize();
        $this->act_list = M('act_list');
        $this->act_attr = M('act_attr');
        $this->temp = M('act_temp');
        $this->aimg = model('ActivityImages');
        $this->banner = M('act_banner');
        $this->goods = M('act_goods');
        $this->nav = M('act_nav');
        $this->comp = M('act_comp');
        $this->tag = M('goods_label');
        $this->ingoods = M('goods');
        $this->aimage = M('act_img');
    }

    public function index($id){
        if(!empty($id)&& is_numeric($id)){
            
            $banner = $this->banner->where('aid='.$id)->find();
            $nav = $this->nav->where('aid='.$id)->select();//导航

            $aimg = $this->aimg->where('aid='.$id)->order('cid asc')->select(); //图片部件
            foreach($aimg as $k=>$v){
                $arr[$v['cid']][] = $aimg[$k];
            }
            $goods = $this->goods->where(array('aid'=>$id,'is_show'=>1))->order('sort asc')->select();
            //var_dump($goods);
            $sT['status'] = 1;
            
            foreach($goods as $k=>$v){
                $Tar = explode(',',$goods[$k]['tid']);
                $sT['id'] = array('in',$Tar);
                $goods[$k]['Tag'] = $this->tag->field('name')->where($sT)->select();
            }
            $num = $this->comp->select();  //取出部件个数
            foreach($goods as $k=>$v){
                foreach($goods as $ke=>$va){
                    if($v['cid'] == $va['cid']){
                        $ag[$v['cid']]['cid'] = $v['cid'];
                        $ag[$v['cid']]['arr'][$ke] = $goods[$ke];
                    }
                }
            }

            for($i = 1;$i<=count($num);$i++){
    
                    if($i == $arr[$i][0]['cid']){
                        $ars[$i]['img'] = $arr[$i];
                       //var_dump($ars);die('ee'); 
                    }else{
                        $ars[$i]['img'] = null;
                    }
            }
            for($j = 1;$j<=count($num);$j++){
                if($j == $ag[$j]['cid']){
                    $ars[$j]['goods'] = $ag[$j]['arr'];
                }else{
                    $ars[$j]['goods'] = null;
                }
            }
            //var_dump($ars);die('ww');
            //$this->act_attr->where('id='.$id)->setInc('pv', 1);
            $acti = $this->act_list->where('id='.$id)->find();
            include $this->admin_tpl('activity_index');
        }else{
            die('404');
        }
    }
    /**
     * 活动列表
     * @return [type] [description]
     */
    public function lists(){
        $label = $_GET['label'];//按状态查找
        $keyword = $_GET['keyword']?$_GET['keyword']:''; //按关键字查找
    	if(IS_POST){
            switch($label){
                case '':
                    $where = '';
                    break;
                case '1':
                    $where['status'] = 1;
                    break;
                case '0':
                    $where['status'] = 0;
                    break;
                case '2':
                    $where['status'] = 2;
                    break;
            }
            //筛选
            if (isset($keyword) && $keyword) {
                //名称ID
                $where['name'] = array('LIKE','%'.$keyword.'%');
                
            }
            $pagenum = isset($_GET['page']) ? intval($_GET['page']) : 1;
            $rowsnum = isset($_GET['rows']) && (int) ($_GET['rows']) != 0 ? intval($_GET['rows']) : PAGE_SIZE;
            $data['total'] = $this->act_list->where($where)->count();    

	    	$data['rows'] = $this->act_list->where($where)->limit(($pagenum - 1) * $rowsnum . ',' . $rowsnum)->order('addtime desc')->select();
	    	foreach($data['rows'] as $k=>$v){
	    		/**取活动流量数据**/
	    		$attr = $this->act_attr->field('pv')->where('id='.$v['id'])->find();
	    		$data['rows'][$k]['pv'] = $attr['pv'];
	    		/**取模本名**/
	    		$temp = $this->temp->field('name')->where('id='.$v['t_id'])->find();
	    		$data['rows'][$k]['t_name'] = $temp['name'];
	    	}
            if (!$data['rows']) $data['rows'] = array();
	    	echo json_encode($data);  		
    	}else{
    		include $this->admin_tpl('activity_lists');  
    	}

    }

    /**
     * 活动添加
     */
    public function add(){
        $arr = $_POST;
        if(!empty($_POST['aid']) && is_numeric($_POST['aid'])){
                $dat['url'] = U('index',array('id'=>$arr['aid']));
                $dat['b_c'] = trim($arr['b_c']);
                $dat['a_cid'] = implode(',',$arr['cid']);
                $dat['status'] = $_POST['status'];
                $dat['start_time'] = strtotime($arr['start_time']);
                $dat['end_time'] = strtotime($arr['end_time']);
                $dat['s_title'] = trim($_POST['s_title']);
                $dat['s_desc'] = trim($_POST['s_desc']);
                $dat['s_img'] = trim($_POST['s_img']);
                $dat['uptime'] = time();
                if($arr['aid'] != ''){
                    $arrS = $this->act_list->where('id='.$arr['aid'])->save($dat);
                }else{
                    $arrS = $this->act_list->save($dat);
                }
                //var_dump($dat);die('ww');
                if(!empty($arrS)){
                    showmessage('添加成功',U('lists'),0);
                }else{
                    showmessage('添加失败',NULL,0);
                }
        }
    }

    /**
     * 编辑活动ID（展现）
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id){
        //var_dump($_SERVER);
        //根据id获取活动详情
        $id=intval($_GET['id']);
        $cid=intval($_GET['cid']);
        if(IS_POST){
            $arr = $_POST;
            //var_dump($arr);die('qqqqq');
            for($i = 0;$i<count($arr['goodsphoto']);$i++){
                $dat[$i]['aid'] = $id;
                $dat[$i]['cid'] = $cid;
                $dat[$i]['path'] = $arr['goodsphoto'][$i];
            }
            //var_dump($dat);die('qqqqq');
            //die('www');
            $resu = $this->aimage->addAll($dat);
//            echo $this->aimage->_sql();die;
            if(!empty($resu)){
                showmessage('添加成功',U('Activity/edit',array('id'=>$id)),0);
            }else{
                showmessage('添加失败',NULL,0);
            }
            if(!empty($id) && is_numeric($id)) {
                $arr = $this->act_list->where('id=' . $id)->find();
                $img = $this->aimg->field('cid,path')->where('aid=' . $id)->select();
                foreach ($img as $k => $v) {
                    $arimg[$v['cid']][$k] = $v['path'];
                }
                $goods = $this->goods->field('cid,count(id)')->where('aid=' . $id)->group('cid')->select();
                foreach ($goods as $k => $v) {
                    $argoods[$v['cid']] = $v['count(id)'];
                }
            }
        }else{
            $arrp = $this->act_list->where(array('id'=>$id,'cid'=>$cid))->select();
            include $this->admin_tpl('activity_temp_detail');
//            showmessage('关键参数出错',NULL,0);
        }

    }

    /**
     * 删除操作
     * @return [type] [description]
     */
    public function ajax_del(){
        $id=intval($_GET['id']);
        if($id>0){
                $this->act_list->where('id='.$id)->delete();
                showmessage('恭喜你，删除活动成功！',null,1); 
        }else{
           showmessage('非法操作，请联系管理员！'); 
        }
    }

    /**
     * 图片部件编辑
     * @return [type] [description]
     */
    public function imgList(){
        $id = $_GET['id'];
        $cid = $_GET['cid'];
        $items = $this->aimg->where(array('aid'=>$id,'cid'=>$cid))->select();
        foreach($items as $k=>$v){
            $cou = count(explode(',',$v['path']));
            if($cou>1){
                $p['path'] =array('eq',$v["path"]) ;
               $ids =  $this->aimg->field('id')->where($p)->where(array('aid'=>$id,'cid'=>$cid))->select();
                $this->aimg->where('id='.$ids[0]['id'])->delete();
//                var_dump($ids);die;
            }
        }
        if(IS_POST){
            if(!empty($id) && is_numeric($id)){

                $arr = $this->aimg->where(array('aid'=>$id,'cid'=>$cid))->select();
//                var_dump($arr);die;
                foreach($arr as $k=>$v){
                    $arr[$k]['g_name'] = $this->ingoods->where('id='.$v['gid'])->getField('name');
                }
                echo json_encode($arr);
            }else{
                showmessage('关键参数错误',NULL,0);
            }
        }else{
            include $this->admin_tpl('activity_image_list');
        }
    }

    public function imgUpdate(){
        $opt = $_GET['opt'];
        $id = $_GET['id'];
        if(IS_POST){
            if(!empty($id) && is_numeric($id)){
                self::save($this->aimg,$_POST['data']); 

                    if(!empty($id)){
                        showmessage('图片部件上传成功',U('Activity/edit',array('id'=>$id)),1);            
                    }else{
                        showmessage('图片部件上传成功',U('Activity/lists'),1);
                    } 

            }else{
                showmessage('关键参数错误!',NULL,0);
            }
        }else{
            if(isset($opt) && $opt){
                //删除
                if($opt == 'del' && $id ){
                    unset($where);
                    $where['id']=array('in',$id);
                    $this->aimg->where($where)->delete();
                    showmessage('恭喜你，删除成功！',U('imgList'),1); 
                }

            }else{
                showmessage('参数错误,请联系管理员!',NULL,0);
            }
        } 
    }


    public function imgUrl($id){
        $id = $_GET['id'];
        $aid = $_GET['aid'];
        $cid = $_GET['cid'];
            if(IS_POST){
                if(!empty($id) && is_numeric($id)){
                    $dat['url'] = $_POST['url'];
                    $dat['gid'] = $_POST['rgid'];
                    $dat['sort'] = $_POST['sort'];
                    $dat['path'] = $_POST['path'];
                    $arrS = $this->aimg->where(array('id'=>$id,'cid'=>$cid))->save($dat);
                        if(!empty($arrS)){
                            showmessage('图片编辑成功',U('imgList',array('id'=>$aid,'cid'=>$cid)),0);
                        }else{
                            showmessage('图片编辑失败',NULL,0);
                        }
                }else{
                    showmessage('关键参数错误!',NULL,0);
                }
            }else{
                $aimg = $this->aimg->where('id='.$id)->find();
                $paths = array_filter(str2arr($aimg['path']));
                foreach($paths as $k=>$v){
                    $aimg['path'] = $v;
                }
//                var_dump($aimg['path']);die;
                $aimg['goods_name'] = $this->ingoods->where('id='.$aimg['gid'])->getField('name');
                include $this->admin_tpl('activity_image_url');
            }       
    }


    /**
     * 保存修改
     * @return [type] [description]
     */
    protected function save($obj){
        $data = json_decode(stripslashes(htmlspecialchars_decode($_GET['data'])),true);
        foreach ($data as $key => $value) {
            $result = $obj->update($value);
            if($result == false){
                showmessage('修改失败!',NULL,0);
            }
        }   
    }


    /**
     * 微信分享单图
     * @return [type] [description]
     */
    public function imgWeixin(){
        $data = $_POST;
        if($data != ''){
            $resu = $this->act_list->where('id='.$data['id'])->setField('s_img',$data['s_img']);
            if(!empty($resu)){
                echo 1;
            }else{
                echo 0;
            }            
        }else{
            echo 0;
        }
    }    

    public function douru(){
        $id = $this->ingoods->field('id')->select();
        // var_dump($id);
        foreach($id as $ke=>$va){
        $as = '';
            $arr =  model('goods_attribute')->field('goods_id,attribute_value')->where('goods_id='.$va['id'])->select();
            // var_dump($arr);
            foreach($arr as $k=>$v){
                // var_dump($v['attribute_value']);
                if($v['goods_id'] == $va['id']){
                    // var_dump($arr[$k]['attribute_value']);
                    $as .= $v['attribute_value'].',';
                }
            }
                $this->ingoods->where('id='.$va['id'])->setField('attr_array',$as);
        }
    }

    public function setskill(){
        $id = M('service_goods')->field('id,category')->select();
        //var_dump($id);
        foreach($id as $ke=>$va){
            $arr_id = explode(',',$va['category']);
            $name_r = '';
            foreach($arr_id as $k=>$v){
                $name =  M('skill')->field('name')->where('id='.$v)->getField('name');
                $name_r .= $name.',';
            }
            M('service_goods')->where('id='.$va['id'])->setField('s_skill',$name_r);
        }
    }         

}

?>