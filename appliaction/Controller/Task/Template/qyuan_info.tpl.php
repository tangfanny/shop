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
        <a href="<?php echo U('Qyuan/lists');?>">请愿项目列表</a>
        > <a >详细信息</a>
    </div>
    <span class="line_white"></span>
    <div class="install mt10">
        <dl>
            <dd>
                <div class="install mt10">
                    <div class="install mt10">
                        <dl>
                            <form action="<?php echo U('Qyuan/qyuaninfo');?>" method="post">
            <dd>
                <ul class="web">
                    <li>
                        <div class="c1">logo：</div>
                        <span>
                            <?php if(is_numeric($info['logo']) && strlen($info['logo'])==18):?>
                                <img  src="<?php echo IMG_URL.Img_ADDRESS.$info['logo'].'?imageView2/2/w/200 ';?>"/>
                            <?php elseif(empty($info['logo'])): ?>
                            <?php else: ?>
                                <img  src="<?php echo IMG_URL.$info['logo'].'?imageView2/2/w/200' ;?>"/>
                            <?php endif;?>
                           </span>
                    </li>
                    <li>
                        <div class="c1">浏览人数：</div><span><?php echo $info['hits']; ?></span>
                    </li>
                    <li>
                        <div class="c1">创建时间：</div><span><?php echo  isset($info["creat_time"])?date('Y-m-d H:i:s', $info["creat_time"]):date('Y-m-d H:i:s',NOW_TIME)?></span>
                    </li>
                    <li>
                        <div class="c1">标题：</div><span><?php echo $info['title']; ?></span>
                    </li>
                    <li>
                        <?php if($info['ispass'] == 0): ?>
                            <div class="c1">审核状态：</div><span style='color:green;'>未审核</span>
                        <?php elseif($info['ispass'] ==  1): ?>
                            <div class="c1">审核状态：</div><span style='color:green;'>通过</span>
                        <?php elseif($info['ispass'] ==  2): ?>
                            <div class="c1">审核状态：</div><span style='color:green;'>驳回</span>
                        <?php endif;?>
                    </li>
                    <li>
                        <?php if($info['isok'] == 0): ?>
                            <div class="c1">请愿状态：</div><span style='color:green;'>进行中</span>
                        <?php elseif($info['isok'] ==  1): ?>
                            <div class="c1">请愿状态：</div><span style='color:green;'>请愿成功</span>
                        <?php elseif($info['isok'] ==  2): ?>
                            <div class="c1">请愿状态：</div><span style='color:green;'>请愿失败</span>
                        <?php endif;?>
                    </li>
                    <li>
                        <div class="c1">内容：</div><span><?php echo $info['content']; ?></span>
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


