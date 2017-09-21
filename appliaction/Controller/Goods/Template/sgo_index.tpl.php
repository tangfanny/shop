<?php include $this->admin_tpl("header"); ?>
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/haidaoblue/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/icon.css">
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/hd_default_config.js"></script>
<div class="content">
    <span style="margin-right: 10px;">会员搜索 </span> 
    <input id="keyword" class="easyui-textbox" name="keyword" style="width: 210px; height: 26px;" prompt="输入销售名称/手机/EMAIL">
    <a id="search" href="#" class="easyui-linkbutton" style="height: 26px; padding-right: 10px;">查询</a>
    <div class="login mt10" style="border: none; width:100%">
        <table id="group_list" style="width:100%"></table>
        <div class="clear"></div>
    </div>
    <?php include $this->admin_tpl("copyright"); ?>
    <div class="clear"></div>
</div>
<script type="text/javascript">
    Date.prototype.format = function(fmt) {
      var o = {   
        "M+" : this.getMonth()+1,                 //月份   
        "d+" : this.getDate(),                    //日   
        "h+" : this.getHours(),                   //小时   
        "m+" : this.getMinutes(),                 //分   
        "s+" : this.getSeconds(),                 //秒   
        "q+" : Math.floor((this.getMonth()+3)/3), //季度   
        "S"  : this.getMilliseconds()             //毫秒   
      };   
      if(/(y+)/.test(fmt))
        fmt=fmt.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));
      for(var k in o)   
        if(new RegExp("("+ k +")").test(fmt))   
      fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));
      return fmt;   
    }
    
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
            queryParams: {
                goods_id: '<?php echo I('get.goods_id', 0);?>'
            },
            columns:[[
                {field:'order_sn',title:'订单号',halign:'center',align:'center',width:'20%'},
                {field:'create_time',title:'下单时间',width:'15%',align:'center',
                    formatter:function(value,row,index) {
                        return new Date(value*1000).format("yyyy-MM-dd hh:mm:ss");
                    }
                },
                {field:'user_name',title:'需求人',width:'10%',align:'center'},
                {field:'real_amount',title:'订单金额',width:'10%',align:'center'},
                {field:'pay_code',title:'支付方式',width:'10%',align:'center'},
                {field:'give_point',title:'积分',width:'5%',align:'center'},
                {field:'coupons',title:'优惠卷',width:'5%',align:'center'},
                {field:'source',title:'订单类型',width:'10%',align:'center',
                    formatter:function(value,row,index) {
                        return '<img src="<?php echo IMG_PATH; ?>admin/ico_d_'+value+'.png" alt="" />'
                    }
                },
                {field:'order_status',title:'订单状态',width:'10%',align:'center',
                    formatter:function(value,row,index) {
                        var o_status = ['未确认', '已确认', '已完成', '已作废', '已取消', '客户已确认'];
                        return o_status[value];
                    }
                },
                {field:'none',title:'操作',width:'5%',align:'center',halign:'center',
                    formatter:function(value,row,index){
                        var op = '<a href="./index.php?m=goods&c=serviceGoodsOrder&a=info&id='+row.id+'">查看</a>';
                        return op;
                    }
                }
            ]],
            onLoadSuccess:function(data){}
        });
        //添加会员
//      $('#addrow').bind('click', function(){
//          window.location.href=addurl;
//      })
        //删除操作
//      $('#delrows').bind('click', function(){
//          var ids = [];
//          var rows = dom.datagrid('getChecked');
//          for(var i=0; i<rows.length; i++){
//              ids.push(rows[i].id);
//          }
//          if (ids.length > 0){
//              $.messager.confirm('确认','您确认想要删除记录吗？',function(r){
//                  if (r){
//                      $.getJSON(delurl,
//                      {"id[]":ids},
//                      function(data){
//                          if(1 == data.status){// 删除成功，则需要在树中删除节点
//                              // 检修任务grid 执行load
//                              dom.datagrid("reload");//重新加载
//                          }else{
//                              $.messager.alert('警告',data.info);
//                          }
//                      })
//                  }else{
//                      dom.datagrid('clearSelections').datagrid('clearChecked');
//                  }
//              });
//          }else{
//              $.messager.alert('警告','请选择要删除的记录');
//              return false;
//          }
//      });
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