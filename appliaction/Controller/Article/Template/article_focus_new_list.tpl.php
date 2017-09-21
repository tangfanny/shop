<?php include $this -> admin_tpl('header'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/haidaoblue/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/icon.css">
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/hd_default_config.js"></script>
<div class="content">
	<div class="site">
		 <a href="#">内容管理</a> > 文章列表
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
	var editurl = '<?php echo U('update',array('opt'=>'edit'))?>';
	var delurl = '<?php echo U('update',array('opt'=>'del'))?>';
	var topurl = '<?php echo U('update',array('opt'=>'ajax_top'))?>';
	var statusurl = '<?php echo U('update',array('opt'=>'ajax_status'))?>';
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
				},'-',
				{
					id:'addrow',
					text:'添加',
					iconCls:'icon-add',
				},'-'
			],
			frozenColumns:[[
				{field:'id',checkbox:true}
			]],
			pagination:true,
			pageSize:pageSize,
			pageList: [pageSize,pageSize*2,pageSize*4],//可以设置每页记录条数的列表
			columns:[[
				{field:'pic',title:'图片地址',width:'30%',halign:'center',align:'left',
                                    formatter:function(value,row,index){
						sptext = '&nbsp;&nbsp;&nbsp;&nbsp;';
						picaddress = value;
						viewhtml = '<a href="'+value+'" target="_blank" target="_blank" title="'+value+'">查看</a>';
						return picaddress+sptext+viewhtml;
					}
                                },
				{field:'path',title:'分享图标',width:'25%',halign:'center',align:'center',
                                    formatter:function(value,row,index){
						sptext = '&nbsp;&nbsp;&nbsp;&nbsp;';
						picaddress = value;
                                                if(value==""){
                                                    viewhtml="未上传分享图标";
                                                }else{
                                                    viewhtml = '<a href="'+value+'" target="_blank" target="_blank" >查看</a>';
                                                }
						return picaddress+sptext+viewhtml;
					}
                                },
				{field:'url',title:'连接地址',width:'20%',align:'center',sortable:true},
                                {field:'text',title:'图片标题',width:'10%',align:'center',sortable:true},
				{field:'status',title:'是否显示',width:'5%',halign:'center',align:'center',sortable:true,
					formatter:function(value,row,index){
						if (value == 1){
							statushtml = '<span url="'+statusurl+'&id='+row.id+'" class="ajax-get ajax_on" ></span>';
						}else{
							statushtml = '<span url="'+statusurl+'&id='+row.id+'" class="ajax-get ajax_off" ></span>';
						}
						return statushtml;
					}
				},
				{field:'none',title:'操作',width:'10%',halign:'center',align:'center',
					formatter:function(value,row,index){
						var edithtml = '<a href="'+editurl+'&id='+row.id+'">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;';
						var delhtml = '<a onclick="dom.datagrid(\'clearSelections\').datagrid(\'clearChecked\').datagrid(\'checkRow\','+index+');$(\'#delrows\').trigger(\'click\')" href="#">删除</a>';
						return edithtml + delhtml;
					}
				},
			]]
		});
		//添加
		$('#addrow').bind('click', function(){
			window.location.href=addurl;
		})
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
