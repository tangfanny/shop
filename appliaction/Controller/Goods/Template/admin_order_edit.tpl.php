<?php include $this->admin_tpl('header'); ?>
<script type="text/javascript" src="<?php echo JS_PATH?>admin/order_action.js"></script>
<script type="text/javascript">
    var order = <?php echo json_encode($info); ?>;
    var _post = '<?php echo U('update') ?>';
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
            确认付款：[先发货后支付 && 已发货 && 未支付] || [先支付后发货 && 待支付 && 待发货]
            -->
            <!--                <a href="javascript:;"<?php if ((($info['pay_type'] == 1 && $info['delivery_status'] == 1 && $info['pay_status'] == 0) || ($info['pay_type'] == 0 && $info['pay_status'] == 0 && $info['delivery_status'] == 0)) && $info['order_status'] == 0): ?> onclick="order_action.pay(1);"<?php else: ?> class="disabled"<?php endif; ?>>确认付款</a>-->
            <!--
            确认发货：[先发货后支付 || [先支付后发货 + 已支付]] && 已确认 && 待发货
            -->
            <a href="javascript:;" <?php if (($info['pay_type'] == 1 || ($info['pay_type'] == 0 && $info['pay_status'] == 1)) && $info['order_status'] == 1 && $info['delivery_status'] == 0 ):?>  onclick="order_action.delivery(1)" <?php else: ?> class="disabled"<?php endif ?>>确认发货</a>
            <!--
            确认完成：[先发货后支付 || 先支付后发货 && 已支付] &&  已确认 &&  已发货
            -->
            <a href="javascript:;"<?php if (($info['pay_type'] == 1 || ($info['pay_type'] == 0 && $info['pay_status'] == 1)) &&($info['order_status'] == 1 || $info['order_status'] == 5 ) && $info['delivery_status'] == 1 ): ?> onclick="order_action.order(2)"<?php else: ?> class="disabled"<?php endif ?>>确认完成</a>
            <?php  if($info['order_status'] == 5): ?>
                <a href="#" class="disabled">客户确认收货</a>
            <?php endif;?>
            <strong>退单操作：</strong>
            <!--
            退款：[先发货后支付 && 已完成 && 已退货] || [先支付后发货 && [未发货 || 已退货]] && 已支付
            执行：已退款
            -->
            <a href="javascript:;"<?php if (( ($info['pay_type'] == 1 && $info['order_status'] == 2 && $info['delivery_status'] == 2) || ($info['pay_type'] == 0 && ($info['delivery_status'] != 1))) && $info['pay_status'] == 1): ?> onclick="order_action.pay(2);"<?php else: ?> class="disabled"<?php endif ?>>退款</a>
            <!--
            退货：已完成 && 已发货
            执行：已退货
            -->
            <a href="javascript:;"<?php if ($info['order_status'] == 2 && $info['delivery_status'] == 1): ?> onclick="order_action.delivery(2)"<?php else: ?> class="disabled"<?php endif ?>>退货</a>
            <!--
            取消：[[未确认 && 先发货后支付] || [先支付后发货 && !已付款]] && 未发货 && [未确认 || 已确认]
            -->
            <a href="javascript:;"<?php if ((($info['order_status'] == 0 && $info['pay_type'] == 1) || ($info['pay_type'] == 0 && $info['pay_status'] != 1)) && $info['delivery_status'] == 0 && $info['order_status'] < 2) : ?> onclick="order_action.order(4);"<?php else: ?> class="disabled"<?php endif ?>>取消</a>
            <!--
            作废：已取消
            -->
            <a href="javascript:;"<?php if ($info['order_status'] == 4): ?> onclick="order_action.order(3);"<?php else: ?> class="disabled"<?php endif ?>>作废</a>
            <!--
            删除：已取消 || 已作废
            -->
            <a href="javascript:;" <?php if ($info['order_status'] > 2): ?> onclick="order_action.delete();" style="color:red"<?php else: ?> class="disabled"<?php endif ?>>删除</a>
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
                <a href="<?php echo U('AdminOrder/lists');?>">返回订单列表</a>
            </div>
            <strong>订单<br />详情</strong>
            <span>订单号：<?php echo ($info['order_sn']); ?></span>
            <span>订单状态：
                <b>
                    <?php echo $this->_config['c_order_status'][$info['order_status']];?>
                    <?php echo $this->_config['c_pay_status'][$info['pay_status']];?>
                    <?php echo $this->_config['c_delivery_status'][$info['delivery_status']];?>
                </b>
            </span>
            <span>订单类型：<img src="<?php echo IMG_PATH; ?>admin/ico_d_<?php echo $info['source'];?>.png" alt="" /></span>
        </div>

        <!--         <div class="detaxx">
            <table>
                <tr>
                    <th>分期</th> 
                    <th>应付订单金额</th>
                    <th>&nbsp;</th>
                    <th>商品总额</th>
                    <th>&nbsp;</th>
                    <th>配送费用</th>
                    <th>&nbsp;</th>
                    <th>发票税额</th>
                    <th>&nbsp;</th>
                    <th>保价费用</th>
                    <th>&nbsp;</th>
                    <th>商品折扣</th>
                    <th>&nbsp;</th>
                    <th>优惠券减免</th>
                    <th>&nbsp;</th>
                    <th>使用积分抵扣</th>
                </tr>
                <tr>
                    <td></td>
                    <td><font><?php echo $info['real_amount'];?></font></td>
                    <td><b>=</b></td>
                    <td><b><?php echo ($info['payable_amount']); ?></b></td>
                    <td><b>+</b></td>
                    <td><b><?php echo ($info['payable_freight']); ?></b></td>
                    <td><b>+</b></td>
                    <td><b><?php echo ($info['taxes']); ?></b></td>
                    <td><b>+</b></td>
                    <td><b><?php echo ($info['insured']); ?></b></td>
                    <td><b>-</b></td>
                    <td><b><?php echo ($info['discount']); ?></b></td>
                    <td><b>-</b></td>
                    <td><b><?php echo ($info['coupons']); ?></b></td>
                    <td><b>-</b></td>
                    <td><b><?php echo ($info['integral']); ?></b></td>
                </tr>-->

        <div class="detaxx">
            <table>
                <tr>
                    <th>分期</th>
                    <th>应付订单金额</th>
                    <th>&nbsp;</th>
                    <th>商品总额</th>
                    <th>&nbsp;</th>
                    <th>服务金额</th>
                    <!--                    <th>&nbsp;</th>
                                        <th>优惠金额</th>-->
                    <!--                    <th>&nbsp;</th>
                                        <th>发票税额</th>-->
                    <!--                    <th>&nbsp;</th>
                                        <th>保价费用</th>-->
                    <!--                    <th>&nbsp;</th>
                                        <th>商品折扣</th>-->
                    <th>&nbsp;</th>
                    <th>优惠券减免</th>
                    <th>&nbsp;</th>
                    <th>分期金额</th>
                    <th>确认收款</th>
                </tr>
                <?php foreach ($info['newsinfo'] as $key => $r): ?>
                    <tr>
                        <td><?php echo ($key+1);?>期</td>
                        <td><font><?php echo ($r['money']);?></font></td>
                        <td><b>=</b></td>
                        <td><b><?php $number = $r["payable_amount"]- $r['money'];  echo ($info['payable_amount']); ?></b></td>
                        <td><b>+</b></td>
                        <td><b><?php echo ($r["service_money"]); ?></b></td>
                        <td><b>-</b></td>
                        <td><b><?php echo ($r['coupons']); ?></b></td>
                        <td><b>-</b></td>
                        <td><b><?php echo (number_format($number,2,".","")); ?></b></td>
                        <!--                    <td><b>-</b></td>
                    <td><b><?php echo ($r['discount']); ?></b></td>-->
                        <!--                    <td><b>-</b></td>
                    <td><b><?php echo ($r['coupons']); ?></b></td>
                    <td><b>-</b></td>
                    <td><b><?php echo ($r['integral']); ?></b></td>-->
                        <td>
                            <?php if($r["pay_status"]==1):?>
                                <?php if($r["finance_type"]==0):?>
                                    <a   style="color:#2d689f" href="javascript:void(0)" onclick="submitmoney('<?php echo ($r['id']);?>','<?php echo ($info['order_sn']); ?>')">
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
                <?php endforeach;?>
            </table>
            <ul>
                <li>
                    <strong>客户订单留言：</strong>
                    <?php echo ($info['postscript'] ? $info['postscript']:'-'); ?>
                </li>
                <li >
                    <strong>订单备注：</strong>
                    <?php echo ($info['promotion_msg'] ? $info['promotion_msg']:'-'); ?>
                </li>
                <li class="none">
                    <!--                    <span><a href="javascript:" <?php if ((($info['_delivery']['type'] == 1 && $info['delivery_status'] == 1 && $info['pay_status'] == 0) || ($info['_delivery']['type'] == 0 && $info['pay_status'] == 0 && $info['delivery_status'] == 0)) && $info['order_status'] == 0): ?> id="editMoney"<?php else: ?> onclick="alert('当前订单状态不允许修改价格');"<?php endif; ?>>编辑费用信息</a></span>-->
                    <strong>发票信息：</strong>
                    <?php if ($info['invoice_title']): ?>
                        <?php $arrinvoice=  unserialize(base64_decode($info['invoice_title']));?>

                        <?php  if($arrinvoice["invoice_type"]==2):?>

                            单位名称:<?php echo ($arrinvoice["title"]);?><br>
                            纳税人识别码:<?php echo ($arrinvoice["taxpayer"]);?><br>
                            注册地址:<?php echo ($arrinvoice["reg_address"]);?><br>
                            注册电话:<?php echo ($arrinvoice["reg_tel"]);?><br>
                            开户银行:<?php echo ($arrinvoice["bank"]);?><br>
                            银行账户:<?php echo ($arrinvoice["account"]);?><br>

                        <?php elseif($arrinvoice["invoice_type"]==1) :?>
                            发票抬头:<?php echo ($arrinvoice["title"]);?>
                        <?php else :?>
                            不开发票
                        <?php endif;?>

                    <?php else: ?>
                        -
                    <?php endif ?>
                </li>

            </ul>
        </div>

        <dl class="blue_table mt10">
            <dt>
                <strong>分期信息</strong>
            </dt>
            <dd>
                <table>
                    <tr>
                        <th>分期</th>
                        <th>支付方式</th>
                        <th>分期金额</th>
                        <th>创建时间</th>
                        <th>支付金额</th>
                        <th>付款时间</th>
                        <th>支付银行</th>
                        <th>银行流水号</th>
                        <th>确认付款人</th>
                        <th>确认付款时间</th>
                        <th>操作</th>
                    </tr>
                    <?php  foreach ($info['order_staging'] as $key => $r): ?>
                        <tr>
                            <td>
                                <?php echo ($key+1);?>期
                            </td>
                            <td>
                                <?php echo ($r["staging_type"]==0?'线上支付':'线下支付');?>期
                            </td>
                            <td >
                                <?php echo ($r['money']); ?>
                            </td>
                            <td >
                                <?php echo (date('Y-m-d H:i:s', $r['create_time'])); ?>
                            </td>
                            <td>
                                <?php echo ($r['payment_money']==0?'未支付':$r['payment_money']); ?>
                            </td>
                            <td >
                                <?php echo ($r['payment_time']!=0?date('Y-m-d H:i:s', $r['payment_time']):"--"); ?>
                            </td>
                            <td >
                                <?php echo (base64_decode($r['bank'])); ?>
                            </td>
                            <td >
                                <?php echo ($r['bank_remit']); ?>
                            </td>
                            <td >
                                <?php echo ($r['adminname']); ?>
                            </td>
                            <td >
                                <?php echo ($r['finance_time']!=0?date('Y-m-d H:i:s', $r['finance_time']):"--"); ?>
                            </td>
                            <td><?php if(is_numeric($r["remit_url"]) && strlen($r["remit_url"])==18):?>
                                    <a target="_blank" href="<?php echo IMG_URL.Img_ADDRESS.$r["remit_url"];?>">查看凭证</a>
                                <?php elseif(empty($r["remit_url"])): ?>
                                    未上传凭证
                                    <?php else: ?>
                                    <a target="_blank" href="<?php echo IMG_URL.$r["remit_url"];?>">查看凭证</a>
                                <?php endif;?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </table>
            </dd>
        </dl>

        <dl class="blue_table mt10">
            <dt>
                <strong>收货人信息</strong>
                <!--<span><a href="javascript:" onclick="editaccept()">编辑用户信息</a></span>-->
            </dt>
            <dd>
                <table>
                    <tr>
                        <!--                        <th>会员号</th>-->
                        <th>收货人</th>
                        <th>手机号</th>
                        <th>邮编</th>
                        <th>详细地址</th>
                    </tr>
                    <tr>
                        <!--                        <td><?php echo (base64_decode($info['user_name'])); ?></td>-->
                        <td><?php echo (base64_decode($info['accept_name'])); ?></td>
                        <td><?php echo (base64_decode($info['mobile'])); ?></td>
                        <td><?php echo (base64_decode($info['zipcode'])); ?></td>
                        <td><?php echo (base64_decode($info['province']));?> <?php echo (base64_decode($info['city']));?>  <?php echo (base64_decode($info['area']));?> <?php echo (base64_decode($info['address'])); ?></td>
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
                        <td><p>配送方式：<?php echo ($info['delivery_txt']); ?>
                                <?php if ($info['delivery_status'] == 1 && $info['delivery_sn']): ?>
                                    <a href="javascript:" onclick="order_action.kuaidi('<?php echo $info['_delivery']['enname'] ?>');">查询订单发货情况</a> [由快递100提供技术支持]
                                <?php endif ?>
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
                        <th>商品条码</th>
                        <th>商品名称</th>
                        <th>商品属性</th>
                        <th>商品总价</th>
                        <th>购买数量</th>
                        <!--                        <th>商品库存</th>-->
                        <!--                        <th>商品总价</th>-->
                    </tr>
                    <?php foreach ($info['_goods'] as $key => $r): ?>
                        <tr>
                            <td><?php echo ($r['barcode']); ?></td>
                            <td><?php echo ($r['name']); ?></td>
                            <td align="left">
                                <?php
                                $spec_array = unserialize($r['spec_array']);

                                $trim =array(" ","　","\t","\n","\r");
                                $vstr =array("","","","","");
                                foreach ($spec_array as $spec) {
                                    $spec['name'] = str_replace($trim, $vstr, $spec['name']);
                                    $spec['value'] = str_replace($trim, $vstr, $spec['value']);
                                    echo $spec['name'].'：'.$spec['value'].'；';
                                }
                                ?>
                            </td>
                            <td><?php echo ($r['shop_price']); ?></td>
                            <td><?php echo ($r['shop_number']); ?></td>
                            <!--                        <td><?php echo ($r['goods_number']); ?></td>-->
                            <!--                        <td><?php echo (number_format($r['shop_price'] * $r['shop_number'], 2, '.', '')); ?></td>-->
                        </tr>
                    <?php endforeach ?>
                </table>
            </dd>
        </dl>


        <!--合同-->
        <dl class="blue_table mt10">
            <dt>
                <strong>合同信息</strong>
            </dt>
            <dd>
                <table>
                    <tr>
                        <th>客户合同</th>
                        <th>客户上传时间</th>
                        <!--                        <th>官方合同</th>
                                                <th>官方上传时间</th>
                                                <th>确认用户</th>
                                                <th>驳回原因</th>-->
                                                <th>操作</th>
                    </tr>
                    <?php
                     ?>
                    <?php foreach ($info['order_pact'] as $key => $r): ?>
                        <tr>
                            <td><?php if(empty($r["pact_url"])){?>
                                    客户合同未上传
                                    <?php }else{ ?>
                                    <a target="_blank" href="<?php echo   IMG_URL.$r["pact_url"];?>">查看合同</a>
                                <?php } ?>
                            </td>

                            <td>
                                <?php if($r["user_pact_time"]!=0):?>
                                    <?php echo(date('Y-m-d H:i:s', $r["user_pact_time"]));?>
                                <?php endif;?>
                            </td>

                            <td>
                                <?php if($r["pact_url"]!=''&&$r["pact_url"]!=null):?>
                                    <?php if($r["pact_status"]==3):?>
                                        <span style="color:#2d689f">审核通过</span>
                                    <?php endif;?>
                                    <?php if($r["pact_status"]!=3):?>
                                        <a href="javascript:void(0)" style="color:#2d689f" onclick="subgo('<?php echo $info['id']; ?>','3','<?php echo ($info['order_sn']); ?>')" >确认合同</a>
                                    <?php endif;?>
                                    <?php if($r["pact_status"]!=0&&$r["pact_status"]!=3):?>
                                        <a href="javascript:void(0)" style="color:#2d689f" onclick="order_action.reject(2,'<?php echo (U('admin_order/ajaxpact'));?>','<?php echo $info['id']; ?>',0);">驳回合同</a>
                                    <?php endif;?>
                                <?php endif;?>
                            </td>
                        <td>
                            <?php if($r["official_pact_time"]!=0):?> 
                                 <?php echo(date('Y-m-d H:i:s', $r["official_pact_time"]));?>
                            <?php endif;?>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </table>
            </dd>
        </dl>

        <dl class="blue_table mt10">
            <dt>
                <strong>官方合同信息</strong>
            </dt>
            <dd>
                <table>
                    <tr>
                        <th>官方合同</th>
                        <th>官方上传时间</th>
                        <th>确认用户</th>
                        <th>驳回原因</th>
                        <th>操作</th>
                    </tr>
                    <?php foreach ($info['order_pact_offo'] as $key => $r): ?>
                        <tr>

                            <td>
                                <?php if($r["official_pact_url"]==''||$r["official_pact_url"]==null ):?>
                                    官方合同未上传
                                <?php else :?>
                                    <a target="view_window" href="<?php echo IMG_URL.$r["official_pact_url"].'.'.$info["admin_extension"][0]['admin_extension'];?>">查看合同</a>
                                <?php endif;?>
                            </td>

                            <td>
                                <?php if($r["official_pact_time"]!=0):?>
                                    <?php echo(date('Y-m-d H:i:s', $r["official_pact_time"]));?>
                                <?php endif;?>
                            </td>
                            <td>
                                <?php echo($r["adminname"]);?>
                            </td>
                            <td>
                                <?php echo($r["reject"]);?>
                            </td>
                            <form action="<?php echo U('edit')?>" class="addform" method="post">
                            <td>
<!--                                --><?php //if($r["official_pact_url"]!=''&&$r["official_pact_url"]!=null):?>
<!--                                    <a target="_blank" href="--><?php //echo   IMG_URL.$r["pact_url"];?><!--">查看合同</a>-->
                                        <span id="hetong1" style="color:#2d689f">上传合同</span>
<!--                                        <input type="file" class="am-hide" id="pickfiles" >-->
                                    <input type="button" id="pickfiles" value="选择文件">
                                    <input  type="button"  class='button_search' style="margin-left: 30px;" onclick="subm('<?php echo $info['id']; ?>','<?php echo ($info['order_sn']); ?>')" value='保存合同'/>
                                        <div id="container">
                                            <input type="hidden" id='chengxing' name="official_pact_url" value="<?php echo $r["official_pact_url"]?>">

                                            <div style="display: none;">
                                                <img src="" id="imgpreview" alt="">
                                            </div>
                                        </div>

                            </td>
                                <input type="hidden"  name="id" value="<?php echo $info["id"]?>">
                            </form>
                        </tr>
                    <?php endforeach ?>
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
<script type="text/javascript" src="<?php echo __QINIU__;?>plupload/js/plupload.full.min.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>plupload/js/i18n/zh_CN.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>ui.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>qiniu.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>highlight.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>main-upload.js"></script>
<script type="text/javascript">
    function subm(orderid,order_sn) {
        var official_pact_url = $("#chengxing").val();
        if(official_pact_url==''){
            alert("请选择上传图片！");
        }else{
            $.post("<?php echo (U('admin_order/edit'));?>",{id:orderid,order_sn:order_sn,official_pact_url:official_pact_url},function(result){
                //alert(result);
                if(result!=0){
                    alert("上传成功！");
                    window.location.reload();//刷新当前页面.
                }else{
                    alert("上传失败！");
                }
            });
        }
    }

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


//    var real_amount = <?php //echo $info['real_amount'];?>//;
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
    });
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
</script>
