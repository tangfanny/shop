<?php include $this->admin_tpl("header"); ?>
<style type="text/css">
    select option{padding: 2px}
    .c1{float: left;width:100px;}
    .web li{padding: 4px 0;}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>ns_common.css" />
<!-- 内容区 -->
<div class="content">
    <div class="site">
        <a href="#">会员管理</a> > 会员详情
    </div>
    <span class="line_white"></span>
    <div class="install mt10">
        <dl>
            <dd>
                <div class="install mt10">
                    <div class="install mt10">
                        <dl>
            <dd>
                <ul class="web">
                    <li>
                        <div class="c1">会员名：</div><span><?php echo $data['nikename']; ?></span>
                    </li>
                    <li>
                        <div class="c1">会员角色：</div><span><?php echo $data['role']; ?></span>
                    </li>
                    <li>
                        <div class="c1">会员等级：</div><span><?php echo $data['name']; ?></span>
                    </li>
                    <li>
                        <div class="c1">手机号：</div><span><?php echo $data['mobile']; ?></span>
                    </li>
                    <li>
                        <div class="c1">电子邮箱：</div><span><?php echo $data['email']; ?></span>
                    </li>
                    <li>
                        <div class="c1">注册时间：</div><span><?php echo date("Y-m-d H:i:s",$data['create_time']); ?></span>
                    </li>
                </ul>
            </dd>
        </dl>
    </div>
    </dd>
    </dl>
</div>
</div>
</body>
</html>