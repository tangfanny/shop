<?php  include  $this->admin_tpl('header'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/haidaoblue/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/icon.css">
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/hd_default_config.js"></script>
<div class="content">
    <div class="site">
        <a href="#">众测管理</a> > 众测项目列表
    </div>
    <span class="line_white"></span>
    <div class="goods mt10">
        <div class="search_ind">
            <input type="hidden" name="m" value="<?php echo GROUP_NAME ?>">
            <input type="hidden" name="c" value="<?php echo MODULE_NAME ?>">
            <input type="hidden" name="a" value="<?php echo ACTION_NAME ?>">
            <span style="margin-right: 10px;">众测搜索 </span>
            <input id="keyword" class="easyui-textbox" name="keyword" style="width:250px;height: 26px;" prompt="输入手机号/项目id/EMAIL/项目名称">
            <a id="search" href="#" class="easyui-linkbutton" style="height: 26px;padding-right: 10px;">查询</a>
        </div>
        <div class="login mt10" style="border: none;border-right: 1px solid #e6e6e6;">
            <table id="task_lists_grid" style="width:100%;"></table>
        </div>
        <div class="clear"></div>
        <?php include $this->admin_tpl('copyright') ?>
    </div>
</div>
</script>
<!--表格js-->
<script type="text/javascript">
var dom = $('#task_lists_grid');
var pageSize = <?php echo PAGE_SIZE?>;
var dataurl = '<?php echo U('lists')?>';
var editurl = '<?php echo U('edit')?>';
var shenheurl = '<?php echo U('shenhe')?>';
var bmnewsurl = '<?php echo U('bmlist')?>';
var ldnewsurl = '<?php echo U('ldlist')?>';
var keyword = '<?php echo $keyword?>';
$(function(){
    dom.datagrid({
        url:dataurl,
        striped:true,
        width:'100%',
        checkOnSelect:false,
        fitColumns:true,
        queryParams:{
            keyword:keyword
        },
        scrollbarSize:0,
        pagination:true,
        pageSize:pageSize,
        pageList: [pageSize,pageSize*4,pageSize*8,pageSize*16,pageSize*32,pageSize*64],
        //可以设置每页记录条数的列表
        columns:[[
            {field:'title',title:'项目名称',width:'17%',halign:'center',align:'center'},
            {field:'sec_price',title:'任务价格',width:'17%',halign:'center',align:'center',sortable:true},
            {field:'pub_status',title:'审核状态',width:'17%',halign:'center',align:'center',sortable:true,
                formatter:function(value,row,index){
                    switch(row.pub_status) {
                        case '0':
                            statushtml = "未通过";
                            break;
                        case '1':
                            statushtml = "<span style='color:green'>通过</span>";
                            break;
                        case '2':
                            statushtml = "驳回";
                            break;
                        case '7':
                            statushtml = "已完成";
                            break;
                        case '8':
                            statushtml = "已取消";
                            break;
                        case '9':
                            statushtml = "已过期";
                            break;
                    }
                    return statushtml;
                }},
            {field:'create_time',title:'创建时间',width:'17%',align:'center',sortable:true,
                formatter:function(value,row,index){
                    if(value!=null && value!=0){
                        return $.fn.datebox.defaults.timeformat(value);
                    }else{
                        return "-";
                    }
                }
            },
            {field:'none',title:'操作',width:'32%',halign:'center',align:'center',
                formatter:function(value,row,index){
                    var sptext = '&nbsp;&nbsp;&nbsp;&nbsp;';
                    var shenhehtml = '<a href="'+shenheurl+'&task_id='+row.task_id+'">审核</a>';
                    var viewthtml = '<a href="'+bmnewsurl+'&task_id='+row.task_id+'">报名列表</a>';
                    var bmthtml = '<a href="'+ldnewsurl+'&task_id='+row.task_id+'" >漏洞列表</a>';
                    var edithtml = '<a href="'+editurl+'&task_id='+row.task_id+'">编辑</a>';
                    return shenhehtml+sptext+viewthtml+sptext+bmthtml+sptext+edithtml ;
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

