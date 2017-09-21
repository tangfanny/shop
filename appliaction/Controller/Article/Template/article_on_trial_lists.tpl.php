<?php include $this -> admin_tpl('header'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/haidaoblue/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/icon.css">
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/hd_default_config.js"></script>
<div class="content">
	<div class="site">
		 <a href="#">内容管理</a> > 试用申请
	</div>
	<span class="line_white"></span>
	<div class="goods mt10">
		<div class="login mt10" style="border: none;">
			<table id="article_lists" style="width:100%"></table>
		</div>
		<div class="clear"></div>
		<?php include $this->admin_tpl('copyright') ?>
	</div>
</div>
<!--表格js-->
	<script type="text/javascript">
	var dom = $('#article_lists');
	var pageSize = <?php echo PAGE_SIZE?>;
	var dataurl = '<?php echo U('lists')?>';
	var addurl = '<?php echo U('update',array('opt'=>'add'))?>';
	var order_url = '<?php echo U('admin_order/edit')?>';
	var delurl = '<?php echo U('update',array('opt'=>'del'))?>';
	var topurl = '<?php echo U('update',array('opt'=>'ajax_top'))?>';
	var processingflag = '<?php echo U('update',array('opt'=>'updataflag'))?>';
	$(function(){
		dom.datagrid({
			url:dataurl,
			striped:true,
			width:'100%',
			checkOnSelect:true,
			fitColumns:true,
			toolbar:[{
					id:'delrows',
					text:'删除',
					iconCls:'icon-del',
				},'-'
//				{
//					id:'addrow',
//					text:'添加',
//					iconCls:'icon-add',
//				},'-'
			],
			frozenColumns:[[
				{field:'id',checkbox:true}
			]],
			pagination:true,
			pageSize:pageSize,
			pageList: [pageSize,pageSize*2,pageSize*4],//可以设置每页记录条数的列表
			columns:[[
				{field:'name',title:'名称',width:'10%',halign:'center',align:'center'},
				{field:'phone',title:'电话',width:'15%',halign:'center',align:'center'},
				{field:'address',title:'地址',width:'15%',halign:'center',align:'center'},
				{field:'goods_name',title:'申请商品名称',width:'15%',halign:'center',align:'center'},
                                {field:'createtime',title:'申请时间',width:'10%',halign:'center',align:'center',sortable:true,
					formatter:function(value,row,index){
  						return $.fn.datebox.defaults.timeformat(value);
					}
				},
                                {field:'processing_time',title:'处理时间',width:'15%',halign:'center',align:'center',sortable:true,
					formatter:function(value,row,index){
                                                if(value==0){
                                                    return "";
                                                }else{
                                                    return $.fn.datebox.defaults.timeformat(value);
                                                }
					}
				},
				{field:'none',title:'操作',width:'20%',halign:'center',align:'center',
					formatter:function(value,row,index){
                                                if(row.processing_time==0){
                                                     var falsehtml = '<a href="'+processingflag+'&id='+row.id+'">未处理</a>&nbsp;&nbsp;&nbsp;&nbsp;';
                                                }else{
                                                     var falsehtml="已处理&nbsp;&nbsp;&nbsp;&nbsp;";
                                                }
						var edithtml = '<a href="index.php?c=admin_order&a=edit&order_sn='+row.order_sn+'">查看</a>&nbsp;&nbsp;&nbsp;&nbsp;';
						var delhtml = '<a onclick="dom.datagrid(\'clearSelections\').datagrid(\'clearChecked\').datagrid(\'checkRow\','+index+');$(\'#delrows\').trigger(\'click\')" href="#">删除</a>';
						return falsehtml+edithtml + delhtml;
					}
				},
			]]
		});
//		//添加
//		$('#addrow').bind('click', function(){
//			window.location.href=addurl;
//		})
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
								dom.datagrid("reload");  //重新加载
							}else{
								$.messager.alert('警告',data.info);
							}
						})
					}
				});
			}else{
				$.messager.alert('警告','请选择要删除的记录');
				return false;
			}
		});
	})
</script>
