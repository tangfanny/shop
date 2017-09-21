<?php
/**
 * 产品排行榜管理
 *
 */
class RankController extends AdminBaseController{

    /**
     * 开始执行方法方法给要执行的方法初始化
     */
    public function _initialize()
    {
        parent::_initialize();
        $cate = model('category');
        $data = $cate->where('status = 1')->order('parent_id ASC,sort ASC,id ASC')->select();
        $this->tree = $info = getTree($data, 0);
        $this->treeMenu = $cate->formatCat($info);
        $this->rank_sum = model('goods_rank_sum');    //产品汇总表
        $this->rank_edit = model('goods_rank_edit'); //编辑表
        $this->brand = model('Brand')->where('status = 1')->order('sort ASC')->select();//品牌列表
        $this->day_rank = model("goods_day_rank");//每天汇总
        $this->week_rank = model("goods_week_sum");//周汇总
        $this->month_rank = model("goods_month_sum");//月汇总
    }


    /**
     * 获取列表信息
     */
    public function lists()
    {
        $cat_arr = array();
        $type = isset($_GET['type']) ? $_GET['type'] : 1; //获取类型
        $start_time = strtotime($_GET['start_time']); //获取起止时间
        $end_time = strtotime($_GET['end_time']); //获取结束时间
        $bid = is_string($_GET['bid']) ? $_GET['bid'] : '0';
        $category_id = is_string($_GET['category_id']) ? $_GET['category_id'] : '0';
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';//检索字段主要可以搜索产品名和品牌名
        $brand_arr = (array)M('Brand')->field('id,name')->select();
        $cat_arr = (array)M('GoodsCategory')->getField('id,name', TRUE);
        if (IS_POST) {
            $sqlmap = array();
            $goods_ids = array();
            if($type==1){
                $goods_ids = $this->day_rank->getField('gid',true);
            }elseif($type==2){
                $goods_ids = $this->week_rank->getField('gid',true);
            }elseif($type==3){
                $goods_ids = $this->month_rank->getField('gid',true);
            }elseif($type==4){
                $goods_ids = $this->rank_sum->getField('gid',true);
            }
            //排序
            $_order = isset($_POST['order']) ? ($_POST['order']) : NULL;
            $_sort = isset($_POST['sort']) ? ($_POST['sort']) : NULL;
            if ($_order && $_sort) {
                $order[$_sort] = $_order;
            } else {
                $order['id'] = 'ASC';
            }
            if (isset($category_id) && $category_id) {
                $cid = (array)D('Category')->getChild($category_id);
                $_join = array("find_in_set('{$category_id}',cid)");
                foreach ($cid as $key => $value) {
                    $_join[] = "find_in_set('{$value}',cid)";
                }
                $join_str = implode(' OR ', $_join);
                if (isset($where['_string'])) {
                    $where['_string'] .= " AND (" . $join_str . ")";
                } else {
                    $where['_string'] = $join_str;
                }
                if($type==1){
                    $_goods_ids = (array)$this->day_rank->where($where)->getField('gid',true);
                }elseif($type==2){
                    $_goods_ids = (array)$this->week_rank->where($where)->getField('gid',true);
                }elseif($type==3){
                    $_goods_ids = (array)$this->month_rank->where($where)->getField('gid',true);
                }elseif($type==4){
                    $_goods_ids = (array)$this->rank_sum->where($where)->getField('gid',true);
                }
                $result_ids = array_intersect($goods_ids, $_goods_ids);
                $sqlmap = (array('gid' => array('IN', $result_ids)));
            }
            if (isset($keyword) && $keyword) {
                $keyword = $_GET['keyword'];
                $where['g_name|b_name'] = array("LIKE", "%" . $keyword . "%");
            }
            //分页
            $pagenum = isset($_GET['page']) ? intval($_GET['page']) : 1;
            $rowsnum = isset($_GET['rows']) && (int)($_GET['rows']) != 0 ? intval($_GET['rows']) : PAGE_SIZE;
            $page = ($pagenum - 1) * $rowsnum . ',' . $rowsnum;
            //获取记录数
            $field = $this->day_rank->getField();
            $join = 'LEFT JOIN  __GOODS_RANK_EDIT__   AS e ON e.id=d.id';
            switch ($type) {
                /* 查询天 */
                case '1':
                    if(!empty($start_time) && !empty($end_time)){
                        $t["time"] = array(array('egt',$start_time),array('elt',$end_time));
                    }else{
                        $t["time"] = $this->day_rank->getTime();
                    }
                    $data['total'] = $this->day_rank->where($t)->count();
                    // $data['total'] = $this->week_rank->count();
                    $data['rows'] = $this->day_rank->alias('d')->field($field)->join($join)->where($where)->where($t)->order($order)->limit($page)->select();
                    $info = $this->day_rank->yesterday_data();
                    break;
                case '2': //周
                    $t = $this->week_rank->week_time(7);
                    $data['total'] = $this->week_rank->where($where)->where($t)->count();
                    $data['rows'] = $this->week_rank->where($where)->where($t)->order($order)->limit($page)->select();
                    $info = $this->week_rank->lastweek_data();
                    break;
                case '3': //月
                    $t= $this->month_rank->month_time();
                    $data['total'] = $this->month_rank->where($t)->count();
                    $data['rows'] = $this->month_rank->where($sqlmap)->where($where)->where($t)->limit($page)->order($order)->select();
                    $info = $this->month_rank->lastmonth_data();
                    break;
                case '4': //全部
                    $data['total'] = $this->rank_sum->count();
                    $data['rows'] = $this->rank_sum->where($sqlmap)->where($where)->limit($page)->order($order)->select();
                    break;
            }
            //获取分类名显示到页面
            foreach ($data['rows'] as $k => $v) {
                $cid = explode(',', $v['cid']);
                $c_name = "";
                foreach ($cid as $k1 => $v1) {
                    if (!empty($cat_arr[$v1])) {
                        $c_name .= $cat_arr[$v1] . ',';
                    }
                }
                $data['rows'][$k]['c_name'] = $c_name;
            }
            foreach($data['rows'] as $k=>$v){
                foreach($info as $k1=>$v1){
                    $re = $v1['real_sale']+$v1['display_sale'];
                    $re1 = $v['real_sale']+$v['display_sale']+$v1['display_sale'];
                    $data['rows'][$k]['sale_natu_rate'] = round(($re/$re1)*100). "%";
                    $hit = $v1['real_hit']+$v1['display_hit'];
                    $hit1 = $v['real_hit']+$v['display_hit']+$v1['display_hit'];
                    $data["rows"][$k]['hit_natu_rate'] = round(($hit/$hit1)*100). "%";
                }

            }
//            var_dump($data);die;
            $data['search']['s_category_id'] = $category_id;
            if (!$data['rows']) {
                $data['rows'] = array();
            }
            echo json_encode($data);
        } else {
            if($type==1){
                include $this->admin_tpl('goods_day_rank');
            }elseif($type==2){
                include $this->admin_tpl('goods_week_rank');
            }elseif($type==3){
                include $this->admin_tpl('goods_month_rank');
            }elseif($type==4){
                include $this->admin_tpl('goods_rank_sum');
            }
        }
    }

    /**
     * 编辑
     */
    public function edit(){
        $id = $_GET['id'];
        $where['id'] =array(eq,$id);
        $fi = "g_name,gid";
        $name = $this->day_rank->field($fi)->where($where)->find();
        $gid = $name['gid'] ;
        $day_data = $this->day_rank->get_day_data($gid);
//        echo $this->day_rank->_sql();die;
        $edit_data = $this->rank_edit->get_edit_data($where);
        if(IS_POST ){
            $_POST['sale_start_time'] = strtotime(I('sale_start_time'));
            $_POST['sale_end_time'] = strtotime(I('sale_end_time'));
            $_POST['hit_start_time'] = strtotime(I('hit_start_time'));
            $_POST['hit_end_time'] = strtotime(I('hit_end_time'));
            $_POST['create_time'] = $this->day_rank->getTime();
            //如果对应的商品id在表里有数据就编辑
            if($edit_data){
                $map_day['id'] = $_POST['id'];
                $map_edit['id']= $id;
                $day["display_sale"] = $_POST["display_sale"];
                $day["display_hit"] = $_POST["display_hit"];
                $edit["sale_start_time"]=$_POST["sale_start_time"];
                $edit["sale_end_time"]=$_POST["sale_end_time"];
                $edit["hit_start_time"]=$_POST["hit_start_time"];
                $edit["hit_end_time"]=$_POST["hit_end_time"];
                $edit["sale_rate"]=$_POST["sale_rate"];
                $edit["hit_rate"]=$_POST["hit_rate"];
                $edit["create_time"]=$_POST["create_time"];
                $this->day_rank->where($map_day)->data($day)->save();
                $this->rank_edit->where($map_edit)->data($edit)->save();
                //                $this->day_rank->where($map)->save($data);
//               var_dump($this->rank_edit->where($map_edit)->data($edit)->_sql());exit();
                showmessage("编辑成功", U('lists'), 1);
            }else{
                //反之如果对应的商品id在表里没有数据就进行添加，添加时把id也录入表中
                $edit['id'] = $id;
                $edit['goods_id'] = $name['gid'];
                $map_day['id'] = $_POST['id'];
                $edit['goods_name'] = $name['g_name'];
                $day["display_sale"] = $_POST["display_sale"];
                $day["display_hit"] = $_POST["display_hit"];
                $edit["sale_start_time"]=$_POST["sale_start_time"];
                $edit["sale_end_time"]=$_POST["sale_end_time"];
                $edit["hit_start_time"]=$_POST["hit_start_time"];
                $edit["hit_end_time"]=$_POST["hit_end_time"];
                $edit["sale_rate"]=$_POST["sale_rate"];
                $edit["hit_rate"]=$_POST["hit_rate"];
                $edit["create_time"]=$_POST["create_time"];
                $this->rank_edit->data($edit)->add();
                $this->day_rank->where($map_day)->data($day)->save();
//                echo $this->rank_edit->data($data1)->_sql();exit;
                showmessage("添加成功", U('lists'), 1);
            }
        }
        include $this->admin_tpl('goods_rank_edit');
    }

}

