<?php
/**
 * 销售列表
 *
 * @author 陈星
 */
class ListController extends AdminBaseController{
    /**
     * 自动执行初始化方法
     */
    public function _initialize() {
        parent::_initialize();    
        $this->test =  model("Test");
    }
    
   public function lists(){
        if(IS_POST){
            $data = $this->test->getList();
            echo json_encode($data);
        }else{
            include $this->admin_tpl("list");
        }
    }
    
    public function info(){
        if(IS_POST){
            $data = $this->test->getList();
            echo json_encode($data);
        }else{
            include $this->admin_tpl("info");
        }


    }

	public  function order(){
		if(IS_POST){
			$data = $this->test->getList();
            echo json_encode($data);
        }else{
            include $this->admin_tpl("admin_order_edit");
        }
	}
}

?>
