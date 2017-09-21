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
        <a >漏洞列表</a>
        > <a >详细信息</a>
    </div>
    <span class="line_white"></span>
    <div class="install mt10">
        <dl>
            <dd>
                <div class="install mt10">
                    <div class="install mt10">
                        <dl>
                            <form action="<?php echo U('Task/ldshenhe');?>" method="post">
            <dd>
                <ul class="web">
                    <li><h2>会员基本信息></h2></li>
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
                        <div class="c1">漏洞类别：</div><span><?php echo $info['bug_class']; ?></span>
                    </li>
                    <li>
                        <div class="c1">提交时间：</div><span><?php echo  isset($info["create_time"])?date('Y-m-d H:i:s', $info["create_time"]):date('Y-m-d H:i:s',NOW_TIME); ?></span>
                    </li>
                    <li>
                        <div class="c1">漏洞描述：</div><span><?php echo $info['description']; ?></span>
                    </li>
                    <li>
                        <div class="c1">解决方案：</div><span><?php echo $info['content']; ?></span>
                    </li>
                    <li>
                        <div class="c1">白帽子定义漏洞级别：</div><span><?php echo $info['level']; ?></span>
                    </li>
                    <li>
                        <div class="c1">厂商定义漏洞级别：</div><span><?php echo $info['cs_level']; ?></span>
                    </li>
                    <li>
                        <div class="c1">厂商反馈：</div><span><?php echo $info['scfeedback']; ?></span>
                    </li>
                    <li>
                        <div class="c1">平台初审漏洞级别：</div><span><?php echo $info['admin_1st_level']; ?></span>
                    </li>
                    <li>
                        <div class="c1">管理员反馈结果：</div><span><?php echo $info['feedback']; ?></span>
                    </li>
                    <li>
                        <div class="c1">创建时间：</div><span><?php echo  isset($info["create_time"])?date('Y-m-d H:i:s', $info["create_time"]):date('Y-m-d H:i:s',NOW_TIME)?></span>
                    </li>
                    <li>
                        <div class="c1">初审时间：</div><span><?php echo  isset($info["admin_1st_timestamp"])?date('Y-m-d H:i:s', $info["admin_1st_timestamp"]):date('Y-m-d H:i:s',NOW_TIME)?></span>
                    </li>
                    <li>
                        <div class="c1">终审时间：</div><span><?php echo  isset($info["admin_last_timestamp"])?date('Y-m-d H:i:s', $info["admin_last_timestamp"]):date('Y-m-d H:i:s',NOW_TIME)?></span>
                    </li>
                    <li>
                            <?php if($info['ispass'] == 0): ?>
                                <div class="c1">审核状态：</div><span style='color:green;'>待审核</span>
                            <?php elseif($info['ispass'] ==  1): ?>
                                <div class="c1">审核状态：</div><span style='color:green;'>平台初审通过</span>
                            <?php elseif($info['ispass'] ==  2): ?>
                                <div class="c1">审核状态：</div><span style='color:green;'>平台初审驳回</span>
                            <?php elseif($info['ispass'] ==  3): ?>
                                <div class="c1">审核状态：</div><span style='color:green;'>厂商审核中</span>
                            <?php elseif($info['ispass'] ==  4): ?>
                                <div class="c1">审核状态：</div><span style='color:green;'>厂商确认，进行平台终审</span>
                            <?php elseif($info['ispass'] ==  5):?>
                                <div class="c1">审核状态：</div><span style='color:green;'>厂商驳回，进行平台终审</span>
                            <?php elseif($info['ispass'] ==  6): ?>
                                <div class="c1">审核状态：</div><span style='color:green;'>平台终审中</span>
                            <?php elseif($info['ispass'] ==  7): ?>
                                <div class="c1">审核状态：</div><span style='color:green;'>平台终审驳回</span>
                            <?php elseif($info['ispass'] ==  8): ?>
                                <div class="c1">审核状态：</div><span style='color:green;'>平台终审通过</span>
                            <?php endif;?>
                    </li>
                    <li>
                        <?php if ($info['ispass']  == 0 || $info['ispass']  == 1 || $info['ispass']  == 2): ?>
                        <h4>初审审核</h4>
                        <select class="form-control" name="ispass" required>
                            <option value="">未选择</option>
                            <option value="1" <?php if($info['ispass'] == 1){echo 'selected';}?>>通过</option>
                            <option value="2" <?php if($info['ispass'] == 2){echo 'selected';}?>>驳回</option>
                        </select>
                        <?php endif;?>
                    </li>
                    <li>
                        <?php if ($info['ispass']  == 4 || $info['ispass']  == 5 || $info['ispass']  == 6 || $info['ispass']  == 7 || $info['ispass']  == 8): ?>
                            <h4>终审审核</h4>
                            <select class="form-control" name="ispass" required>
                                <option value="6" <?php if($info['ispass'] == 6){echo 'selected';}?>>平台终审中</option>
                                <option value="8" <?php if($info['ispass'] == 8){echo 'selected';}?>>通过</option>
                                <option value="7" <?php if($info['ispass'] == 7){echo 'selected';}?>>驳回</option>
                            </select>
                        <?php endif;?>
                    </li>
                    <li>
                        <?php if ($info['ispass']  == 0 || $info['ispass']  == 1 || $info['ispass']  == 2): ?>
                            <h4>平台初审级别</h4>
                            <select class="form-control" name="admin_1st_level">
                                <option value="低危" <?php if($info['admin_1st_level'] == "低危"){echo 'selected';}?>>低危</option>
                                <option value="中危" <?php if($info['admin_1st_level'] == "中危"){echo 'selected';}?>>中危</option>
                                <option value="高危" <?php if($info['admin_1st_level'] == "高危"){echo 'selected';}?>>高危</option>
                            </select>
                        <?php endif;?>
                    </li>
                    <li>
                        <?php if ($info['ispass']  == 4 || $info['ispass']  == 5 || $info['ispass']  == 6 || $info['ispass']  == 7 || $info['ispass']  == 8): ?>
                            <h4>平台终审级别</h4>
                            <select class="form-control" name="admin_level">
                                <option value="低危" <?php if($info['admin_level'] == "低危"){echo 'selected';}?>>低危</option>
                                <option value="中危" <?php if($info['admin_level'] == "中危"){echo 'selected';}?>>中危</option>
                                <option value="高危" <?php if($info['admin_level'] == "高危"){echo 'selected';}?>>高危</option>
                            </select>
                        <?php endif;?>
                    </li>
                    <li>
                        <?php if ($info['ispass']  == 0 || $info['ispass']  == 1 || $info['ispass']  == 2): ?>
                            <tr><td align="center"><h4>平台初审的反馈</h4></td></tr>
                            <tr>
                                <td align="center">
                                    <textarea rows="5" cols="80" class="form-control"  name="admin_1st_feedback" required><?php echo $info['admin_1st_feedback']; ?></textarea>
                                <td>
                            </tr>
                        <?php endif;?>
                    </li>
                    <li>
                        <?php if ($info['ispass']  == 4 || $info['ispass']  == 5 || $info['ispass']  == 6 || $info['ispass']  == 7 || $info['ispass']  == 8): ?>
                            <tr><td align="center"><h4>平台终审的反馈</h4></td></tr>
                            <tr>
                                <td align="center">
                                    <textarea rows="5" cols="80" class="form-control"  name="feedback" disabled><?php echo $info['feedback']; ?></textarea>
                                <td>
                            </tr>
                        <?php endif;?>
                    </li>
                    <li>
                        <input type="hidden" name="bugid" value="<?php echo $info['bugid']; ?>">
                    </li>
                    <li>
                        <input type="hidden" name="taskid" value="<?php echo $info['taskid']; ?>">
                    </li>
                    <li>
                        <input type="hidden" name="uid" value="<?php echo $info['uid']; ?>">
                    </li>
                    <li>
                        <?php if ($info['ispass']  == 3 ||  $info['ispass']  == 8): ?>
                            <?php else: ?>
                            <input type='submit' value='提交审核结果' id="post_submit" class='btn btn-block btn-primary'>
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


