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
        <a href="<?php echo U('Qyuan/lists');?>">请愿项目列表</a> >
        <a >漏洞列表</a>
        > <a >查看审核</a>
    </div>
    <span class="line_white"></span>
    <div class="install mt10">
        <dl>
            <dd>
                <div class="install mt10">
                    <div class="install mt10">
                        <dl>
                            <form action="<?php echo U('Qyuan/ldshenhe');?>" method="post">
            <dd>
                <ul class="web">
                    <li>
                        <div class="c1">白帽子id：</div><span><?php echo $info['uid']; ?></span>
                    </li>
                    <li>
                        <div class="c1">众测编号：</div><span><?php echo $info['taskid']; ?></span>
                    </li>
                    <li>
                        <div class="c1">漏洞标题：</div><span><?php echo $info['title']; ?></span>
                    </li>
                    <li>
                        <div class="c1">测试ip：</div><span><?php echo $info['test_ip']; ?></span>
                    </li>
                    <li>
                        <div class="c1">测试url地址：</div><span><?php echo $info['test_url']; ?></span>
                    </li>
                    <li>
                        <div class="c1">漏洞级别：</div><span><?php echo $info['level']; ?></span>
                    </li>
                    <li>
                        <div class="c1">漏洞类别：</div><span><?php echo $info['bug_class']; ?></span>
                    </li>
                    <li>
                        <div class="c1">创建时间：</div><span><?php echo  isset($info["creat_time"])?date('Y-m-d H:i:s', $info["creat_time"]):date('Y-m-d H:i:s',NOW_TIME)?></span>
                    </li>
                    <li>
                        <div class="c1">漏洞描述：</div><span><?php echo $info['description']; ?></span>
                    </li>
                    <li>
                        <div class="c1">解决方案：</div><span><?php echo $info['content']; ?></span>
                    </li>
                    <li>
                        <?php if($info['ispass'] == 0): ?>
                            <div class="c1">审核结果：</div><span style='color:green;'>审核中</span>
                        <?php elseif($info['ispass'] ==  1): ?>
                            <div class="c1">审核结果：</div><span style='color:green;'>审核通过</span>
                        <?php elseif($info['ispass'] ==  2): ?>
                            <div class="c1">审核结果：</div><span style='color:green;'>驳回</span>
                        <?php elseif($info['ispass'] ==  3): ?>
                            <div class="c1">审核结果：</div><span style='color:green;'>厂商认证中</span>
                        <?php elseif($info['ispass'] ==  4): ?>
                            <div class="c1">审核结果：</div><span style='color:green;'>厂商通过</span>
                        <?php elseif($info['ispass'] ==  5):?>
                            <div class="c1">审核结果：</div><span style='color:green;'>厂商驳回</span>
                        <?php endif;?>
                    </li>
                    <li>
                        <div class="c1">管理员定义漏洞级别：</div><span><?php echo $info['admin_level']; ?></span>
                    </li>
                    <li>
                        <div class="c1">管理员反馈结果：</div><span><?php echo $info['feedback']; ?></span>
                    </li>

                    <li>
                        <h4>审核:</h4>
                        <select class="form-control" name="ispass" required>
                            <option value="0" <?php if($info['ispass'] == 0){echo 'selected';}?>>审核中</option>
                            <option value="1" <?php if($info['ispass'] == 1){echo 'selected';}?>>审核通过</option>
                            <option value="2" <?php if($info['ispass'] == 2){echo 'selected';}?>>驳回</option>
                            <option value="3" <?php if($info['ispass'] == 3){echo 'selected';}?>>厂商认证中</option>
                            <option value="4" <?php if($info['ispass'] == 4){echo 'selected';}?>>厂商通过</option>
                            <option value="5" <?php if($info['ispass'] == 5){echo 'selected';}?>>厂商驳回</option>
                        </select>
                    </li>
                    <li>
                    <li>
                        <div class="c1">漏洞级别：</div><span><?php echo $info['level']; ?></span>
                    </li>
                    <li>
                        <div class="c1">反馈结果：</div><textarea rows="8" cols="97" class="form-control"  name="feedback" style="border-radius: 4px;width: 400px;">
                            <?php if(!empty($info['feedback'])): ?>
                                <?php echo $info['feedback']; ?>
                            <?php else: ?>
                                <?php echo "非常感谢您的参与!"; ?>
                            <?php endif;?>
                            </textarea>
                    </li>
                    <li>
                        <input type="hidden" name="idx" value="<?php echo $info['idx']; ?>">
                    </li>
                    <li>
                        <input type="hidden" name="taskid" value="<?php echo $info['taskid']; ?>">
                    </li>
                    <li>
                        <input type="hidden" name="uid" value="<?php echo $info['uid']; ?>">
                    </li>
                    <li>
                        <input type='submit' value='提交审核结果' id="post_submit" class='btn btn-block btn-primary'>
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


