<?php include $this -> admin_tpl('header'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/haidaoblue/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/icon.css">
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/hd_default_config.js"></script>
<div class="content">
<div class="site">
	 <a href="#">内容管理</a> > 价格统计
</div>
<span class="line_white"></span>
	<div class="install mt10">
		<dl>
                    <dt><a href="<?php echo  U('ArticleCheap/lists')?>" <?php if ($type == -1) { echo "class='hover'"; }; ?> >全部统计</a>
                        <a href="<?php echo  U('ArticleCheap/lists?type=1')?>" <?php if ($type == 1) { echo "class='hover'"; }; ?> >便宜统计</a>
                        <a href="<?php echo  U('ArticleCheap/lists?type=2')?>" <?php if ($type == 2) { echo "class='hover'"; }; ?> >不便宜统计</a>
                    </dt>
		</dl>
	</div>
	<div class="goods mt10">
		<div class="goods mt10">
			<div class="login mt10" style="border: none;">
				<table id="product_band_lists" style="width:100%"></table>
			</div>
			<div class="clear"></div>
			<?php include $this->admin_tpl('copyright') ?>
		</div>
		<div class="clear"></div>
	</div>
</div>
<!--表格js-->
	<script type="text/javascript">
	var dom = $('#product_band_lists');
	var pageSize = <?php echo PAGE_SIZE?>;
	var dataurl = '<?php echo U('lists')?>';
	var editurl = '<?php echo U('ArticleCheapGoods/lists')?>';
	var delurl = '<?php echo U('update',array('opt'=>'goodscheap'))?>';
	var pos_id = '<?php echo $pos_id?>';
        var type = <?php echo $type?>;
	var type_arr = <?php echo json_encode($this->type_text)?>;
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
					iconCls:'icon-del'
				},'-'
			],
			frozenColumns:[[
				{field:'id',checkbox:true}
			]],
			queryParams:{
                            type:type,
				pos_id:pos_id
			},
			pagination:true,
			pageSize:pageSize,
			pageList: [pageSize,pageSize*2,pageSize*4],//可以设置每页记录条数的列表
			columns:[[
				{field:'goods_name',title:'商品名称',width:'30%',halign:'center',align:'center'},
				{field:'countnum',title:'点击次数',width:'20%',align:'center',sortable:true},
				{field:'createtime',title:'点击时间',width:'30%',halign:'center',align:'center',sortable:true,
					formatter:function(value,row,index){
  						return $.fn.datebox.defaults.timeformat(value);
					}
				},
                                {field:'cheapflag',title:'是否便宜',width:'10%',halign:'center',align:'center',sortable:true,
					formatter:function(value,row,index){
                                            if(value==1){
                                               return "便宜"; 
                                            }else{
                                                return "不便宜";
                                            }
					}
				},
				{field:'none',title:'编辑',width:'10%',halign:'center',align:'center',
					formatter:function(value,row,index){
						var edithtml = '<a href="'+editurl+'&goods_id='+row.goods_id+'&type='+row.cheapflag+'">详情</a>&nbsp;&nbsp;&nbsp;&nbsp;';
//						var delhtml = '<a onclick="dom.datagrid(\'clearSelections\').datagrid(\'clearChecked\').datagrid(\'checkRow\','+index+');$(\'#delrows\').trigger(\'click\')" href="#">删除</a>';
						return edithtml;
					}
				},
			]]
		});
		//删除操作
		$('#delrows').bind('click', function(){
			var ids = [];
			var rows = dom.datagrid('getSelections');
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