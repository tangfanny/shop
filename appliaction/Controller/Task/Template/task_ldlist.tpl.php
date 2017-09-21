<?php  include  $this->admin_tpl('header'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/haidaoblue/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/icon.css">
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/hd_default_config.js"></script>
<div class="content">
    <div class="site">
        <a >众测管理</a> >
        <a href="<?php echo U('Task/lists');?>">众测项目列表</a> >
        <a >漏洞列表</a>
    </div>
    <span class="line_white"></span>
    <div class="goods mt10">
        <div class="search_ind">
            <input type="hidden" name="m" value="<?php echo GROUP_NAME ?>">
            <input type="hidden" name="c" value="<?php echo MODULE_NAME ?>">
            <input type="hidden" name="a" value="<?php echo ACTION_NAME ?>">
            <span style="margin-right: 10px;">漏洞搜索 </span>
            <input id="keyword" class="easyui-textbox" name="keyword" style="width:250px;height: 26px;" prompt="输入漏洞标题/测试ip/漏洞类别">
            <a id="search" href="#" class="easyui-linkbutton" style="height: 26px;padding-right: 10px;">查询</a>
        </div>
        <div class="login mt10" style="border: none;border-right: 1px solid #e6e6e6;">
            <table id="task_ldlist" style="width:100%;"></table>
        </div>
        <div class="clear"></div>
        <?php include $this->admin_tpl('copyright') ?>
    </div>
</div>
<!--表格js-->
<script type="text/javascript">
    var dom = $('#task_ldlist');
    var pageSize = <?php echo PAGE_SIZE?>;
    var dataurl = '<?php echo U('ldlist')?>';
    var keyword = '<?php echo $keyword?>';
    var task_id = '<?php echo $tid?>';
    var shenheurl = '<?php echo U('ldshenhe')?>';
    $(function(){
        dom.datagrid({
            url:dataurl,
            striped:true,
            width:'100%',
            checkOnSelect:false,
            fitColumns:true,
            queryParams:{
                keyword:keyword,
                task_id:task_id
            },
            scrollbarSize:0,
            pagination:true,
            pageSize:pageSize,
            pageList: [pageSize,pageSize*4,pageSize*8,pageSize*16,pageSize*32,pageSize*64],
            //可以设置每页记录条数的列表
            columns:[[
                {field:'title',title:'漏洞标题',width:'16%',halign:'center',align:'center'},
                {field:'email',title:'白帽子邮箱',width:'16%',halign:'center',align:'center'},
                {field:'test_ip',title:'测试ip',width:'16%',halign:'center',align:'center'},
                {field:'level',title:'级别',width:'14%',align:'center',sortable:true,align:'center'},
                {field:'bug_class',title:'漏洞类别',width:'16%',halign:'center',align:'center',sortable:true},
                {field:'none',title:'操作',width:'20%',halign:'center',align:'center',
                    formatter:function(value,row,index){
                        var shenhehtml = '<a href="'+shenheurl+'&bugid='+row.bugid+'" >查看审核</a>';
                        return shenhehtml;
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