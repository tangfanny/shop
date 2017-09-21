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
        <a >报名列表</a>
    </div>
    <span class="line_white"></span>
    <div class="goods mt10">
        <div class="search_ind">
            <input type="hidden" name="m" value="<?php echo GROUP_NAME ?>">
            <input type="hidden" name="c" value="<?php echo MODULE_NAME ?>">
            <input type="hidden" name="a" value="<?php echo ACTION_NAME ?>">
            <span style="margin-right: 10px;">众测搜索 </span>
            <input id="keyword" class="easyui-textbox" name="keyword" style="width:250px;height: 26px;" prompt="输入手机号/EMAIL/昵称">
            <a id="search" href="#" class="easyui-linkbutton" style="height: 26px;padding-right: 10px;">查询</a>
        </div>
        <div class="login mt10" style="border: none;border-right: 1px solid #e6e6e6;">
            <table id="task_bmlist" style="width:100%;"></table>
        </div>
        <div class="clear"></div>
        <?php include $this->admin_tpl('copyright') ?>
    </div>
</div>
<!--表格js-->
<script type="text/javascript">
    var dom = $('#task_bmlist');
    var pageSize = <?php echo PAGE_SIZE?>;
    var dataurl = '<?php echo U('bmlist')?>';
    var showinfourl = '<?php echo U('showinfo')?>';
    var keyword = '<?php echo $keyword?>';
    var task_id = '<?php echo $tid?>';
    var statusurl = '<?php echo U('ajax_status')?>';
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
                {field:'email',title:'邮箱',width:'16%',halign:'center',align:'center'},
                {field:'mobile',title:'手机',width:'16%',halign:'center',align:'center'},
                {field:'nikename',title:'昵称',width:'17%',halign:'center',align:'center'},
                {field:'create_time',title:'报名时间',width:'17%',align:'center',sortable:true,
                    formatter:function(value,row,index){
                        if(value!=null && value!=0){
                            return $.fn.datebox.defaults.timeformat(value);
                        }else{
                            return "-";
                        }
                    }
                },
                {field:'ispass',title:'报名状态',width:'17%',halign:'center',align:'center',sortable:true,
                    formatter:function(value,row,index){
                        if (row.ispass == 1){
                            statushtml = '<span url="'+statusurl+'&uid='+row.uid+'" class="ajax-get ajax_on" ></span>';
                        }else{
                            statushtml = '<span url="'+statusurl+'&uid='+row.uid+'" class="ajax-get ajax_off" ></span>';
                        }
                        return statushtml;
                    },
                    editor: {type: 'validatebox', options: {required: true}}
                },
                {field:'none',title:'详细',width:'17%',halign:'center',align:'center',
                    formatter:function(value,row,index){
                        var viewthtml = '<a href="'+showinfourl+'&uid='+row.uid+'" >查看详细信息</a>';
                        return viewthtml;
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