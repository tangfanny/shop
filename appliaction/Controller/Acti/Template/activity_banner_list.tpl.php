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
         <a href="<?php echo U('Activity/edit',array('id'=>"$id"))?>">活动模板</a> &gt; Banner设置
    </div>
    <div class="line_white"></div>
    <div class="goods mt10">
        <div class="login mt10" style="border: none;">
            <table id="activity_banner_list" style="width:100%"></table>
        </div>
        <div class="clear"></div>
    </div>
    <?php include $this->admin_tpl('copyright') ?>
</div>
<!--表格js-->
    <script type="text/javascript">
    var dom = $('#activity_banner_list');
    var pageSize = <?php echo PAGE_SIZE?>;
    var dataurl = '<?php echo U('BannerList',array('id'=>"$id"))?>';
    var addurl = '<?php echo U('bannerUpdate',array('opt'=>'add','id'=>"$id"))?>';
    var editurl = '<?php echo U('bannerUpdate',array('opt'=>'update'))?>';
    var delurl = '<?php echo U('BannerUpdate',array('opt'=>'del'))?>';
    var statusurl = '<?php echo U('BannerUpdate',array('opt'=>'ajax_status','id'=>"$id"))?>';
    var timestamp = <?php echo time();?>;
    $(function(){
        dom.datagrid({
            url:dataurl,
            striped:true,
            width:'100%',
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
//                   //添加导航
                     handler:function(){
                         window.location.href = addurl+ '&aid=' + '<?php echo $id; ?> ';
                    }
                },'-'
            ],
            frozenColumns:[[
                {field:'id',checkbox:true}
            ]],
            columns:[[
                {field:'aid',hidden:true},
                {field:'name',title:'图片标题',width:'15%',halign:'center',align:'center'},
                {field:'pic',title:'图片地址',width:'24%',halign:'center',align:'center',
                    formatter:function(value,row,index){
                        sptext = '&nbsp;&nbsp;&nbsp;&nbsp;';
                        picaddress = value;
                        viewhtml = '<a href="<?php echo IMG_URL; ?>'+value+'" target="_blank" target="_blank">查看</a>';
                        return picaddress+sptext+viewhtml;
                    }
                },               
                {field:'url',title:'链接地址',width:'24%',halign:'center',align:'center'},
                {field:'rankid',title:'链接排序',width:'6%',halign:'center',align:'center'},
                {field:'is_show',title:'是否显示',width:'7%',halign:'center',align:'center',
                    formatter:function(value,row,index){
                        if(value ==1){
                            statustext = '<span url="'+statusurl+'&id='+row.id+'" class="ajax-get ajax_on" onclick="dom.datagrid(\'reload\')"></span>';
                        }else{
                            statustext = '<span url="'+statusurl+'&id='+row.id+'" class="ajax-get ajax_off" onclick="dom.datagrid(\'reload\')"></span>'
                        }
                        return statustext;
                    }
                },
                {field:'addtime',title:'上传时间',width:'10%',align:'center',sortable:true,
                    formatter:function(value,row,index){  
    //                                    alert(value);
                        return $.fn.datebox.defaults.timeformat(value);
                    }
                },
                {field:'none',title:'操作',width:'14%',halign:'center',align:'center',
                    formatter:function(value,row,index){
                        var spacehtml = '&nbsp;&nbsp;&nbsp;&nbsp;';
                        var edithtml = '<a href="' + editurl + '&id=' + row.id + '&aid=' + row.aid+'">编辑</a>';
                        var delhtml = '<a onclick="dom.datagrid(\'clearSelections\').datagrid(\'clearChecked\').datagrid(\'checkRow\','+index+');$(\'#delrows\').trigger(\'click\')" href="#">删除</a>';
                        return edithtml+spacehtml+delhtml;
                    }
                }
            ]]
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
//                                dom.datagrid("reload"); //重新加载
                                location.reload();
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
    })
</script>

