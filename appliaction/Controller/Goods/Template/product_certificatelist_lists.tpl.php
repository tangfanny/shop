<?php include $this->admin_tpl("header"); ?>
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/haidaoblue/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/icon.css">
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/hd_default_config.js"></script>
<style type="text/css">
	.textbox .textbox-text{text-align: center;}
</style>
<div class="content">
	<div class="site">
		 <a href="#">商品管理</a> > 
		 <a href="<?php echo U('lists')?>">资质证书 </a>
		 >
		 <a href="javascript:location.replace(location.href);">资质证书详情</a>
	</div>
	<span class="line_white"></span>
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
	var lists = '<?php echo U('lists')?>';
	var pageSize = <?php echo PAGE_SIZE?>;
	var dataurl = '<?php echo U('listsc')?>';
	var addurl = '<?php echo U('add')?>';
	var editurl = '<?php echo U('edit')?>';
	var delurl = '<?php echo U('ajax_del2')?>';
	var statusurl = '<?php echo U('ajax_status')?>';
	var sorturl = '<?php echo U('ajax_sort')?>';
    var id='<?php echo $id?>';
	$(function(){	
		dom.datagrid({   
			url:dataurl, 
			striped:true,
			width:'100%',
			fitColumns:true,
			checkOnSelect:true,
			toolbar:[{
					id:'delrows',
					text:'删除',
					iconCls:'icon-del',
				},'-',
				{
					id:'addrow',
					text:'添加',
					iconCls:'icon-add',
				},'-',
				{
					id:'backlists',
					text:'返回',
					iconCls:'icon-undo',
				},'-'
			],
			frozenColumns:[[
				{field:'id',checkbox:true}
			]],
            queryParams:{
                id:id
			},
			pagination:true,
			pageSize:pageSize,
			pageList: [pageSize,pageSize*2,pageSize*4],//可以设置每页记录条数的列表 
			columns:[[
				{field:'certificate_name',title:'证书名称',width:'30%',halign:'center',align:'center'},
				{field:'certificate_type',title:'类型',width:'15%',halign:'center',align:'center',sortable:true,
					formatter:function(value,row,index){
						switch (row.certificate_type) {
							case '1':
								statushtml = "公司";
								break;
							case '2':
								statushtml = "产品";
								break;
							default:
								statushtml = "其他";
								break;
						}
						return statushtml;
					}
				},
				{field:'start_time',title:'开始时间 ~ 结束时间',width:'25%',align:'center',sortable:true,
					formatter:function(value,row,index){
  						return $.fn.datebox.defaults.timeformat(row.start_time)+' ~ '+$.fn.datebox.defaults.timeformat(row.end_time);
					}
				},
				{field:'certificate_img',title:'证书图片',width:'10%',align:'center',
					formatter:function(value,row,index){
                            var img_url="";
                            if(value!=""){
                                img_url='<a href='+'<?php echo IMG_URL;?>'+value+' target="_blank" title='+value+'>查 看</a>';
                            }
						return img_url;
					}
				},
				{field:'none',title:'操作',width:'20%',halign:'center',align:'center',
					formatter:function(value,row,index){
						var edithtml = '<a href="'+editurl+'&id='+row.id+'">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;';
						var delhtml = '<a onclick="dom.datagrid(\'clearSelections\').datagrid(\'clearChecked\').datagrid(\'checkRow\','+index+');$(\'#delrows\').trigger(\'click\')" href="#">删除</a>';
						return edithtml + delhtml;
					}
				},
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
		//添加
		$('#addrow').bind('click', function(){
			window.location.href=addurl;
		})
		//返回
		$('#backlists').bind('click',function(){
			window.location.href=lists;
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
