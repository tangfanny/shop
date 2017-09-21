<?php  include  $this->admin_tpl('header'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/haidaoblue/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/icon.css">
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/hd_default_config.js"></script>
<div class="content">
	<div class="site">
	 <a href="#">订单管理</a> > 订单列表
	</div>
	<span class="line_white"></span>
	<div class="goods mt10">
		<div class="search_ind">
			<input type="hidden" name="m" value="<?php echo GROUP_NAME ?>">
			<input type="hidden" name="c" value="<?php echo MODULE_NAME ?>">
			<input type="hidden" name="a" value="<?php echo ACTION_NAME ?>">
<!--			<span style="margin-right: 10px;">订单搜索 </span>
			<input id="keyword" class="easyui-textbox" name="keyword" style="width:210px;height: 26px;" prompt="输入单号/收货人姓名/手机均可查询">
			<a id="search" href="#" class="easyui-linkbutton" style="height: 26px;padding-right: 10px;">查询</a>-->
		</div>
		
		<div class="login mt10" style="border: none;border-right: 1px solid #e6e6e6;">
			<table id="order_list_grid" style="width:100%;"></table> 
		</div>
		<div class="clear"></div>
		<?php include $this->admin_tpl('copyright') ?>
	</div>
</div>
	<script type="text/javascript">
		$(function() {
		//批量操作
			$(".batch").hover(function() {
				$(this).find("p").show();
				}, function() {
				$(this).find("p").hide();
			});
		})
		//改变状态架
		function corderstatus(ftype,val) {
			var arr = [];
			$("input[name='selid[]']:checked").each(function() {
				arr.push($(this).val());
			});
			if (arr.length == 0) {
				alert('请选择操作项目');
				return false;
			}
			$.post("<?php echo U('AdminOrder/ajax_status');?>", {"ftype":ftype ,"id": arr.toString(), "val": val}, function(data) {
				if (data.status == 1) {
				location.reload();
				}
			})
		}
		//切换
		$(function() {
			var tabTitle = ".mt10 dt p a";
			$(tabTitle).click(function(){
				$(this).siblings("a").removeClass("hover").end().addClass("hover");
			});
		});
	</script> 
	<!--表格js-->
	<script type="text/javascript">
	var dom = $('#order_list_grid');
	var pageSize = <?php echo PAGE_SIZE?>;
	var dataurl = '<?php echo U('ordergoodslists')?>';
	var delurl = '<?php echo U('delete')?>';
	var editurl = '<?php echo U('edit')?>';
	var imgpach = '<?php echo IMG_PATH;?>';
	var region_arr	= <?php echo json_encode($region_arr)?>;
	var delivery_arr = <?php echo json_encode($this->deliverys)?>;
	var order_status = <?php echo json_encode($this->_config['c_order_status'])?>;
	var pay_status = <?php echo json_encode($this->_config['c_pay_status'])?>;
	var delivery_status = <?php echo json_encode($this->_config['c_delivery_status'])?>;
	var type = <?php echo $type?>;
	var keyword = '<?php echo $keyword?>';
	var user_id = <?php echo $user_id?>;
	$(function(){
		dom.datagrid({
			url:dataurl, 
			striped:true,
			width:'100%',
			checkOnSelect:false,
			fitColumns:true,
			toolbar:[
				// {
				// 	id:'delrows',
				// 	text:'删除',
				// 	iconCls:'icon-del',
				// },'-',
				{
					id:'exportrows',
					text:'导出',
					iconCls:'icon-export',
				},'-'
				// ,{
				// 	id:'printdelivery',
				// 	text:'打印快递单',
				// 	iconCls:'icon-print',
				// },'-'
			],
			frozenColumns:[[
				{field:'id',checkbox:true}
			]],
			queryParams:{
				type:type,
				keyword:keyword,
				user_id:user_id
			},
			scrollbarSize:0,
			pagination:true,
			pageSize:pageSize,
			pageList: [pageSize,pageSize*4,pageSize*8,pageSize*16,pageSize*32,pageSize*64],
			//可以设置每页记录条数的列表 
			columns:[[
			{field:'number',title:'总数量',width:'13%',halign:'center',align:'center'},
			{field:'sgoodsname',title:'商品名称',width:'25%',halign:'center',align:'center',sortable:true},
			{field:'bname',title:'厂商名称',width:'25%',halign:'center',align:'center',sortable:true},
			{field:'spec_array',title:'商品规格',width:'35%',halign:'center',align:'center',
				formatter:function(value,row,index){
					return row.name+row.value;
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
		// 打印订单
		$('#printdelivery').bind('click', function(){
			var ids = [];
			var rows = dom.datagrid('getChecked');
			for(var i=0; i<rows.length; i++){
				ids.push(rows[i].id);
			}
			if (ids.length > 0){
				console.debug(rows);
				// $.messager.confirm('确认','您确认想要删除记录吗？',function(r){
				// 	if (r){
				// 		$.post(delurl,{"id[]":ids}, function(data){			 
				// 			if(1 == data.status){// 删除成功，则需要在树中删除节点
				// 				// 检修任务grid 执行load
				// 				dom.datagrid("reload");  //重新加载
				// 			}else{
				// 				$.messager.alert('警告',data.info);
				// 			}
				// 		}, 'JSON');
				// 	}else{
				// 		dom.datagrid('clearSelections').datagrid('clearChecked');
				// 	}
				// });
			}else{
				$.messager.alert('友情提示','请勾选您要打印的记录');
				return false;
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