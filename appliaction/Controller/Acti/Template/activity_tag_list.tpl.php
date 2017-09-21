<?php include $this->admin_tpl('header'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/haidaoblue/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/icon.css">
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/hd_default_config.js"></script>
<style type="text/css">
    input{margin-top: 0px;}
    .text_input{margin-right: 0px;}
</style>
<div class="content">
    <div class="site">
         <a href="#">运营推广</a> &gt; 活动标签
    </div>
    <div class="line_white"></div>
    <div class="goods mt10">
        <div class="login mt10" style="border: none;">
            <table id="activity_tag_list" style="width:100%"></table>
        </div>
        <div class="clear"></div>
    </div>
    <?php include $this->admin_tpl('copyright') ?>
</div>
<!--表格js-->
    <script type="text/javascript">
    var dom = $('#activity_tag_list');
    var pageSize = <?php echo PAGE_SIZE?>;
    var dataurl = '<?php echo U('taglists')?>';
    var addurl = '<?php echo U('tagUpdate',array('opt'=>'add','id'=>"$id"))?>';
    var editurl = '<?php echo U('tagUpdate',array('opt'=>'update'))?>';
    var delurl = '<?php echo U('tagUpdate',array('opt'=>'del'))?>';
    var statusurl = '<?php echo U('tagUpdate',array('opt'=>'ajax_status'))?>';
    var editRow = undefined;
    //var packageCompdata = '';
    $(function(){
        dom.datagrid({
            url:dataurl,
            striped:true,
            width:'50%',
            checkOnSelect:true,
            fitColumns:true,
            toolbar:[
                {
                    id:'delrows',
                    text:'删除',
                    iconCls:'icon-del'
                },'-',
                {
                    id:'addnavrows',
                    text:'添加',
                    iconCls:'icon-add',
                    handler:function(){
                        window.location.href = addurl;
                    }
                },'-'
            ],
            frozenColumns:[[
                {field:'id',checkbox:true}
            ]],
            columns:[[
                {field:'name',title:'名称',width:'40%',halign:'center',align:'center',editor:{type:'text'}},
                {field:'location',hidden:true},              
                {field:'sort',title:'排序',width:'14%',halign:'center',align:'center',editor:{type:'numberspinner', options:{required:true}}},
                {field:'status',title:'是否显示',width:'16%',halign:'center',align:'center',editor:{type:'checkbox',options:{on:'1',off:'0'}},
                    formatter:function(value,row,index){
                        if(value ==1){
                            statustext = '<span url="'+statusurl+'&id='+row.id+'" class="ajax-get ajax_on" onclick="dom.datagrid(\'reload\')"></span>'
                        }else{
                            statustext = '<span url="'+statusurl+'&id='+row.id+'" class="ajax-get ajax_off" onclick="dom.datagrid(\'reload\')"></span>'
                        }
                        return statustext;
                    }
                },
                {field:'none',title:'操作',width:'30%',halign:'center',align:'center',
                    formatter:function(value,row,index){
                        var spacehtml = '&nbsp;&nbsp;&nbsp;&nbsp;';
                        var edithtml = '<a href="' + editurl + '&id=' + row.id + '&aid=' + row.aid+'">编辑</a>';
                        var delhtml = '<a onclick="dom.datagrid(\'clearSelections\').datagrid(\'clearChecked\').datagrid(\'checkRow\','+index+');$(\'#delrows\').trigger(\'click\')" href="#">删除</a>';
                        return edithtml+spacehtml+delhtml;
                    }
                }
            ]],
            onLoadSuccess:function(data){
                //console.log(data);
            },
            onAfterEdit: function (rowIndex, rowData, changes) {
                editRow = undefined;
            }
        });
        //删除操作
        $('#delrows').bind('click', function(){
            var ids = [];
            var rows = dom.datagrid('getChecked');
            for(var i=0; i<rows.length; i++){
                ids.push(rows[i].id);
            }
            if (ids.length > 0){
                $.messager.confirm('确认','您确认想要删除记录吗？',function(r){
                    if (r){
                        $.getJSON(delurl,
                        {"id[]":ids},
                        function(data){
                            if(1 == data.status){// 删除成功，则需要在树中删除节点
                                // 检修任务grid 执行load
                                location.reload();//重新加载
                            }else{
                                dom.datagrid("reload"); //重新加载
                                $.messager.alert('警告',data.info);
                            }
                        })
                    }else{
                        dom.datagrid('clearSelections').datagrid('clearChecked');
                    }
                });
            }else{
                $.messager.alert('警告','请选择要删除的记录');
                return false;
            }
        });
    });

</script>