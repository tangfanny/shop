<?php  include  $this->admin_tpl('header'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/haidaoblue/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/icon.css">
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/hd_default_config.js"></script>
<div class="content">
    <div class="site">
        <a href="#">运营推广</a> > 产品排行榜管理
    </div>
    <span class="line_white"></span>
    <div class="goods mt10">
        <div class="search_ind">
            <input type="hidden" name="m" value="<?php echo GROUP_NAME ?>">
            <input type="hidden" name="c" value="<?php echo MODULE_NAME ?>">
            <input type="hidden" name="a" value="<?php echo ACTION_NAME ?>">
            <span style="margin-right: 10px;">按分类查看</span>
            <select name='category_id' id='category_id' class="easyui-combobox" data-options="editable:false"  style="height: 26px;width: 180px;">
            </select>
            <span style="margin-right: 10px;">产品排行榜搜索 </span>
            <input id="keyword" class="easyui-textbox" name="keyword" style="width:210px;height: 26px;" prompt="输入产品或品牌名进行查找">
            <a id="search" href="#" class="easyui-linkbutton" style="height: 26px;padding-right: 10px;">查询</a>
        </div>
        <dl class="mt10">
            <dt><p>
                <a href="<?php echo  U('lists?type=1')?>"  <?php if ($type == 1) { echo "class='hover'"; }; ?>>每天</a>
                <a href="<?php echo  U('lists?type=2')?>" <?php if ($type == 2) { echo "class='hover'";
                }; ?>
                >本周</a>
                <a href="<?php echo  U('lists?type=3')?>" <?php if ($type == 3) { echo "class='hover'"; }; ?>
                >本月</a>
                <a href="<?php echo  U('lists?type=3')?>" <?php if ($type == 4) { echo "class='hover'"; }; ?>
                >全部</a>
            </p>
            </dt>
        </dl>
        <div class="login mt10" style="border: none;border-right: 1px solid #e6e6e6;">
            <table id="rank_list_grid" style="width:100%;"></table>
        </div>

        <div class="clear"></div>
        <?php include $this->admin_tpl('copyright') ?>
    </div>
</div>

<!--表格js-->
<script type="text/javascript">
    var dom = $('#rank_list_grid');
    var pageSize = <?php echo PAGE_SIZE?>;
    var cat_arr = <?php echo json_encode($this->treeMenu)?>;
    var brand_arr = <?php echo json_encode($brand_arr);?>;
    var dataurl = '<?php echo U('lists');?>';
    var editurl = '<?php echo U('edit'); ?>';
    var keyword = '<?php echo $keyword; ?>';
    var brand_id = <?php echo $bid; ?>;
    var type = <?php echo $type?>;
    try{
        cat_arr.unshift({"value":"0","text":"请选择"});
    }catch(error){
        cat_arr=[{"value":"0","text":"请选择"}];
    }
    $(function(){
        dom.datagrid({
            url:dataurl,
            striped:true,
            width:'100%',
            checkOnSelect:false,
            fitColumns:true,
            queryParams:{
                keyword:keyword,
                brand_id:brand_id,
                type:type
            },
            scrollbarSize:0,
            pagination:true,
            pageSize:pageSize,
            pageList: [pageSize,pageSize*4,pageSize*8,pageSize*16,pageSize*32,pageSize*64],
            //可以设置每页记录条数的列表
            columns:[[
                {field:'id',title:'排序',width:'5%',halign:'center',align:'center',sortable:true},
                {field:'g_name',title:'产品名',width:'18%',halign:'center',align:'center'},
                {field:'c_name',title:'全部分类',width:'17%',halign:'center',align:'center'},
                {field:'bid',title:'品牌名',width:'15%',halign:'center',align:'center',
                    formatter:function(value,row,index){
                        var b_name = '-';
                        for(var o in brand_arr){
                            if(brand_arr[o].id == value){
                                b_name = brand_arr[o].name
                            }
                        }
                        return b_name;
                    }
                },
                {field:'display_sale',title:'显示销量',width:'10%',halign:'center',align:'center',sortable:true},
//                {field:'sale_rate',title:'销量日增率',width:'9%',halign:'center',align:'center',sortable:true},
                {field:'real_sale',title:'真实销量',width:'12%',halign:'center',align:'center',sortable:true},
                {field:'display_hit',title:'显示人气',width:'12%',halign:'center',align:'center',sortable:true},
//                {field:'hit_rate',title:'人气日增率',width:'8%',halign:'center',align:'center',sortable:true},
                {field:'real_hit',title:'真实人气',width:'10%',halign:'center',align:'center',sortable:true}
            ]],
            onLoadSuccess:function(data){
                $('#category_id').combobox({
                    data:cat_arr,
                    valueField:'value',
                    textField:'text'
                });
                $('#brand_id').combobox({
                    data:brand_arr,
                    valueField:brand_arr['name'],
                    textField:brand_arr['name']
                });
                try{
                    $('#category_id').combobox('setValue',data.search.s_category_id);
                    $('#brand_id').combobox('setValue',data.search.s_brand_id);
                }catch(error){}
            }
        });
        // 回车查询
        $('#keyword').textbox('textbox').bind('keydown',function (e) {
            if (e.keyCode == 13) {
                $('#search').trigger('click');
            }
        });
        // 增加查询参数，重新加载表格
        $('#search').bind('click',function (){
            var queryParams = dom.datagrid('options').queryParams;
            //查询参数直接添加在queryParams中
            queryParams.keyword = $("#keyword").val();
            queryParams.category_id = $('#category_id').combobox('getValue');
            dom.datagrid('options').queryParams = queryParams;
            dom.datagrid('reload');
        })
    })
</script>
