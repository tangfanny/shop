<?php  include  $this->admin_tpl('header'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/haidaoblue/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/icon.css">
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/hd_default_config.js"></script>
<div class="content">
    <div class="site">
        <a href="#">财务管理</a> > 线下充值
    </div>
    <span class="line_white"></span>
    <div class="goods mt10">
        <div class="search_ind">
            <input type="hidden" name="m" value="<?php echo GROUP_NAME ?>">
            <input type="hidden" name="c" value="<?php echo MODULE_NAME ?>">
            <input type="hidden" name="a" value="<?php echo ACTION_NAME ?>">
            <span style="margin-right: 10px;">充值搜索 </span>
            <input id="keyword" class="easyui-textbox" name="keyword" style="width:250px;height: 26px;" prompt="输入用户uid/昵称/EMAIL/姓名">
            <a id="search" href="#" class="easyui-linkbutton" style="height: 26px;padding-right: 10px;">查询</a>
        </div>
        <div class="login mt10" style="border: none;border-right: 1px solid #e6e6e6;">
            <table id="offline_pay_list" style="width:100%;"></table>
        </div>
        <div class="clear"></div>
        <?php include $this->admin_tpl('copyright') ?>
    </div>
</div>
</script>
<!--表格js-->
<script type="text/javascript">
var dom = $('#offline_pay_list');
var pageSize = <?php echo PAGE_SIZE?>;
var dataurl = '<?php echo U('lists')?>';
var editurl = '<?php echo U('edit')?>';
var keyword = '<?php echo $keyword?>';
var user_id = '<?php echo $user_id?>';
$(function(){
    dom.datagrid({
        url:dataurl,
        striped:true,
        width:'100%',
        checkOnSelect:false,
        fitColumns:true,
        queryParams:{
            user_id:user_id,
            keyword:keyword
        },
        scrollbarSize:0,
        pagination:true,
        pageSize:pageSize,
        pageList: [pageSize,pageSize*4,pageSize*8,pageSize*16,pageSize*32,pageSize*64],
        //可以设置每页记录条数的列表
        columns:[[
            {field:'nikename',title:'用户昵称',width:'10%',halign:'center',align:'center'},
            {field:'mobile',title:'电话',width:'13%',halign:'center',align:'center'},
            {field:'email',title:'Email',width:'13%',halign:'center',align:'center'},
            {field:'ordtotal_fee',title:'金额',width:'13%',halign:'center',align:'center',sortable:true},
            {field:'create_time',title:'创建时间',width:'15%',align:'center',sortable:true,
                formatter:function(value,row,index){
                    if(value!=null && value!=0){
                        return $.fn.datebox.defaults.timeformat(value);
                    }else{
                        return "-";
                    }
                }
            },
            {field:'check_time',title:'审核时间',width:'15%',align:'center',sortable:true,
                formatter:function(value,row,index){
                    if(value!=null && value!=0){
                        return $.fn.datebox.defaults.timeformat(value);
                    }else{
                        return "-";
                    }
                }
            },
            {field:'prepay_suc',title:'支付状态',width:'11%',halign:'center',align:'center',sortable:true,
                formatter:function(value,row,index){
                    switch (row.prepay_suc) {
                        case '0':
                            statushtml = "支付失败";
                            break;
                        case '1':
                            statushtml = "支付成功";
                            break;
                        case '3':
                            statushtml = "等待审核";
                            break;
                    }
                    return statushtml;
                }},
            {field:'none',title:'操作',width:'10%',halign:'center',align:'center',
                formatter:function(value,row,index){
                    var viewthtml = '<a href="'+editurl+'&id='+row.id+'">审核</a>';
                    return viewthtml ;
                }
            }
        ]]
    });
    //回车查询
    $('#keyword').textbox('textbox').bind('keydown',function (e) {
        if (e.keyCode == 13) {
            $('#search').trigger('click');
        }
    });
});
//增加查询参数，重新加载表格
$('#search').bind('click',function (){
    var queryParams = dom.datagrid('options').queryParams;
    //查询参数直接添加在queryParams中
    queryParams.keyword = $("#keyword").val();
    dom.datagrid('options').queryParams = queryParams;
    dom.datagrid('reload');
})
</script>