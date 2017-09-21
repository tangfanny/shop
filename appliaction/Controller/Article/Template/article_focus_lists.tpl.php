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
		 <a href="#">内容管理</a> &gt; 幻灯片设置
	</div>
	<div class="line_white"></div>
	<div class="goods mt10">
		<div class="login mt10" style="border: none;">
			<table id="article_focus_lists" style="width:100%"></table>
		</div>
		<div class="clear"></div>
	</div>
	<?php include $this->admin_tpl('copyright') ?>
</div>
<!--表格js-->
	<script type="text/javascript">
	var dom = $('#article_focus_lists');
	var pageSize = <?php echo PAGE_SIZE?>;
	var dataurl = '<?php echo U('lists')?>';
	var addurl = '<?php echo U('update',array('opt'=>'add'))?>';
	var editurl = '<?php echo U('update',array('opt'=>'update'))?>';
	var delurl = '<?php echo U('update',array('opt'=>'del'))?>';
	var statusurl = '<?php echo U('update',array('opt'=>'ajax_status'))?>';
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
					id: 'addrow',
					text: '添加',
					iconCls: 'icon-add',
					handler: function () {
						window.location.href = addurl;
					}
				}, '-'
			],
			frozenColumns:[[
				{field:'id',checkbox:true}
			]],
			columns:[[
				{field:'pic',title:'图片地址',width:'25%',halign:'center',align:'center'},
				{field:'url',title:'链接地址',width:'25%',halign:'center',align:'center'},
				{field:'text',title:'文字说明',width:'20%',halign:'center',align:'center'},
				{field:'sort',title:'链接排序',width:'15%',halign:'center',align:'center'},
				{field:'status',title:'是否显示',width:'10%',halign:'center',align:'center',
					formatter:function(value,row,index){
						if(value ==1){
							statustext = '<span url="'+statusurl+'&id='+row.id+'" class="ajax-get ajax_on" onclick="dom.datagrid(\'reload\')"></span>'
						}else{
							statustext = '<span url="'+statusurl+'&id='+row.id+'" class="ajax-get ajax_off" onclick="dom.datagrid(\'reload\')"></span>'
						}
						return statustext;
					}
				},
				{field:'none',title:'操作',width:'5%',halign:'center',align:'center',
					formatter:function(value,row,index){
						var spacehtml = '&nbsp;&nbsp;&nbsp;&nbsp;';
						var edithtml = '<a href="' + editurl + '&id=' + row.id + '">编辑</a>';
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
								dom.datagrid("reload");	//重新加载
							}else{
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
