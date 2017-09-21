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
            <a href="<?php echo U('Finance/lists');?>">提现审核</a>
            >
            <a href="javascript:location.replace(location.href);">提现单号：<?php echo $info['cash_id']; ?></a>
        </div>
        <span class="line_white"></span>
    <div class="install mt10">
        <dl>
            <dd>
                <div class="install mt10">
                    <div class="install mt10">
                        <dl>
                            <form action="<?php echo U('Finance/edit');?>" method="post">
                                <dd>
                                    <ul class="web">
                                        <li>
                                            <div class="c1">用户昵称：</div><span><?php echo $info['nikename']; ?></span>
                                        </li>
                                        <li>
                                            <div class="c1">用户手机号：</div><span><?php echo $info['mobile']; ?></span>
                                        </li>
                                        <li>
                                            <div class="c1">用户邮箱：</div><span><?php echo $info['email']; ?></span>
                                        </li>
                                        <li>
                                            <div class="c1">账户名字：</div><span><?php echo $info['account_user']; ?></span>
                                        </li>
                                        <li>
                                            <div class="c1">账户号码：</div><span><?php echo $info['account_id']; ?></span>
                                        </li>
                                        <li>
                                            <div class="c1">提现方式：</div><span>
                                            <?php
                                            switch ($info['account_type']) {
                                                case '1':
                                                    echo "支付宝";
                                                    break;
                                                case '2':
                                                    echo "微信";
                                                    break;
                                                default:
                                                    echo "银行卡";
                                                    break;
                                            }
                                            ?></span>
                                        </li>
                                        <li>
                                            <div class="c1">开户行：</div><span><?php echo $info['account_address']; ?></span>
                                        </li>
                                        <li>
                                            <div class="c1">申请时间：</div>
                                            <span><?php echo date("Y-m-d H:i:s", $info["apply_time"]); ?></span>
                                        </li>
                                        <?php if ($info['status'] != 1): ?>
                                            <li>
                                                <div class="c1">审核时间：</div>
                                                <span><?php echo date("Y-m-d H:i:s", $info["check_time"]); ?></span>
                                            </li>
                                        <?php endif ?>
                                        <?php if ($info['status'] == 3): ?>
                                            <li>
                                                <div class="c1">出款时间：</div>
                                                <span><?php echo date("Y-m-d H:i:s", $info["cash_time"]); ?></span>
                                            </li>
                                        <?php endif ?>
                                        <li>
                                            <div class="c1">账户余额：</div><span><?php echo $info['balance']; ?></span>
                                        </li>
                                        <li>
                                            <div class="c1">充值总数：</div><span><?php echo $info['prepaid']; ?></span>
                                        </li>
                                        <li>
                                            <div class="c1">收入总数：</div><span><?php echo $info['income']; ?></span>
                                        </li>
                                        <li>
                                            <div class="c1">支出总数：</div><span><?php echo $info['expense']; ?></span>
                                        </li>
                                        <li>
                                            <div class="c1" style="line-height:30px">提现金额：</div>
                                            <span><h2 style="color:red;"><?php echo $info['money']; ?></h2></span>
                                        </li>
                            <?php if ($info['status'] == 1 || $info['status'] == 2): ?>
                                        <li>
                                            <select name="status" id="status" class="ns-select" onChange="javascript:c(this);">
                                                <option value="1" <?php if ($info['status'] == 1): ?>selected<?php endif ?>>申请中</option>
                                                <option value="2" <?php if ($info['status'] == 2): ?>selected<?php endif ?>>审核中</option>
                                                <option value="3" <?php if ($info['status'] == 3): ?>selected<?php endif ?>>出款</option>
                                                <option value="4" <?php if ($info['status'] == 4): ?>selected<?php endif ?>>驳回</option>
                                            </select>
                                            <span id="prompt">选择一项审核状态</span>
                                        </li>
                                        <li>
                                        <textarea name="refusal" style="margin-right: 8px;width:248px" id="refusal"></textarea>
                                            <span>若选择驳回请填写驳回原因</span>
                                        </li>
                                        <li class="submit">
                                            <input name="id" value="<?php echo $info['id'];?>" type="hidden">
                                            <input name="uid" value="<?php echo $info['uid'];?>" type="hidden">
                                            <input name="mobile" value="<?php echo $info['mobile'];?>" type="hidden">
                                            <input name="nikename" value="<?php echo $info['nikename'];?>" type="hidden">
                                            <input name="balance" value="<?php echo $info['balance'];?>" type="hidden">
                                            <input name="expense" value="<?php echo $info['expense'];?>" type="hidden">
                                            <input name="money" value="<?php echo $info['money'];?>" type="hidden">
                                            <input name="check_time" value="<?php echo $info['check_time'];?>" type="hidden">
                                            <input type="submit" id="post_submit" class='button_search' value='提交' style="margin:2px 0px;padding:0 50px 0 25px;">
                                        </li>
                            <?php endif ?>
                            <?php if ($info['status'] == 3): ?>
                                        <li>
                                            <div class="c1" style="line-height:35px">提现状态：</div>
                                            <span><h2 style="color:red;">已出款</h2></span>
                                        </li>
                                        <li class="submit">
                                            <a href="<?php echo U('lists')?>" style="margin:0px">返回</a>
                                        </li>
                            <?php endif ?>
                            <?php if ($info['status'] == 4): ?>
                                        <li>
                                            <div class="c1" style="line-height:35px">提现状态：</div>
                                            <span><h2 style="color:red;">已驳回</h2></span>
                                        </li>
                                        <li>
                                            <div class="c1">驳回原因：</div>
                                            <span>
                                                <?php echo $info['refusal']; ?>
                                            </span>
                                        </li>
                                        <li class="submit">
                                            <a href="<?php echo U('lists')?>" style="margin:0px">返回</a>
                                        </li>
                            <?php endif ?>
                                        
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
    var status = $("#status option:selected").val();
    var refusal = $("#refusal").val();
    if (status == 4) {
        if (refusal == '') {
            alert("若选择驳回请填写驳回原因！");
            return false;
        }
    }
});
function c(e){
    var cid = $(e).val();
    if (cid == 3) {
        $("#prompt").empty();
        $("#prompt").append("注意：当选择出款状态并提交后，此笔提现账单结束，而后不能对此进行任何操作！");
    }else if (cid == 4) {
        $("#prompt").empty();
        $("#prompt").append("注意：当选择驳回后，钱将从此笔提现账单中<i style='color:red;'>返回</i>到当前用户钱包(<?php echo $info['money']; ?>)，而后不能对此进行任何操作！");
    }else{
        $("#prompt").empty();
        $("#prompt").append("选择一项审核状态");
    }
}
</script>
</body>
</html>