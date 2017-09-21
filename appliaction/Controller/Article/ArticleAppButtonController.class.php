<?php
/**
 * 按钮列表
 */
class ArticleAppButtonController extends AdminBaseController{

    public function _initialize() {
        parent::_initialize();
        $this->db= model('Article_app_button');
    }

    public function lists(){

        $id = $_GET['id'];
        if(IS_POST){
            $sqlmap = array();
            if($id){
                $sqlmap['id'] = $id;
            }
            $_order=isset($_POST['order']) ? ($_POST['order']) : NULL;
            $_sort=isset($_POST['sort']) ? ($_POST['sort']) : NULL;
            if($_order && $_sort){
                $order[$_sort] = $_order;
            }else{
                $order['id'] = 'DESC';
            }
            $pagenum=isset($_POST['page']) ? intval($_POST['page']) : 1;
            $rowsnum=isset($_POST['rows']) && (int)($_POST['rows']) != 0 ? intval($_POST['rows']) : PAGE_SIZE;
            $data['total'] = $this->db->where($sqlmap)->count();    //计算总数
            $data['rows']=$this->db
                ->field(true)
                ->where($sqlmap)
                ->limit(($pagenum-1)*$rowsnum.','.$rowsnum)
                ->order($order)
                ->select();
            if (!$data['rows']) $data['rows']=array();
            echo json_encode($data);
        }else{
            include $this->admin_tpl('article_app_button_lists');
        }
    }
    /**
     * 添加修改页
     */
    public function update(){
        $validform = TRUE;
        $opt=I("opt");
        $id=I("id",0);
        if(IS_POST){
            $this->save();
        }else{
            if(isset($opt) && $opt){
                //编辑
                if($opt=='update' && $id>0){
                    $info = $this->db->where('id='.$id)->find();
                    $this->info = $info ;
                }
                //删除
                if($opt == 'del' && $id > 0){
                    unset($where);
                    $where['id']=array('in',$id);
                    $this->db->where($where)->delete();
                    showmessage('恭喜你，删除成功！',U('Article_app_button/lists'),1);
                }
                include $this->admin_tpl('article_app_button_edit');
            }else{
                showmessage('参数错误,请联系管理员!',U('Article_app_button/lists'),0);
            }
        }
    }
    /**
     * 处理数据
     */
    public  function save(){
        $db = M('Article_app_button');
        $id = $_POST['id'];
        $_POST['start_time']=strtotime(I('start_time'));
        $_POST['end_time']= strtotime(I('end_time'));
        $_POST = daddslashes($_POST);
        //处理
        if (isset($id) && $id) {
            if ($db->create()) {
                $db->save();
                $nid = $id;
                showmessage("修改按钮成功", U('lists'),1);
            } else {
                $this->error($db->getError(),U('lists'),0);
            }
        } else {
            if($db->create($_POST)){
                $res = $db->add();
                showmessage("添加按钮成功", U('lists'),1,1000);
            }else{
                showmessage($db->getError(), U('lists'),0);
            }
        }
    }

     /**
     * 改变排序
     */
    public function ajax_sort(){
        $id=intval($_GET['id']);
        $val=  intval($_GET['val']);
        if($id>0){
            $data['sort'] = $val;
            $this->db->where('id='.$id)->save($data);
            showmessage('恭喜你，成功改变排序！', '', 1); 
        }else{
           showmessage('非法操作，请联系管理员！'); 
        }
    }
    /**
     * 改变状态
     */
    public function ajax_status(){
        $id=intval($_GET['id']);
        if($id>0){
            $butt=model('Article_app_button');
            $data['status']=array('exp',' 1-status ');;
            $butt->where('id='.$id)->save($data);
            echo $butt->_sql();die;
            $this->success('恭喜你，成功改变状态！'); 
        }else{
           $this->error('非法操作，请联系管理员！'); 
        }
    }
}
