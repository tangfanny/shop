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
        <a >众测管理</a> >
        <a href="<?php echo U('Task/lists');?>">众测项目列表</a> >
        <a >报名列表</a>
        > <a >详细信息</a>
    </div>
    <span class="line_white"></span>
    <div class="install mt10">
        <dl>
            <dd>
                <div class="install mt10">
                    <div class="install mt10">
                        <dl>
                            <form action="<?php echo U('Task/showinfo');?>" method="post">
            <dd>
                <ul class="web">
                    <li><h2>会员基本信息</h2></li>
                    <li>
                        <div class="c1">头像：</div>
                        <span>
                             <?php if(is_numeric($info['avatars']) && strlen($info['avatars'])==18):?>
                                 <img  src="<?php echo IMG_URL.Img_ADDRESS.$info['avatars'].'?imageView2/2/w/200 ';?>"/>
                             <?php elseif(empty($info['avatars'])): ?>
                                 当前未上传头像
                             <?php else: ?>
                                 <img  src="<?php echo IMG_URL.$info['avatars'].'?imageView2/2/w/200' ;?>"/>
                             <?php endif;?>
                        </span>
                    </li>
                    <li>
                        <div class="c1">邮箱：</div><span><?php echo $info['email']; ?></span>
                    </li>
                    <li>
                        <div class="c1">昵称：</div><span><?php echo $info['nikename']; ?></span>
                    </li>
                    <li>
                        <div class="c1">手机：</div><span><?php echo $info['mobile']; ?></span>
                    </li>
                    <li>
                        <div class="c1">建号时间：</div><span><?php echo  isset($info["create_time"])?date('Y-m-d H:i:s', $info["create_time"]):date('Y-m-d H:i:s',NOW_TIME)?></span>
                    </li>
                    <li><h2>白帽子认证信息</h2></li>
                    <li>
                        <div class="c1">真实姓名：</div><span><?php echo $whiteinfo['name']; ?></span>
                    </li>
                    <li>
                        <div class="c1">身份证照：</div>
                        <span>
                             <?php if(is_numeric($whiteinfo['identity_image1']) && strlen($whiteinfo['identity_image1'])==18):?>
                                 <img  src="<?php echo IMG_URL.Img_ADDRESS.$whiteinfo['identity_image1'].'?imageView2/2/w/200 ';?>"/>
                             <?php elseif(empty($whiteinfo['identity_image1'])): ?>
                             <?php else: ?>
                                 <img  src="<?php echo IMG_URL.$whiteinfo['identity_image1'].'?imageView2/2/w/200' ;?>"/>
                             <?php endif;?>
                        </span>
                    </li>
                    <li>
                        <div class="c1">提现账号：</div><span><?php echo $WalletInfo['account_id']; ?></span>
                    </li>
                    <li>
                        <div class="c1">户名：</div><span><?php echo $WalletInfo['account_user']; ?></span>
                    </li>

                    <li>
                        <?php if ($WalletInfo['account_type'] == 1): ?>
                            <div class="c1">账户类型：</div><span style='color:green;'>支付宝</span>
                        <?php elseif($WalletInfo['account_type'] == 2): ?>
                            <div class="c1">账户类型：</div><span style='color:green;'>微信</span>
                        <?php elseif($WalletInfo['account_type'] == 3): ?>
                            <div class="c1">账户类型：</div><span style='color:green;'>银行卡</span></br>
                            <div class="c1">开户行：</div><span style='color:green;'><?php echo $WalletInfo['account_address']; ?></span>
                        <?php else: ?>
                            <div class="c1">开户行：</div><span style='color:green;'><?php echo $WalletInfo['account_address']; ?></span>
                        <?php endif;?>
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

