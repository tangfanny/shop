<?php include $this->admin_tpl('header'); ?>
<script type="text/javascript" src="<?php echo JS_PATH?>admin/order_action.js"></script>
<script type="text/javascript">
    var order = <?php echo json_encode($info); ?>;
    var _post = '<?php echo U('goods/service_goods_order/update') ?>';
    $(document).ready(function(){
        order_action.init();
    });
</script>
<style>
    #Validform_msg{display: none}
    label{min-width: 90px;display:inline-table}
    .list_order span{padding: 0 5px;}
    .list_order span a{padding: 0 0px;}
</style>
<div class="content">
    <div class="site">
        <a href="#">订单管理</a> > 订单详情
    </div>
    <span class="line_white"></span>
    <div class="list_order">
        <div class="handle mt10">
            <span class="fr"><a href="javascript:" onclick="order_action.view_log()">查看订单操作日志</a></span>
            <strong>订单操作：</strong>
            <!--
            确认订单：[先发货后支付 || [先支付后发货 && 已支付]] && 未确认
            -->
            <a href="javascript:;" <?php if(($info['pay_type'] == 1 || ($info['pay_type'] == 0 && $info['pay_status'] == 1)) && $info['order_status'] == 0): ?> onclick="order_action.order(1);"<?php else: ?> class="disabled"<?php endif; ?>>确认订单</a>
            <!--
            确认完成：[先发货后支付 || 先支付后发货 && 已支付] &&  已确认 &&  已发货
            -->
            <a href="javascript:;"<?php if (($info['pay_type'] == 1 || ($info['pay_type'] == 0 && $info['pay_status'] == 1)) &&($info['order_status'] == 1 || $info['order_status'] == 5 )): ?> onclick="order_action.order(2)"<?php else: ?> class="disabled"<?php endif ?>>确认完成</a>
            <!-- 
            改派售前：
             -->
            <a href="javascript:;"<?php if (($info['pay_type'] == 1 || ($info['pay_type'] == 0 && $info['pay_status'] == 1)) &&($info['order_status'] == 1 || $info['order_status'] == 5 )): ?> onclick="order_action.order(2)"<?php else: ?> class="disabled"<?php endif ?>>改派售前</a>
            <!--
            取消：[[未确认 && 先发货后支付] || [先支付后发货 && !已付款]] && 未发货 && [未确认 || 已确认]
            -->
            <a href="javascript:;"<?php if ((($info['order_status'] == 0 && $info['pay_type'] == 1) || ($info['pay_type'] == 0 && $info['pay_status'] != 1)) && $info['delivery_status'] == 0 && $info['order_status'] < 2) : ?> onclick="order_action.order(4);"<?php else: ?> class="disabled"<?php endif ?>>取消订单</a>
        </div>
        <div class="details clearfix mt10">
            <div class="sub mt15 fr">
                <a id="print_kd" href="javascript:;" data-id="<?php echo $info['id']; ?>" style="">打印快递单</a>
                <?php if($info[front_id] > 0): ?>
                    <a href="<?php echo U('AdminOrder/edit?order_sn='.$info['front_id']['order_sn']);?>">上一单</a>
                <?php else: ?>
                    <a>没有了</a>
                <?php endif; ?>
                <?php if($info[after_id] > 0): ?>
                    <a href="<?php echo U('AdminOrder/edit?order_sn='.$info['after_id']['order_sn']);?>">下一单</a>
                <?php else: ?>
                    <a>没有了</a>
                <?php endif; ?>
                <a href="<?php echo U('Goods/ServiceGoodsOrder/index');?>">返回订单列表</a>
            </div>
            <strong>订单<br />详情</strong>
            <span>订单号：<?php echo ($info['order_sn']); ?></span>
            <span>订单状态：
                <b>
                    <?php ?>
                    <?php echo $this->_config['c_order_status'][$info['order_status']];?>
                    <?php echo $this->_config['c_pay_status'][$info['pay_status']];?>
                </b>
            </span>
            <span>订单类型：<img src="<?php echo IMG_PATH; ?>admin/ico_d_<?php echo $info['source'];?>.png" alt="" /></span>
        </div>

        <div class="detaxx">
            <table>
                <tr>
                    <th>应付订单金额</th>
                    <th>&nbsp;</th>
                    <th>商品总额</th>
                    <th>&nbsp;</th>
                    <th>优惠券减免</th>
                    <th>&nbsp;</th>
                    <th>确认收款</th>
                </tr>
                <tr>
                    <td><font><?php echo ($info['real_amount']);?></font></td>
                    <td><b>=</b></td>
                    <td><b><?php echo ($info['payable_amount']);?></b></td>
                    <td><b>-</b></td>
                    <td><b><?php echo ($info['coupons']); ?></b></td>
                    <td><b></b></td>
                    <td>
                        <?php if($info["pay_status"]==1):?>
                            <?php if($r["order_status"]==0):?>
                                <a style="color:#2d689f" href="javascript:void(0)" onclick="submitmoney('<?php echo ($info['id']);?>','<?php echo ($info['order_sn']); ?>')">
                                    确认
                                </a>
                            <?php else:?>
                                已确认
                            <?php endif;?>
                        <?php else :?>
                            未付款
                        <?php endif;?>
                    </td>
                </tr>
            </table>
        </div>

        <dl class="blue_table mt10">
            <dt>
                <strong>需求人信息</strong>
            </dt>
            <dd>
                <table>
                    <tr>
                        <th>需求人</th>
                        <th>手机号</th>
                    </tr>
                    <tr>
                        <td><?php echo ($info['customer']['nikename']); ?></td>
                        <td><?php echo ($info['customer']['mobile']); ?></td>
                    </tr>
                </table>
            </dd>
        </dl>
        <dl class="blue_table mt10">
            <dt>
                <strong>支付配送方式</strong>
            </dt>
            <dd>
                <table>
                    <tr>
                        <td>
                            <p>支付方式：<?php if ($info['pay_type'] == 0): ?>在线支付<?php else: ?>货到付款<?php endif ?>
                                <?php if ($payment[$info['pay_code']]['pay_name']): ?>
                                    [<?php echo $payment[$info['pay_code']]['pay_name']; ?>]
                                <?php endif ?>
                            </p></td>
                    </tr>
                    <tr>
                        <td><p>配送方式：客户自取
                            </p>
                        </td>
                    </tr>
                </table>
            </dd>
        </dl>
        <dl class="blue_table mt10">
            <dt>
                <strong>商品信息</strong>
            </dt>
            <dd>
                <table>
                    <tr>
                        <th>商品名称</th>
                        <th>商品总价</th>
                        <th>购买天数</th>
                    </tr>
                    <tr>
                        <td><?php echo ($info['title']); ?></td>
                        <td><?php echo ($info['payable_amount']); ?></td>
                        <td><?php echo ($info['service_days']); ?></td>
                    </tr>
                </table>
            </dd>
        </dl>

        <?php include $this->admin_tpl('copyright') ?>
    </div>
</div>
<!--编辑费用信息弹窗-->
<div id="editMoneybox" class="editMoneybox">
    <ul>
        <li class="w85">应付订单金额</li>
        <li class="w85"></li>
        <li class="w85">折扣率(%)</li>
        <li class="w85"></li>
        <li class="w155">实付订单金额</li>
    </ul>
    <ul>
        <li class="w85"><span class="red3"><?php echo $info['real_amount'];?></span></li>
        <li class="w85"> X </li>
        <li><input type="text" name="discount"/></li>
        <li class="w85"> = </li>
        <li><input type="text" name="real_amount"/></li>
    </ul>
    <p>小提示：您可以直接调整订单的最终付款价格，输入实付订单金额货折扣率均可</p>
</div>
<!--确认发货弹窗-->
<div id="editDeliverybox" class="editDeliverybox">
    <ul>
        <li>
            <select name="delivery">
                <?php foreach($deliverys as $dk=>$dv):?>
                    <?php $_dsel = ($dv['id'] == $info['delivery_id']) ? 'selected' : '' ?>
                    <option value="<?php echo $dv['id']?>" <?php echo $_dsel;?>><?php echo $dv['name']?></option>
                <?php endforeach;?>
            </select>
        </li>
        <li><input name="delivery_sn" placeholder='请输入快递单号' style="width:16em;padding:6px 4px"></li>
    </ul>
    <p>小提示：您可以根据实际情况调整配送方式</p>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>Editor/themes/default/default.css">
<script type="text/javascript" src="<?php echo JS_PATH; ?>Editor/kindeditor-min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>Editor/lang/zh_CN.js"></script>
<script type="text/javascript">

    function subgo(orderid,type,order_sn){
        $.post("<?php echo (U('admin_order/ajaxpact'));?>",{id:orderid,type:type,order_sn:order_sn},function(result){
            //alert(result);
            if(result!=0){
                alert("确认成功！");
                window.location.reload();//刷新当前页面.
            }else{
                alert("确认失败！");
            }
        });
    }

    function submitmoney(id,order_sn){

        var r=confirm("您确认客户已经付款了吗？");
        if (r==true)
        {
            $.post("<?php echo (U('admin_order/ajaxsubimtmoney'));?>",{id:id,order_sn:order_sn},function(result){
                if(result==1){
                    alert("确认成功！");
                    window.location.reload();//刷新当前页面.
                }else{
                    alert("确认失败！");
                }
            });
        }
    }

    var real_amount = <?php echo $info['real_amount'];?>;
    $("#editMoney").click(function() {
        art.dialog({
            padding: '0px ',
            id: 'editMoneybox',
            background: '#ddd',
            opacity: 0.3,
            title: '编辑费用信息',
            content: document.getElementById('editMoneybox'),
            ok:function() {
                var real_amount = $("input[name=real_amount]").val();
                $.post('?m=goods&c=admin_order&a=editPrice', {
                    order_sn: '<?php echo $info['order_sn'];?>',
                    oldPrice:'<?php echo $info['real_amount'];?>',
                    real_amount:real_amount
                }, function(ret) {
                    if(ret.status == 1) {
                        window.location.reload();
                        return true;
                    } else {
                        alert(ret.info);
                        return false;
                    }
                }, 'JSON');
                return false;
            },
            cancel:true
        });
    });

    $(document).ready(function(){
        $('input[name=discount]').on('keypress keyup blur', function(){
            var discount = $(this).val();
            var money = (real_amount * discount / 100).toFixed(2);
            $("input[name=real_amount]").attr('value', money);
        })
        $('input[name=real_amount]').on('keypress keyup blur', function(){
            var money = $(this).val();
            var discount = ((money / real_amount) * 100).toFixed(2);
            $("input[name=discount]").attr('value', discount);
        })
    });
    $('#print_kd').bind('click',function(){
        var order_id = $(this).attr('data-id');
        if (order_id < 1) alert('您的订单号有误！');
        location.href = "<?php echo U('admin_order/print_kd') ?>" + '&order_id=' + order_id;
    })
    function ajaxstaging(id){
        //alert(id);
        $.post("<?php echo (U('admin_order/ajaxstaging'));?>",{id:id},function(result){
            if(result!=0){
                alert("确认成功！");
                window.location.reload();//刷新当前页面.
            }else{
                alert("确认失败！");
            }
        });
    }

    KindEditor.ready(function(K) {
        //K.create('#content');
        editor = K.editor({
            uploadJson : '<?php echo U("Admin/Editor/upload?SSID=",'','');?>'+'<?php echo C("SSID");?>',
            fileManagerJson : '<?php echo U("Admin/Editor/file_manage?parentdir=pact/",'','');?>',
            extraFileUploadParams: {
                PHPSESSID : '<?php echo session_id() ?>',
                parentdir : 'pact/'
            },
            allowFileManager: true
        });
        //给按钮添加click事件
        $('#pact').live('click', function() {
            var self = $(this);
            editor.loadPlugin('image', function() {
                //图片弹窗的基本参数配置
                editor.plugin.imageDialog({
                    imageUrl: self.prev('input').val(), //如果图片路径框内有内容直接赋值于弹出框的图片地址文本框
                    //点击弹窗内”确定“按钮所执行的逻辑
                    clickFn: function(url, title, width, height, border, align) {
//								self.prev("input").val(url);
//                                                              alert(url);
//								self.next("span").html("<img src=" + url + " height=43>");
                        $("#pactid").val(url);
                        var pacturl = $("#pactid").val();
                        var orderid = '<?php echo $info['id']?>';
                        var order_sn='<?php echo ($info['order_sn']); ?>';
                        $.post("<?php echo (U('admin_order/ajaxpacturl'));?>",{pacturl:pacturl,id:orderid,order_sn:order_sn},function(result){
                            if(result!=0){
                                alert("上传成功！");
                            }else{
                                alert("上传失败！");
                            }
                        });
                        editor.hideDialog(); //隐藏弹窗
                        window.location.reload();//刷新当前页面.
                    }
                });
            });
        });
    });

</script>
</body>
</html>