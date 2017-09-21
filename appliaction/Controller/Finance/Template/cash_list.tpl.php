<?php include $this->admin_tpl("header"); ?>
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/haidaoblue/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/icon.css">
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/locale/easyui-lang-zh_CN.js"></script>
<style type="text/css">
.menu {background:#FFFFFF;}
#batch .m-btn-small {margin-left: 0;}
</style>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/hd_default_config.js"></script>
    <!-- 内容区 -->
    <div class="content">
        <div class="site">
            <a href="javascript:location.replace(location.href);">财务管理</a> >
            <a href="javascript:location.replace(location.href);">提现审核</a>
        </div>
        <span class="line_white"></span>
    <div class="goods mt10">
        <div class="guanli">
            <span style="margin-right: 10px;margin-left: 4px;">提现搜索</span>
            <input id="keyword" class="easyui-textbox" name="keyword" style="width:210px;height: 26px;" prompt="输入提现单号 / 邮箱 / 手机号">
            <a id="search" href="javascript:void(0);" class="easyui-linkbutton" style="height: 26px;padding:0 17px 0 8px;">查询</a>
        </div>
        <dl class="mt10">
            <dt><p>
                <a href="<?php echo U('lists');?>" <?php if($_GET['status'] == ''){?>class="hover"<?php } ?> >全部</a>
                <a href="<?php echo U('lists?status=1');?>" <?php if($_GET['status'] == '1'){?>class="hover"<?php } ?> >申请中</a>
                <a href="<?php echo U('lists?status=2');?>" <?php if($_GET['status'] == '2'){?>class="hover"<?php } ?> >审核中</a>
                <a href="<?php echo U('lists?status=3');?>" <?php if($_GET['status'] == '3'){?>class="hover"<?php } ?> >已出款</a>
                <a href="<?php echo U('lists?status=4');?>" <?php if($_GET['status'] == '4'){?>class="hover"<?php } ?> >驳回</a>
            </dt>
            <dd>
                <div class="login mt10" style="border: none;">
                    <table id="order_list_grid" style="width:100%"></table> 
                </div>
                <div class="clear"></div>
            </dd>
        </dl>
    </div>
<!-- /内容区 -->
    <script type="text/javascript">
        $(function(){
            //默认高亮
            $(window.parent.document).find(".z_side").removeClass("hover");
            $(window.parent.document).find(".n10").addClass("hover");
        })
    </script>
<!--表格js-->
    <script type="text/javascript">
    var dom = $('#order_list_grid');
    var status = '<?php echo $status?>';
    var pageSize = <?php echo PAGE_SIZE?>;
    var dataurl = '<?php echo U('lists');?>';
    var editurl = '<?php echo U('edit');?>';
    var keyword = '<?php echo $keyword?>';
    $(function(){   
        dom.datagrid({   
            url:dataurl, 
            striped:true,
            width:'100%',
            checkOnSelect:false,
            fitColumns:true, 
            queryParams:{
                status:status,
                keyword:keyword
            },
            pagination:true,
            pageSize:pageSize,
            pageList: [pageSize,pageSize*2,pageSize*4],//可以设置每页记录条数的列表 
            columns:[[
                {field:'cash_id',title:'提现单号',width:'12%',halign:'center',align:'center'},
                {field:'email',title:'邮箱',width:'10%',halign:'center',align:'center'},
                {field:'mobile',title:'手机号',width:'10%',halign:'center',align:'center'},
                {field:'nikename',title:'昵称',width:'10%',halign:'center',align:'center'},
                {field:'money',title:'金额',width:'8%',halign:'center',align:'center'},
                {field:'apply_time',title:'申请时间',width:'10%',align:'center',
                    formatter:function(value,row,index){
                        return $.fn.datebox.defaults.timeformat(row.apply_time);
                    }
                },
                {field:'check_time',title:'审核时间',width:'10%',align:'center',
                    formatter:function(value,row,index){
                        if(value!="" && value!=null && value != 0){
                            return $.fn.datebox.defaults.timeformat(row.check_time);
                        }else{
                            return "";
                        }
                    }
                },
                {field:'cash_time',title:'出款时间',width:'10%',align:'center',
                    formatter:function(value,row,index){
                        if(value!="" && value!=null && value != 0){
                            return $.fn.datebox.defaults.timeformat(row.cash_time);
                        }else{
                            return "";
                        }
                    }
                },
                {field:'status',title:'状态',width:'10%',halign:'center',align:'center',
                    formatter:function(value,row,index){
                        switch (row.status) {
                            case '1':
                                statushtml = "申请中";
                                break;
                            case '2':
                                statushtml = "审核中";
                                break;
                            case '3':
                                statushtml = "已出款";
                                break;
                            default:
                                statushtml = "驳回";
                                break;
                        }
                        return statushtml;
                    }
                },
                {field:'none',title:'操作',width:'11%',halign:'center',align:'center',
                    formatter:function(value,row,index){
                        edithtml = '<a href="'+editurl+'&id='+row.id+'">审核</a>';
                        lookhtml = '<a href="'+editurl+'&id='+row.id+'">查看</a>';
                        if (row.status == 1 || row.status == 2){
                            return edithtml;
                        }else{
                            return lookhtml;
                        }
                    }
                },
            ]],   
        });

        //回车查询
        $('#keyword').textbox('textbox').bind('keydown',function (e) {
            if (e.keyCode == 13) {
                $('#search').trigger('click');
            }
        });
        //增加查询参数，重新加载表格  
        $('#search').bind('click',function (){  
            var queryParams = dom.datagrid('options').queryParams; 
            //查询参数直接添加在queryParams中
            queryParams.keyword = $("#keyword").val();
            dom.datagrid('options').queryParams = queryParams;  
            dom.datagrid('reload');
        })
    })
</script>