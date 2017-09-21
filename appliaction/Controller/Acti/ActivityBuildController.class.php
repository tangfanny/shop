<?php

class ActivityBuildController extends BaseController {

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
        $this->huodong = M('huodong');
    }

    public function index($id){
        if(!empty($id)&& is_numeric($id)){
            
            $banner = $this->banner->where('aid='.$id)->find();
            $nav = $this->nav->where('aid='.$id)->select();//导航

            $aimg = $this->aimg->where('aid='.$id)->order('cid asc')->select(); //图片部件
            //var_dump($aimg);
            foreach($aimg as $k=>$v){
                //array_push($arr[$v['cid']],$aimg[$k]);
                $arr[$v['cid']][] = $aimg[$k];
            }
            //var_dump($arr);
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

            //var_dump($ag);die('wq');
            for($i = 1;$i<=count($num);$i++){
    
                    if($i == $arr[$i][0]['cid']){
                        $ars[$i]['img'] = $arr[$i];
                       //var_dump($ars);die('ee'); 
                    }else{
                        $ars[$i]['img'] = null;
                    }
                    

            }
            //var_dump($ars);die('33');
            for($j = 1;$j<=count($num);$j++){
                if($j == $ag[$j]['cid']){
                    $ars[$j]['goods'] = $ag[$j]['arr'];
                }else{
                    $ars[$j]['goods'] = null;
                }
            }
            //var_dump($ars);die('ww');
            $this->act_attr->where('id='.$id)->setInc('pv', 1);

            $t = time();
            $su = __API__NEW__.'/zhuanti/huodong/'.$t.'.html';
            $ir = $this->act_list->where('id='.$id)->setField('url',$su);
            if(empty($ir)){
                    Header('Location:'. _SHOP_SECW.'/index.php?m=acti&c=activity&a=lists');
                    exit();
            }                        
            $acti = $this->act_list->where('id='.$id)->find();
            $this->assign('acti',$acti);
            $this->assign('banner',$banner);
            $this->assign('id',$id);
            $this->assign('ars',$ars);
            $this->assign('nav',$nav);
            $h_path = $_SERVER['DOCUMENT_ROOT'].'/../../www/web/shop/zhuanti/huodong/';
            $see = $this->buildHtml($t,$h_path,'index');
            $info['ids'] =$t.mt_rand(10,100);
            $info['content'] = $see;
            $info['addtime'] = time();
            $info['is_offline'] = $acti['status'];
            $this->huodong->add($info);
            if(!empty($see)){
                    Header('Location:'. _SHOP_SECW.'/index.php?m=acti&c=activity&a=lists');
                    exit();                
            }else{
                    Header('Location:'. _SHOP_SECW.'/index.php?m=acti&c=activity&a=lists');
                    exit();  
            }
        }else{
            die('404');
        }        
    }


    /**
     * 增加点击数
     * @return [type] [description]
     */
    public function insertNum(){
        $id = (int)$_GET['id'];
        if(!empty($id)){
            $this->act_attr->where('id='.$id)->setInc('pv', 1);
        }

    }


}
?>
