<?php include $this->admin_tpl("header"); ?>
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/haidaoblue/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/icon.css">
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/locale/easyui-lang-zh_CN.js"></script>
<style type="text/css">
	.menu {background:#FFFFFF;}
	#batch .m-btn-small {margin-left: 0;}
</style>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/hd_default_config.js"></script>
	<!-- 内容区 -->
	<div class="content">
		<div class="site">
			 <a href="#">专题活动</a> > 活动列表
		</div>
		<span class="line_white"></span>
	<div class="goods mt10">
		<div class="guanli">
			<input id="keyword" class="easyui-textbox" name="keyword" style="width:210px;height: 26px;" prompt="活动名称">
			<a id="search" href="#" class="easyui-linkbutton" style="height: 26px;padding-right: 10px;">查询</a>
		</div>	
	<dl class="mt10">
		<dt><p>
			<a href="<?php echo U('lists');?>" <?php if($_GET['label'] == ''){?>class="hover"<?php } ?> >全部活动</a>
			<a href="<?php echo U('lists?label=1');?>" <?php if($_GET['label'] == '1'){?>class="hover"<?php } ?> >已上线活动</a>
			<a href="<?php echo U('lists?label=0');?>" <?php if($_GET['label'] == '0'){?>class="hover"<?php } ?> >未上线活动</a>
			<a href="<?php echo U('lists?label=2');?>" <?php if($_GET['label'] == '2'){?>class="hover"<?php } ?> >已下线活动</a>
		</dt>
		<dd>
			<div class="login mt10" style="border: none;">
				<table id="order_list_grid" style="width:100%"></table> 
			</div>
			<div class="clear"></div>
		</dd>
	</dl>
		 <?php include $this->admin_tpl('copyright') ?>
	</div>
<!-- /内容区 -->
<!--表格js-->
	<script type="text/javascript">
	var dom = $('#order_list_grid');
	var label = '<?php echo $label?>';
	var pageSize = <?php echo PAGE_SIZE?>;
	var dataurl = '<?php echo U('lists');?>';
	var addurl ='<?php echo U('add');?>';
	var importurl = '<?php echo U('import')?>';
    var viewurlnews = '<?php echo U('index');?>';
	var delurl = '<?php echo U('ajax_del');?>';
	var editurl = '<?php echo U('edit');?>';
	var statusurl = '<?php echo U('ajax_status');?>';
	var status_exturl = '<?php echo U('ajax_status_ext');?>';
	var recoverurl = '<?php echo U('ajax_recover');?>';
	var deltrueurl = '<?php echo U('edit');?>';
	var keyword = '<?php echo $keyword?>';
	var sorturl = '<?php echo U('ajax_sort')?>';
	var build = '<?php echo U('activityBuild/index');?>';
	try{
		cat_arr.unshift({"value":"0","text":"请选择"});
		brand_arr.unshift({"id":"0","name":"请选择"});
	}catch(error){
		cat_arr=[{"value":"0","text":"请选择"}];
		brand_arr=[{"id":"0","name":"请选择"}];
	}
	$(function(){	
		dom.datagrid({   
			url:dataurl, 
			striped:true, //交替换行
			width:'100%',
			checkOnSelect:true,
			fitColumns:true, //真正的自动展开/收缩列的大小，以适应网格的宽度，防止水平滚动。
			toolbar:[],
			frozenColumns:[[
			  {field:'id',checkbox:true}
			]],
			queryParams:{
				label:label
			},
			pagination:true,
			pageSize:pageSize,
			pageList:[pageSize,pageSize*2,pageSize*4],//可以设置每页记录条数的列表 
			columns:[[
				{field:'name',title:'活动名称',width:'11%',halign:'center',align:'center',sortable:true},
				{field:'url',title:'活动链接',width:'25%',halign:'center',align:'center'},
				{field:'t_name',title:'引用模板',width:'6%',halign:'center',align:'center'},
				{field:'addtime',title:'创建日期',width:'10%',halign:'center',align:'center',
					formatter:function(value,row,index){
						return $.fn.datebox.defaults.timeformat(value);
					}					
				},
				{field:'status',title:'上线状态',width:'7%',halign:'center',align:'center',
					formatter:function(value,row,index){
						var status_ext_text = '';
						if(row.status.indexOf('1') >= 0){
							status_ext_text +=' [已上线] '
						}
						else if(row.status.indexOf('0') >=0){
							status_ext_text +=' [未上线] '
						}else if(row.status.indexOf('2') >= 0){
							status_ext_text += ' [已下线]'
						}
						return status_ext_text;
					}
				},
				{field:'start_time',title:'上线日期',width:'10%',halign:'center',align:'center',
					formatter:function(value,row,index){
						return $.fn.datebox.defaults.timeformat(value);
					}
				},
				{field:'end_time',title:'下线日期',width:'10%',halign:'center',align:'center',
					formatter:function(value,row,index){
						return $.fn.datebox.defaults.timeformat(value);
					}
				},                
				{field:'pv',title:'浏览次数',width:'10%',align:'center',sortable:true},

				{field:'userID',title:'操作',width:'11%',halign:'center',align:'center',
					formatter:function(value,row,index){
						sptext = '&nbsp;&nbsp;&nbsp;&nbsp;';
						buildhtml = '<a href="'+build+'&id='+row.id+'">生成</a>'
						viewhtml = '<a href="'+viewurlnews+'&id='+row.id+'" target="_blank">查看</a>';
						edithtml = '<a href="'+editurl+'&id='+row.id+'">编辑</a>';
						delhtml = '<a onclick=batch('+row.id+')>删除</a>';
						if (row.status == -1){
							return buildhtml+sptext+viewhtml+sptext+recoverhtml+sptext+deltruehtml;
						}else{
							return buildhtml+sptext+viewhtml+sptext+edithtml+sptext+delhtml;
						}
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
        //修改排序
		function ChangeSort(id,val){
			$.messager.progress();
			$.getJSON(sorturl, {"id": id,"val": val}, function(data) {
				$.messager.progress('close');
			})
		}
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
						ajax_ids(ids,delurl);
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

		function ajax_ids(ids,url){
			$.getJSON(url,  
			{"id[]":ids}, 
			function(data){ 
				if(1 == data.status){// 删除成功，则需要在树中删除节点  
					// 检修任务grid 执行load  
                                        
					dom.datagrid("reload");  //重新加载  
				}else{	
					$.messager.alert('错误',data.info);
				}  
			})  
		}
		function batch(row){
            $.messager.confirm('确认','您确认想要删除活动吗？',function(r){
				if(r){
					window.location = delurl+'&id='+row;
				}
			})
		}		
</script>