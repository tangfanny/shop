<?php

class ActivityGoodsController extends AdminBaseController {

    public function _initialize() {
        parent::_initialize();
        $this->goods = model('ActivityGoods');
        $this->comp = M('act_comp'); //部件实例
        $this->ingoods = M('goods');
        $this->brand = M('brand');
        $this->gLab = model('GoodsLabel');
        $this->aimg = M('act_img');
    }

    /**
     * 商品列表
     * @param  [type] $id  [活动ID]
     * @param  [type] $cid [部件ID]
     * @return [type]      [description]
     */
    public function goodsList($id,$cid){
        //var_dump($cid);
        if(IS_POST){
            if(!empty($id) && is_numeric($id)){
                $arrN = $this->goods->where(array('aid'=>$id,'cid'=>$cid))->select();//导航
                foreach($arrN as $k=>$v){
                    $arrC = $this->comp->field('name')->where('id='.$v['cid'])->find();
                    $arrN[$k]['cname'] = $arrC['name'];
                    $bid = $this->ingoods->field('brand_id')->where('id='.$v['gid'])->find();
                    $bname = $this->brand->field('name')->where('id='.$bid['brand_id'])->find();
                    $arrN[$k]['bname'] = $bname['name'];

                }
                echo json_encode($arrN);
            }else{
                showmessage('关键参数出错',NULL,0);
            }            
        }else{
            include $this->admin_tpl('activity_goods_list');  
        }        
    }

    /**
     * 商品编辑
     * @param  [type] $id  活动ID
     * @param  [type] $cid 部件ID
     * @return [type]      [description]
     */
    public function goodsEdit($id,$cid){
        $validform = true;
        $dialog = true;
        if(IS_POST){
            $arr = $_POST;
            $arr['gid'] = $_POST['rgid'];
            $arr['tid'] = implode(',',$_POST['tid']);
            $arr['pid'] = implode(',',$_POST['pid']);
            $data = $this->goods->where('id='.$arr['id'])->update($arr);
            if($data != false){
                showmessage('编辑成功', U('ActivityGoods/goodsList',array('id'=>$arr['aid'],'cid'=>$arr['cid'])),0); 
            }else{
               showmessage('修改失败',NULL,0); 
            }
        }else{
            if(!empty($id) && is_numeric($id) && !empty($cid) && is_numeric($cid)){
                $info = $this->goods->where('id='.$id)->find();
                $arrT = explode(",",$info['tid']);
                $arrP = explode(",",$info['pid']);
                $arrC = $this->comp->select();
                $aLab = $this->gLab->where('status=1')->select();
                $id = $info['aid']; //为了方便商品添加和商品编辑公用一个模本文件猜这么写的
                $action  = U('ActivityGoods/goodsEdit');
                      //获取商品标签
                include $this->admin_tpl("activity_goods_edit");
            }else{
                showmessage('传递错误',NULL,0);
            }
            
        }
    }

    /**
     * 活动商品添加
     * @param  [type] $id  [description]
     * @param  [type] $cid [description]
     * @return [type]      [description]
     */
    public function goodsAdd($id,$cid){
        $validform = true;
        $dialog = true;
        if(IS_POST){
            $arr = $_POST;
           // var_dump($arr);
            //$arr['tid'] = implode(',',$_POST['tid']); 线上暂时没有商品标签
            $arr['gid'] = $_POST['rgid'];
            $arr['addtime'] = time();
            //var_dump($arr);die('www');
            $data = $this->goods->add($arr);
            //var_dump($data);die('qe');
            if($data != false){
                showmessage('添加成功', U('Activity/edit',array('id'=>$arr['aid'])),0);
            }else{
               showmessage('添加失败',NULL,0); 
            }
        }  else {
            $action = U('ActivityGoods/goodsAdd');
            $aLab = $this->gLab->where('status=1')->select(); 
            include $this->admin_tpl("activity_goods_edit");
        }
    }


     /**
     * 上架下架
     */
     public function ajax_status(){
        $id=intval($_GET['id']);
        if($id>0){
            $data['is_show']=array('exp',' 1-is_show ');
            $this->goods->where('id='.$id)->save($data);
            $this->success('恭喜你，成功改变状态！'); 
        }else{
           $this->error('非法操作，请联系管理员！'); 
        }
    }

    public function ajax_sort(){
        $id=intval($_GET['id']);
        $val=  intval($_GET['val']);
        if($id>0){
            $data['sort'] = $val;
            $this->goods->where('id='.$id)->save($data);
            showmessage('恭喜你，成功改变排序！', '', 1); 
        }else{
           showmessage('非法操作，请联系管理员！'); 
        }        
    }


    public function goodsMultimg($id,$cid){
        $id=intval($_GET['id']);
        $cid=intval($_GET['cid']);
        $items = $this->aimg->where(array('aid'=>$id,'cid'=>$cid))->select();
        foreach($items as $k=>$v){
            $cou = count(explode(',',$v['path']));
            if($cou>1){
                $p['path'] =array('eq',$v["path"]) ;
                $ids =  $this->aimg->field('id')->where($p)->where(array('aid'=>$id,'cid'=>$cid))->select();
                $this->aimg->where('id='.$ids[0]['id'])->delete();
            }
        }
        if(IS_POST){
            $data['aid'] = $_POST['id'];
            $data['cid'] = $_POST['cid'];
            if($_POST['goodsphoto']) {
                $data['path'] = arr2str($_POST['goodsphoto']);
            }else{
                $data['path'] = '';
            }
            $paths = $this->aimg->field('id,path')->where(array('aid'=>$id,'cid'=>$cid))->select();
            if(empty($paths)){
                $resu = $this->aimg->add($data);
                $a = $this->aimg->where(array('aid'=>$id,'cid'=>$cid))->select();
//                var_dump(count(explode(',',$a[0]['path'])));die;
                if(count(explode(',',$a[0]['path']))>1) {
                    $paths = array_filter(str2arr($a[0]['path']));
                    foreach ($paths as $k => $v) {
                        $info['aid'] = $id;
                        $info['cid'] = $cid;
                        $info['path'] = $v;
                        $this->aimg->add($info);
                    }
                }
                if ($resu) {
                    showmessage('添加成功', U('Activity/edit', array('id' => $id)), 0);
                } else {
                    showmessage('添加失败', NULL, 0);
                }
            }else{
                $where['aid'] = array('eq',$id);
                $where1['cid'] = array('eq',$cid);
                $c = explode(',',$data['path']);
                if(empty($data['path'])){
                    $res = $this->aimg->where($where)->where($where1)->delete();
                }elseif(count($c) == 1) {
                    $this->aimg->where($where)->where($where1)->delete();
                    $res = $this->aimg->add($data);
                }else{
                        $res = $this->aimg->where($where)->where($where1)->save($data);
                        $a = $this->aimg->where(array('aid'=>$id,'cid'=>$cid))->select();
                        $paths = array_filter(str2arr($a[0]['path']));
                        foreach($paths as $k=>$v){
                            $data['aid'] = $id;
                            $data['cid'] = $cid;
                            $data['path'] = $v;
                            $this->aimg->add($data);
                        }
                    }
                if($res){
                    showmessage('编辑成功',U('Activity/edit',array('id'=>$id)),0);
                }else{
                    showmessage('编辑失败',NULL,0);
                }
            }
        }else{
            $arrp = $this->aimg->field('aid,path')->where(array('aid'=>$id,'cid'=>$cid))->select();
            $v['pics'] = array();
            foreach($arrp as $k1=>$v1){
                $v['pics'][] = $v1['path'];
            }
//            var_dump($v['pics']);die;

            include $this->admin_tpl('activity_goods_mutli');
        }

    }

    /**
     * 删除商品
     * @return [type] [description]
     */
    public function ajax_del(){
        $id=intval($_GET['id']);
        if($id>0){
                $this->goods->where('id='.$id)->delete();
                showmessage('恭喜你，删除商品成功！',null,1); 
            
        }else{
           showmessage('非法操作，请联系管理员！'); 
        }

    }    

}
