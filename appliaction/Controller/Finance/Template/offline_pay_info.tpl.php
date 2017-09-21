<?php include $this->admin_tpl("header"); ?>
<style type="text/css">
    select option{padding: 2px}
    .c1{float: left;width:100px;}
    .web li{padding: 4px 0;}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>ns_common.css" />
<!-- 内容区 -->
<div class="content" style="font-size:14px;">
    <div class="site">
        <a href="<?php echo U('Finance/lists');?>">财务管理</a> >
        <a href="<?php echo U('Finance/lists');?>">线下充值</a>
        >
        <a href="javascript:location.replace(location.href);">充值流水号：<?php echo $info['trade_no']; ?></a>
    </div>
    <h3 style="color:red;">注意：当选择支付成功后，钱将打到用户余额中然后不能进行任何操作！</h3>
    <span class="line_white"></span>
    <div class="install mt10">
        <dl>
            <dd>
                <div class="install mt10">
                    <div class="install mt10">
                        <dl>
                            <form action="<?php echo U('Pay/edit');?>" method="post">
            <dd>
                <ul class="web">
                    <li>
                        <div class="c1">支付图片：</div>
                        <span>
                             <?php if(is_numeric($info['pay_images']) && strlen($info['pay_images'])==18):?>
                                 <img  src="<?php echo IMG_URL.Img_ADDRESS.$info['pay_images'].'?imageView2/2/w/200 ';?>"/>
                             <?php elseif(empty($info['pay_images'])): ?>
                             <?php else: ?>
                                 <img  src="<?php echo IMG_URL.$info['pay_images'].'?imageView2/2/w/200' ;?>"/>
                             <?php endif;?>
                        </span>
                    </li>
                    <li>
                        <div class="c1">用户UID：</div><span><?php echo $info['uid']; ?></span>
                    </li>
                    <li>
                        <div class="c1">当前余额：</div><span><?php echo $info['balance']; ?></span>
                    </li>
                    <li>
                        <div class="c1">充值总数：</div><span><?php echo $info['prepaid']; ?></span>
                    </li>
                    <li>
                        <div class="c1">支出总数：</div><span><?php echo $info['expense']; ?></span>
                    </li>
                    <li>
                        <div class="c1">充值金额：</div><span><?php echo $info['ordtotal_fee']; ?></span>
                    </li>
                    <li>
                        <div class="c1">充值名称：</div><span><?php echo $info['ordsubject']; ?></span>
                    </li>
                    <li>
                        <div class="c1">充值描述：</div><span><?php echo date("Y年m月d日 H:i:s",$info['ordbody']); ?></span>
                    </li>
                    <li>
                        <div class="c1">创建时间：</div><span><?php echo date("Y年m月d日 H:i:s",$info['create_time']); ?></span>
                    </li>
                    <li>
                        <div class="c1">审核时间：</div><span><?php echo date("Y年m月d日 H:i:s",$info['check_time']); ?></span>
                    </li>
                    <li>
                        <div class="c1">充值金额：</div><span><input type="text" name="ordtotal_fee" value="<?php echo $info['ordtotal_fee'];?>" style="border-radius: 4px;height: 20px;width: 400px;"></span>
                    </li>
                    <li>
                        <div class="c1">支付状态：</div><div>
                            <select class="form-control" name="prepay_suc" id="prepay_suc" style="width: 405px;border-radius: 4px;margin-left:59px;" >
                                <option value="1" <?php if($info['prepay_suc'] == 1){echo 'selected';}?>>支付成功</option>
                                <option value="0" <?php if($info['prepay_suc'] == 0){echo 'selected';}?>>支付失败</option>
                                <option value="3" <?php if($info['prepay_suc'] == 3){echo 'selected';}?>>等待审核</option>

                            </select>
                        </div>
                    </li>

                    <li>
                        <div class="c1">失败原因：</div><span><textarea rows="8" cols="97" class="form-control" id="refusal" name="refusal" style="border-radius: 4px;width: 400px;"><?php echo $info['refusal']; ?></textarea></span>
                    </li>
                    <li>
                        <input type="hidden" name="id" value="<?php echo $info['id']; ?>">
                    </li>
                    <li>
                        <input type="hidden" name="uid" value="<?php echo $info['uid']; ?>">
                    </li>
                    <li>
                        <?php
                        if ($info['prepay_suc'] == 1) {
                            echo date("Y年m月d日 H:i:s",$info['check_time']).'&nbsp&nbsp'."已支付成功";
                        }else{
                            echo "<input type='submit' value='提交认证结果'  id='post_submit'  class='btn btn-block btn-primary'>";
                        }
                        ?>
                    </li>
                </ul>
            </dd>
            </form>
        </dl>
    </div>
    </dd>
    </dl>
</div>
</div>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.min.js"></script>
<script type="text/javascript">
    $("#post_submit").click(function(){
        var status = $("#prepay_suc option:selected").val();
        var refusal = $("#refusal").val();
        if (status == 0) {
            if (refusal == '') {
                alert("若选择支付失败请填写失败原因！");
                return false;
            }
        }
    });
</script>
