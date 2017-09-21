<?php include $this->admin_tpl("header"); ?>
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/haidaoblue/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/icon.css">
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/hd_default_config.js"></script>
<div class="content">
	<div class="site">
		 <a href="#">销售设置</a> > 积分兑换列表
	</div>
	<span class="line_white"></span>
        <div class="goods mt10">
        <dl class="mt10">
			<dt>
                            <p>
                                    <a href="<?php echo  U('MemberGroup/lists')?>" <?php if ($type == -1) { echo "class='hover'"; }; ?> > 会员等级</a>
                                    <a href="<?php echo  U('SaleRebate/salerebate')?>"  <?php if ($type == 2) { echo "class='hover'"; }; ?>>设置返利比</a>
                                    <a href="<?php echo  U('SaleIntegral/saleintegral')?>" <?php if ($type == 3) { echo "class='hover'"; }; ?>
                                            >设置积分关系</a>
                                    <a href="<?php echo  U('SaleRankExc/lists')?>" <?php if ($type == 4) { echo "class='hover'"; }; ?>
                                            >设置积分兑换比例</a>
                                    <a href="<?php echo  U('SaleList/lists')?>" <?php if ($type == 5) { echo "class='hover'"; }; ?>
                                            >查看销售结构</a>
                            </p>
			</dt>
	</dl>
        </div>
	<div class="login mt10" style="border: none;">
		<table id="group_list" style="width:100%"></table>
		<div class="clear"></div>
	</div>
	<?php include $this->admin_tpl("copyright"); ?>
	<div class="clear"></div>
</div>
<script type="text/javascript">
	var dom = $('#group_list');
	var pageSize = <?php echo PAGE_SIZE?>;
	var dataurl = '<?php echo U('lists')?>';
	var addurl = '<?php echo U('add')?>';
	var delurl = '<?php echo U('ajax_del')?>';
	var editurl = '<?php echo U('edit')?>';
	$(function(){
		dom.datagrid({
			url:dataurl,
			striped:true,
			width:'100%',
			fitColumns:true,
			checkOnSelect:true,
			toolbar:[
//                            {
//					id:'delrows',
//					text:'删除',
//					iconCls:'icon-del',
//				},'-',
//				{
//					id:'addrow',
//					text:'添加',
//					iconCls:'icon-add',
//				},'-'
				],
//				frozenColumns:[[
//					{field:'id',checkbox:true}
//				]],
				pagination:true,
				pageSize:pageSize,
				pageList: [pageSize,pageSize*2,pageSize*4],//可以设置每页记录条数的列表
				columns:[[
				{field:'sale_key_name',title:'销售所做操作的中文',halign:'center',align:'center',width:'20%'},
				{field:'sale_key_value',title:'所做操作对应的数量',width:'20%',align:'center'},
				{field:'rebate_mode',title:'返利方式',width:'20%',align:'center'},
				{field:'rank',title:'对应的积分',width:'20%',align:'center'},
				{field:'none',title:'操作',width:'20%',align:'center',halign:'center',
					formatter:function(value,row,index){
							return '<a href="'+editurl+'&id='+row.id+'">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;';
						}
				},
			]],
			onLoadSuccess:function(data){}
		});
		//添加会员
//		$('#addrow').bind('click', function(){
//			window.location.href=addurl;
//		})
		//删除操作
//		$('#delrows').bind('click', function(){
//			var ids = [];
//			var rows = dom.datagrid('getChecked');
//			for(var i=0; i<rows.length; i++){
//				ids.push(rows[i].id);
//			}
//			if (ids.length > 0){
//				$.messager.confirm('确认','您确认想要删除记录吗？',function(r){
//					if (r){
//						$.getJSON(delurl,
//						{"id[]":ids},
//						function(data){
//							if(1 == data.status){// 删除成功，则需要在树中删除节点
//								// 检修任务grid 执行load
//								dom.datagrid("reload");//重新加载
//							}else{
//								$.messager.alert('警告',data.info);
//							}
//						})
//					}else{
//						dom.datagrid('clearSelections').datagrid('clearChecked');
//					}
//				});
//			}else{
//				$.messager.alert('警告','请选择要删除的记录');
//				return false;
//			}
//		});
	})
</script>