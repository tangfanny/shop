<?php include $this -> admin_tpl('header'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/haidaoblue/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/icon.css">
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/hd_default_config.js"></script>
<div class="content">
    <div class="site">
        <a href="#">内容管理</a> > App底部按鈕列表
    </div>
    <span class="line_white"></span>
    <div class="goods mt10">
        <div class="login mt10" style="border: none;">
            <table id="article_app_button_lists" style="width:100%"></table>
        </div>
        <div class="clear"></div>
    </div>
</div>
<!--表格js-->
<script type="text/javascript">
    var dom = $('#article_app_button_lists');
    var pageSize = <?php echo PAGE_SIZE?>;
    var dataurl = '<?php echo U('lists')?>';
    var addurl = '<?php echo U('update',array('opt'=>'add'))?>';
    var editurl = '<?php echo U('update',array('opt'=>'update'))?>';
    var delurl = '<?php echo U('update',array('opt'=>'del'))?>';
    var sorturl = '<?php echo U('ajax_sort')?>';
    var statusurl = '<?php echo U('ajax_status')?>';
    $(function() {
        dom.datagrid({
            url: dataurl,
            striped: true,
            width: '100%',
            checkOnSelect: true,
            fitColumns: true,
            toolbar: [{
                id: 'delrows',
                text: '删除',
                iconCls: 'icon-del'
            }, '-',
                {
                    id: 'addrow',
                    text: '添加',
                    iconCls: 'icon-add',
                    handler: function () {
                        window.location.href = addurl;
                    }
                }, '-'
            ],
            frozenColumns: [[
                {field: 'id', checkbox: true}
            ]],
            pagination: true,
            pageSize: pageSize,
            pageList: [pageSize, pageSize * 2, pageSize * 4],//可以设置每页记录条数的列表
            fitColumns:true,
            sortName:'sort',
            columns: [[
                {
                    field: 'name',
                    title: '按钮名称',
                    width: '6%',
                    align: 'center',
                    editor: {type: 'validatebox', options: {required: true}}
                },
                
                {
                    field: 'img_selected', title: '选中图片',fixed:true, width: '19%', halign: 'center', align: 'left',
                    formatter: function (value, row, index) {
                        var sptext = '&nbsp;&nbsp;&nbsp;&nbsp;';
                        var picaddress = value;
                        var ul = '<?php echo IMG_URL;?>';
                        var viewhtml = '<a href="' +ul+ value + '"  target="_blank" title="' + value + '">查看</a>';
                        return viewhtml + ul+ picaddress;
                    }, editor: {type: 'validatebox', options: {required: true}}
                },
                {
                    field: 'img_default', title: '默认图片', width: '19%', halign: 'center', align: 'left',
                    formatter: function (value, row, index) {
                        var sptext = '&nbsp;&nbsp;&nbsp;&nbsp;';
                        var picaddress = value;
                        var ul = '<?php echo IMG_URL;?>';
                        var viewhtml = '<a href="' + ul+value + '"  target="_blank" title="' + value + '">查看</a>';
                        return viewhtml + ul+ picaddress;
                    }, editor: {type: 'validatebox', options: {required: true}}
                },
//                {
//                    field: 'day_img_selected', title: '节日选中图片',fixed:true, width: '12%', halign: 'center', align: 'left',
//                    formatter: function (value, row, index) {
//                        var sptext = '&nbsp;&nbsp;&nbsp;&nbsp;';
//                        var picaddress = value;
//                        var viewhtml = '<a href="' + value + '" target="_blank" target="_blank" title="' + value + '">查看</a>';
//                        return viewhtml + sptext + picaddress;
//                    }, editor: {type: 'validatebox', options: {required: true}}
//                },
//                {
//                    field: 'day_img_default', title: '节日默认图片', width: '12%', halign: 'center', align: 'left',
//                    formatter: function (value, row, index) {
//                        var sptext = '&nbsp;&nbsp;&nbsp;&nbsp;';
//                        var picaddress = value;
//                        var viewhtml = '<a href="' + value + '" target="_blank" target="_blank" title="' + value + '">查看</a>';
//                        return viewhtml + sptext + picaddress;
//                    }, editor: {type: 'validatebox', options: {required: true}}
//                },
                {
                    field: 'color_selected',
                    title: '选中颜色',
                    width: '7%',
                    halign: 'center',
                    align: 'center',
                    editor: {type: 'validatebox', options: {required: true}}
                },
                {
                    field: 'start_time',
                    title: '起始时间',
                    width: '12%',
                    halign: 'center',
                    align: 'center',
                    sortable: true,
                    formatter: function (value, row, index) {
                        return $.fn.datebox.defaults.timeformat(value);
                    }
                },
                {
                    field: 'end_time',
                    title: '结束时间',
                    width: '12%',
                    halign: 'center',
                    align: 'center',
                    sortable: true,
                    formatter: function (value, row, index) {
                        return $.fn.datebox.defaults.timeformat(value);
                    }
                },
                {
                    field: 'sort',
                    title: '按钮排序',
                    width: '8%',
                    halign: 'center',
                    align: 'center',
                    sortable:true,
                    editor: {type: 'numberspinner', options: {required: true}},
                    formatter:function(value,row,index){
                        return '<input name="sort" class="easyui-numberspinner sort" style="width:80px;" required="required" data-options="min:0,editable:true" value="'+value+'" data-id="'+row.id+'">';
                    }
                },
                {
                    field: 'status', title: '是否显示', width: '7%', halign: 'center', align: 'center', sortable: true,
                    formatter:function(value,row,index){
                        if (value == 1){
                            statushtml = '<span url="'+statusurl+'&id='+row.id+'" class="ajax-get ajax_on" ></span>';
                        }else{
                            statushtml = '<span url="'+statusurl+'&id='+row.id+'" class="ajax-get ajax_off" ></span>';
                        }
                        return statushtml;
                    },
                    editor: {type: 'validatebox', options: {required: true}}
                },
                {
                    field: 'none', title: '操作', width: '10%', halign: 'center', align: 'center',
                    formatter: function (value, row, index) {
                        var spacehtml = '&nbsp;&nbsp;&nbsp;&nbsp;';
                        var edithtml = '<a href="' + editurl + '&id=' + row.id + '">编辑</a>';
                        var delhtml = '<a onclick="dom.datagrid(\'clearSelections\').datagrid(\'clearChecked\').datagrid(\'checkRow\',' + index + ');$(\'#delrows\').trigger(\'click\')" href="#">删除</a>';
                        return edithtml + spacehtml + delhtml;
                    }
                }
            ]],
            onLoadSuccess:function(data){
                $('.sort').numberspinner({
                    onChange:function(nvalue,ovalue){
                        var id = $(this).attr('data-id');
                        ChangeSort(id,nvalue);
                    }
                });
                $('.datagrid-btable td[field="sort"]').each(function(){
                    $(this).click(function(){
                        return false;
                    });
                })
            }   
        });
        //修改排序
        function ChangeSort(id,val){
            $.messager.progress();
            $.getJSON(sorturl, {"id": id,"val": val}, function(data) {
                $.messager.progress('close');
            })
        }
        //排序输入框
        $('.input_shu').numberbox({ 
            min:0,  
            value:100,
        }); 
        //删除操作
        $('#delrows').bind('click', function () {
            var ids = [];
            var rows = dom.datagrid('getChecked');
            for (var i = 0; i < rows.length; i++) {
                ids.push(rows[i].id);
            }
            if (ids.length > 0) {
                $.messager.confirm('确认', '您确认想要删除记录吗？', function (r) {
                    if (r) {
                        $.getJSON(delurl,
                            {"id[]": ids},
                            function (data) {
                                if (1 == data.status) {// 删除成功，则需要在树中删除节点
                                    // 检修任务grid 执行load
                                    dom.datagrid("reload");  //重新加载
                                } else {
                                    $.messager.alert('警告', data.info);
                                }
                            })
                    }
                });
            } else {
                $.messager.alert('警告', '请选择要删除的记录');
                return false;
            }
        });
})
</script>
