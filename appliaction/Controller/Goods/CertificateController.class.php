<?php
/**
 * 企业资质证书管理
 *
 * @author 吴枫
 */
class CertificateController extends AdminBaseController{
    /**
     * 自动加载初始化模型
     */
    public function _initialize() {
		parent::_initialize();	
		$this->db = model('Certificate');
	}
        
    public function lists(){
        if(IS_POST){
            $pagenum=isset($_POST['page']) ? intval($_POST['page']) : 1;
            $rowsnum=isset($_POST['rows']) && (int)($_POST['rows']) != 0 ? intval($_POST['rows']) : PAGE_SIZE;
            $data['total'] = $this->db->getCertificateCount();	//计算总数 
            $data['rows']=$this->db->getCertificateGroupBy($pagenum,$rowsnum);
            if(!$data['rows']){
                $data["rows"]=array();
            }
            echo json_encode($data);
        }else{
            include $this->admin_tpl('product_certificate_lists');
        }
    }
    
    public function listsc(){
        $id = intval($_GET['id']);
        if(IS_POST){
            $join = "__BRAND__ AS tb ON tb.id=a.brand_id";
            $sqlmap=array();
            if($id>0){
                $sqlmap["a.brand_id"]=$id;
            }else{
                $this->error('非法操作，请联系管理员！'); 
            }
            $pagenum=isset($_POST['page']) ? intval($_POST['page']) : 1;
            $rowsnum=isset($_POST['rows']) && (int)($_POST['rows']) != 0 ? intval($_POST['rows']) : PAGE_SIZE;
            $data['total'] = $this->db->count();	//计算总数
            $data['rows'] = $this->db->alias('a')
                        ->field('a.id,a.certificate_type,a.certificate_name,a.certificate_img,a.start_time,a.end_time,a.sort')
                        ->join($join)
                        ->where($sqlmap)
                        ->limit(($pagenum-1)*$rowsnum.','.$rowsnum)
                        ->order('a.sort')
                        ->select();
            if(!$data['rows']){$data['rows']=array();}
            echo json_encode($data);
        }else{
            include $this->admin_tpl('product_certificatelist_lists');
        }
    }
    
    //添加证书
    public function add(){
        if(IS_POST){
            $_POST['start_time'] = strtotime(I('start_time'));
            $_POST['end_time'] = strtotime(I('end_time'));
            $_POST['create_time'] = time();
            if ($_POST['start_time'] > $_POST['end_time'])showmessage("开始日期不能大于结束日期");
            $id = $this->db->addCertificate($_POST);
            if($id){
                showmessage('提交成功',U('lists'),1);
            }else{
                showmessage($this->db->getError(),U('lists')); 
            }

        }else{
            $validform = TRUE;
            $dialog = TRUE;
            $posturl = U('add');
            $brand = D('Brand')->getBrandName();
            include $this->admin_tpl('product_certificate_add');
        }      
    }


     // 删除证书（外）
     public function ajax_del(){
        $brand_id = (array)$_GET['id'];
        if($brand_id){
            $this->db->deleteCert($brand_id);
            showmessage('恭喜你，删除成功！','', 1);
        }else{
            showmessage('非法操作，请联系管理员！'); 
        }
    }

     // 删除证书（内）
     public function ajax_del2(){
        $id = (array)$_GET['id'];
        if($id){
            $this->db->deleteCertificate($id);
            showmessage('恭喜你，删除成功！','', 1);
        }else{
            showmessage('非法操作，请联系管理员！'); 
        }
    }

    // 编辑证书
    public function edit(){
        if(IS_POST){
            $_POST['start_time'] = strtotime(I('start_time'));
            $_POST['end_time'] = strtotime(I('end_time'));
            $result = $this->db->where(array('id'=>$_POST['id']))->save($_POST);
            if($result){
                showmessage('编辑成功',U('lists'),1);
            }else{
                showmessage('编辑失败',U('lists'),1); 
            }
        }else{
            $id = $_GET['id'];
            $brand = D('Brand')->getBrandName();
            $data = $this->db->where(array('id'=>$id))->find();
            include $this->admin_tpl('product_certificate_edit');
        }
    }

    // ajax根据品牌选择证书
    public function getCertByBrand(){
        $data = $this->db->getCertificateByGid($_POST);
        if (empty($data)) {$data = array();}
        echo json_encode($data);
    }







}
?>