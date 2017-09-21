<?php  include  $this->admin_tpl('header'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/haidaoblue/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/icon.css">
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/hd_default_config.js"></script>
<div class="content">
    <div class="site">
        <a href="#">众测管理</a> > 请愿列表
    </div>
    <span class="line_white"></span>
    <div class="goods mt10">
        <div class="search_ind">
            <input type="hidden" name="m" value="<?php echo GROUP_NAME ?>">
            <input type="hidden" name="c" value="<?php echo MODULE_NAME ?>">
            <input type="hidden" name="a" value="<?php echo ACTION_NAME ?>">
            <span style="margin-right: 10px;">请愿搜索 </span>
            <input id="keyword" class="easyui-textbox" name="keyword" style="width:250px;height: 26px;" prompt="输入请愿标题/发布人邮箱/发布人昵称">
            <a id="search" href="#" class="easyui-linkbutton" style="height: 26px;padding-right: 10px;">查询</a>
        </div>
        <div class="login mt10" style="border: none;border-right: 1px solid #e6e6e6;">
            <table id="qyuan_lists_grid" style="width:100%;"></table>
        </div>
        <div class="clear"></div>
        <?php include $this->admin_tpl('copyright') ?>
    </div>
</div>
<!--表格js-->
<script type="text/javascript">
var dom = $('#qyuan_lists_grid');
var pageSize = <?php echo PAGE_SIZE?>;
var dataurl = '<?php echo U('lists')?>';
var editurl = '<?php echo U('edit')?>';
var qyuaninfourl = '<?php echo U('qyuaninfo')?>';
var Approveurl = '<?php echo U('qypass')?>';
var Rejecturl = '<?php echo U('qypass')?>';
var ldnewsurl = '<?php echo U('ldlist')?>';
var keyword = '<?php echo $keyword?>';
var user_id = '<?php echo $user_id?>';
var task_id = '<?php echo $task_id?>';
$(function(){
    dom.datagrid({
        url:dataurl,
        striped:true,
        width:'100%',
        checkOnSelect:false,
        fitColumns:true,
        queryParams:{
            keyword:keyword,
            user_id:user_id,
            task_id:task_id
        },
        scrollbarSize:0,
        pagination:true,
        pageSize:pageSize,
        pageList: [pageSize,pageSize*4,pageSize*8,pageSize*16,pageSize*32,pageSize*64],
        //可以设置每页记录条数的列表
        columns:[[
            {field:'title',title:'请愿标题',width:'11%',halign:'center',align:'center'},
            {field:'email',title:'发布人邮箱',width:'9%',halign:'center',align:'center',sortable:true},
            {field:'nikename',title:'发布人昵称',width:'9%',halign:'center',align:'center',sortable:true},
            {field:'bugnum',title:'总漏洞数',width:'9%',halign:'center',align:'center',sortable:true},
            {field:'create_time',title:'申请时间',width:'12%',align:'center',sortable:true,
                formatter:function(value,row,index){
                    if(value!=null && value!=0){
                        return $.fn.datebox.defaults.timeformat(value);
                    }else{
                        return "-";
                    }
                }
            },
            {field:'isok',title:'请愿状态',width:'9%',halign:'center',align:'center',sortable:true,
                formatter:function(value,row,index){
                  if(row.isok = 1){
                      return "<span style='color:green'>已完成</span>";
                  }else{
                      return '进行中';
                  }
                }
            },
            {field:'ispass',title:'审核状态',width:'9%',halign:'center',align:'center',sortable:true,
                formatter:function(value,row,index){
                    switch(row.ispass) {
                        case '0':
                            stahtml = "未通过";
                            break;
                        case '1':
                            stahtml = "<span style='color:green'>通过</span>";
                            break;
                        case '2':
                            stahtml = "驳回";
                            break;
                    }
                    return stahtml;
                }
            },
            {field:'caozuo',title:'操作',width:'23%',halign:'center',align:'center',
                formatter:function(value,row,index){
                    var sptext = '&nbsp;&nbsp;&nbsp;&nbsp;';
                    var qyuaninfohtml = '<a href="' + qyuaninfourl + '&idx=' + row.idx + '">查看详细</a>';
                    var bmthtml = '<a href="'+ldnewsurl+'&idx='+row.idx+'" >漏洞列表</a>';
                    var edithtml = '<a href="'+editurl+'&idx='+row.idx+'">编辑</a>';
                    var Approvehtml = '<a href="' + Approveurl + '&idx=' + row.idx + '&tid=1">审核通过</a>';
                    var Rejecthtml = '<a href="' + Rejecturl + '&idx=' + row.idx + '&tid=2">审核驳回</a>';
                    return qyuaninfohtml+sptext+bmthtml+sptext+edithtml+sptext+Approvehtml+sptext+Rejecthtml ;
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
});
</script>


