<?php include $this->admin_tpl("header"); ?>
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/haidaoblue/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/icon.css">
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/hd_default_config.js"></script>
<div class="content">
	<div class="site">
		 <a href="#">销售设置</a> > 销售列表
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
    <br>
    <span style="margin-right: 10px;">会员搜索 </span>
			<input id="keyword" class="easyui-textbox" name="keyword" style="width:210px;height: 26px;" prompt="输入销售名称/手机/EMAIL">
			<a id="search" href="#" class="easyui-linkbutton" style="height: 26px;padding-right: 10px;">查询</a>
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
				// frozenColumns:[[
				// 	{field:'id',checkbox:true}
				// ]],
				pagination:true,
				pageSize:pageSize,
				pageList: [pageSize,pageSize*2,pageSize*4],//可以设置每页记录条数的列表
				columns:[[
				{field:'mobile',title:'销售手机号',halign:'center',align:'center',width:'20%'},
				{field:'tuaname',title:'销售名称',width:'10%',align:'center'},
				{field:'roles_flag',title:'认证状态',width:'10%',align:'center'},
				{field:'gname',title:'当前级别',width:'10%',align:'center'},
				{field:'integral',title:'总积分',width:'10%',align:'center'},
				{field:'balance',title:'余额',width:'10%',align:'center'},
				{field:'income_msg',title:'当前收益',width:'10%',align:'center'},
				{field:'login_time',title:'最后上线',width:'11%',align:'center',
					formatter:function(value,row,index){
	                    if(value!=null && value!=0){
	                        return $.fn.datebox.defaults.timeformat(value);
	                    }else{
	                        return "-";
	                    }
				}},
				{field:'none',title:'查看',width:'10%',align:'center',halign:'center',
					formatter:function(value,row,index){
							return '<a href="'+editurl+'&id='+row.id+'">查看</a>&nbsp;&nbsp;&nbsp;&nbsp;';
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