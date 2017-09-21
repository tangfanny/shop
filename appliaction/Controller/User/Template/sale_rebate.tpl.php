<?php include $this->admin_tpl("header"); ?>
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/haidaoblue/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/icon.css">
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/hd_default_config.js"></script>
<div class="content">
	<div class="site">
		 <a href="#">会员管理</a> > 会员等级
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
        <div style="line-height:30px;background:#ececec;font-size: 14px;font-weight: 700;margin: 5px 0px;">
            需要设定返利的比例，不可轻易更改，N代表订单金额 
        </div>
        <div style="line-height:30px;">
            总价的<input type="text" id="rebate" value="<?php echo $data["rebate"];?>" maxlength="3" style="width:30px;;font-size: 16px;font-weight: bold;height: 20px" />%,做为返利 
            <a href="javascript:updateRebate();" style="cursor:pointer;display:inline-block;height: 25px;line-height: 25px;color: #000;border: 1px solid #c7c7c7;text-align: center;padding: 0px 18px;">保存</a>
        </div>
        <div style="line-height:30px;background:#ececec;font-size: 14px;font-weight: 700;margin: 5px 0px;">
        设计返利模式层级关系
        </div>
        <div sty>
            <input id="RebateHierarchy" type="text" value="<?php echo $data["rebate_hierarchy"];?>" maxlength="2" style="width:20px;font-size: 16px;font-weight: bold;height: 20px"/>层 
            <a href="javascript:updateRebateHierarchy();" style="cursor:pointer;display:inline-block;height: 25px;line-height: 25px;color: #000;border: 1px solid #c7c7c7;text-align: center;padding: 0px 18px;">保存</a>
        </div>
	<div class="login mt10" style="border: none;">
            
		<table id="group_list" style="width:100%">
                    <tbody>

                        <tr class="datagrid-header-row">
                              <td field="name" class="">
                                    <div class="datagrid-cell datagrid-cell-c1-name" style="text-align: center;">
                                        <span></span>
                                        <span class="datagrid-sort-icon">&nbsp;</span>
                                    </div>
                                </td>
                             <?php foreach ($salerebate as $v=>$k):?> 
                                <td field="name" class="">
                                    <div class="datagrid-cell datagrid-cell-c1-name" style="text-align: center;">
                                        <span><?php echo $k["id"];?></span>
                                        <span class="datagrid-sort-icon">&nbsp;</span>
                                    </div>
                                </td>
                              <?php endforeach;?>  
                              <td field="name" class="">
                                        <div class="datagrid-cell datagrid-cell-c1-name" style="text-align: center;">
                                            <span>操作</span>
                                            <span class="datagrid-sort-icon">&nbsp;</span>
                                        </div>
                                </td>
                        </tr>
                        
                        <?php foreach ($salerebate as $v1=>$k1):?>
                        
                             <tr class="datagrid-header-row">
                              <td field="name" class="">
                                    <div class="datagrid-cell datagrid-cell-c1-name" style="text-align: center;">
                                        <span><?php echo ($k1["id"]);?></span>
                                        <span class="datagrid-sort-icon">&nbsp;</span>
                                    </div>
                                </td>
                             <?php for ($num=0 ;$num<($v1+1);$num++):?>
                                <td field="name" class="">
                                    <div class="datagrid-cell datagrid-cell-c1-name" style="text-align: center;">
                                        <span><input type="text" name="getrebate" value="<?php echo ($salerebate[$v1]["rebate_".($num+1)]);?>"  maxlength="3" style="width:30px;font-size: 16px;font-weight: bold;height: 20px" /></span>
                                        <span class="datagrid-sort-icon">&nbsp;</span>
                                    </div>
                                </td>
                              <?php endfor;?>

                                <?php for($num_1=0;$num_1<(count($salerebate)-($v1+1));$num_1++ ):?>
                                 <td field="name" class="">
                                    <div class="datagrid-cell datagrid-cell-c1-name" style="text-align: center;">
                                        <span>-</span>
                                        <span class="datagrid-sort-icon">&nbsp;</span>
                                    </div>
                                </td>
                                <?php endfor;?>

                                <td field="name" class="">
                                    <div class="datagrid-cell datagrid-cell-c1-name" style="text-align: center;">
                                        <span><a href="#" id="submit_<?php echo ($k1['id']);?>">保存</a></span>
                                        <span class="datagrid-sort-icon">&nbsp;</span>
                                    </div>
                                </td>
                                
                         </tr>
                        <?php endforeach;?>
                        
                    </tbody>
                </table>
	</div>
   
        
	<?php include $this->admin_tpl("copyright"); ?>
	<div class="clear"></div>
</div>
<script type="text/javascript">
    
    function updateRebate(){
        var rebate = $("#rebate").val();
        if(rebate>100){
            alert("返利比不能大于100");
            $("#rebate").val(100);
            return ;
        }else{
            $.post("<?php echo  U('SaleRebate/editrebate')?>",{rebate:rebate},function(data){
                    if(data==1){
                        alert("修改成功！");
                        window.location.reload();
                    }else{
                        alert("修改失败！");
                    }
            });
        }
    }
    
    function updateRebateHierarchy(){
        if(window.confirm('你确定要重新初始化数据么吗？')){
             if(window.confirm('你真的确定要重新初始化数据么吗？')){
                 if(window.confirm('请你再次确定要重新初始化数据么吗？')){
                        var RebateHierarchy = $("#RebateHierarchy").val();
                        if(RebateHierarchy>0 && RebateHierarchy<11){
                            $.post("<?php echo  U('SaleRebate/editrebatehierarchy')?>",{RebateHierarchy:RebateHierarchy},function(data){
                                    if(data==1){
                                        alert("修改成功！");
                                        window.location.reload();
                                    }else{
                                        alert("修改失败！");
                                    }
                            });
                        }else{
                            alert("请输入正确层级关系1~10");
                            return ;
                        }
                 }
             }
        }else{
            return ;
        }
     
    }
</script>
<?php foreach ($salerebate as $v1=>$k1):?>
<script>
    $("#submit_<?php echo ($k1['id']);?>").click(function(){ 
    var p=getRow($(this),4);
    var arr=p.find("input");
    var jsondata = getMapData(arr);
    $.ajax({
        url:"<?php echo U('SaleRebate/EditRebateVal')?>",
        type:"POST",
        data:jsondata,
        success: function(data) {
            if (data==1) {alert('修改成功！')}else{alert('修改失败！')};
        }
    });
});
    //获取上b(Int)级的对象
    function getRow(a,b){
          var p=a;
        for(var i=0;i<b;i++){
             p=p.parent();
        }
        return p;
    }
    function getData(arr){
        var str="{"
        for (var i = arr.length - 1; i >= 0; i--) {
            str+="rebate_"+i+":"+arr[i].value
            if(i!=0){
            str+=",";
           }
        };
        str+="}"
        return str;
    }
     function getMapData(arr){
        var obj={};
        for (var i = arr.length - 1; i >= 0; i--) {
            obj["rebate_"+(i+1)]=arr[i].value;
           }
        return obj;
    }
</script>
<?php endforeach;?>