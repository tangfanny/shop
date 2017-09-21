<?php include $this->admin_tpl("header"); ?>
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/haidaoblue/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/icon.css">
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/hd_default_config.js"></script>
<div class="content">
	<div class="site">
		 <a href="#">会员管理</a> > 会员列表 > 会员发票
	</div>
	<span class="line_white"></span>
	<div class="goods mt10">
		<div class="login mt10" style="border:none">
			<table id="member_address_list" style="width:100%"></table>
		 </div>
		<?php include $this->admin_tpl("copyright"); ?>
		<div class="clear"></div>
	</div>
</div>
<script type="text/javascript">
	var dom = $('#member_address_list');
	var pageSize = <?php echo PAGE_SIZE?>;
	var dataurl = '<?php echo U('lists')?>';
	var listurl = '<?php echo U('member/lists')?>';
	var user_id = '<?php echo $user_id?>';
    $(function(){
		dom.datagrid({
			url:dataurl,
			striped:true,
			checkOnSelect:true,
			fitColumns:true,
			toolbar:[{
					id:'backlists',
					text:'返回',
					iconCls:'icon-undo',
				},'-'
			],
			frozenColumns:[[
			{field:'id',checkbox:true}
			]],
			pagination:true,
			pageSize:pageSize,
			pageList: [pageSize,pageSize*2,pageSize*4],//可以设置每页记录条数的列表
			queryParams:{"user_id":user_id},
			columns:[[
				{field:'title',title:'单位名称',width:'15%',align:'center',fixed:true},
				{field:'taxpayer',title:'纳税人识别码',width:'15%',align:'center',fixed:true},
				{field:'reg_address',title:'注册地址',width:'15%',align:'center',fixed:true},
				{field:'reg_tel',title:'注册电话',width:'15%',align:'center',fixed:true},
				{field:'bank',title:'开户银行',width:'15%',align:'center',fixed:true},
                                {field:'account',title:'银行账户',width:'15%',align:'center',fixed:true},
                                {field:'invoice_type',title:'发票类型',width:'10%',align:'center',fixed:true,
                                    formatter:function(value,row,index){
                                        if(value==1){
                                            return "普通发票";
                                        }else{
                                            return "增值税发票";
                                        }
                                    }},
			]]
		});
		//返回
		$('#backlists').bind('click',function(){
			window.location.href=listurl;
		})
	})
</script>