<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="chrome=1,IE=edge" />
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="x-ua-compatible"/>
<title>后台管理</title>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>admin/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>font-awesome.css" />
<!--[if IE 6]>
<script type="text/javascript" src="<?php echo JS_PATH ?>DD_belatedPNG.js" ></script>
<script type="text/javascript">
DD_belatedPNG.fix('*');
</script>
<![endif]-->
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery-1.7.2.min.js"></script>
<?php if(isset($validform)) { ?>
<script type="text/javascript" src="<?php echo JS_PATH;?>Validform_v5.3.2_min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>Validform_Datatype.js"></script>
<?php } ?>
<?php if(isset($dialog)) { ?>
<script type="text/javascript" src="<?php echo JS_PATH;?>artDialog/artDialog.js?skin=default"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>artDialog/plugins/iframeTools.js" ></script>
<script type="text/javascript">
(function(config) {
    config['lock'] = true;
    config['fixed'] = true;
})(art.dialog.defaults);
</script>
<?php } ?>
<script type="text/javascript" src="<?php echo JS_PATH;?>common.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/haidaoblue/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/icon.css">
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/hd_default_config.js"></script>
</head>
<body>
<div class="content">
    <span style="margin-right: 10px;">会员搜索 </span> 
    <input id="keyword" class="easyui-textbox" name="keyword" style="width: 210px; height: 26px;" prompt="输入名称/手机">
    <a id="search" href="#" class="easyui-linkbutton" style="height: 26px; padding-right: 10px;">查询</a>
    <div class="login mt10" style="border: none; width:100%">
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
	$(function(){
		dom.datagrid({
			url:dataurl,
			striped:true,
			width:'100%',
			fitColumns:true,
			checkOnSelect:true,
			pagination:true,
			pageSize:pageSize,
			pageList: [pageSize,pageSize*2,pageSize*4],//可以设置每页记录条数的列表
			columns:[[
				{field:'mobile',title:'手机号',halign:'center',align:'center',width:'10%'},
				{field:'nikename',title:'昵称',width:'10%',align:'center'},
				{field:'name',title:'姓名',width:'10%',align:'center'},
				{field:'user_type',title:'用户角色',width:'10%',align:'center',
					formatter:function(value,row,index){
                        return '安全顾问';
				    }
                },
				{field:'no_id',title:'身份证号码',width:'10%',align:'center'},
				{field:'createtime',title:'创建时间',width:'15%',align:'center'},
				{field:'authtime',title:'审核时间',width:'15%',align:'center',
					formatter:function(value,row,index){
	                    if(value != null){
	                        return value;
	                    }else{
	                        return "-";
	                    }
				    }
                },
                {field:'auth_status', title:'认证状态', width:'10%', align:'center',
                    formatter:function(value, row, index) {
                        var str = "";
                        if(value == 0) {
                            str = "审核中";
                        } else if(value == 1) {
                            str = "通过";
                        } else if(value == 2) {
                            str = "驳回";
                        }
                        return str;
                    }
                },
				{field:'none',title:'查看',width:'10%',align:'center',halign:'center',
					formatter:function(value,row,index){
						return '<a href="./index.php?m=user&c=safetyAdvisor&a=info&id='+row.id+'">查看</a>';
					}
				}
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
</body>
</html>