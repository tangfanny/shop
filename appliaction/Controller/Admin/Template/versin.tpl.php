<?php include $this->admin_tpl('header'); ?>
<div class="content">
    <div class="site">
        <a href="#">站点设置</a> > <a href="javascript:location.replace(location.href);">APP版本控制</a>
    </div>
    <span class="line_white"></span>
    <div class="install mt10">
        <dl>
            <dd>
                <div class="install mt10">
                    <div class="install mt10">
                        <dl>
                            <form action="<?php echo U('Version/save') ?>" class="addform" method="post">
                                <dd>
                                    <ul class="web">
                                        <li>
                                            <strong>电商分类配置：</strong>
                                            <input type="text" class="text_input" name="mall_category" placeholder='' value="<?php echo $list["mall_category"];?>"  /><span class="Validform_checktip ">电商分类配置
                                            </span>
                                        </li>
                                        <li>
                                            <strong>资讯分类配置：</strong>
                                            <input type="text" class="text_input" name="new_category" placeholder='' value="<?php echo $list["new_category"];?>"   /><span class="Validform_checktip">资讯分类配置</span>
                                        </li>
                                        <li>
                                            <strong>底部导航按钮：</strong>
                                            <input type="text" class="text_input" name="menus" placeholder='' value="<?php echo $list["menus"];?>"  /><span class="Validform_checktip">底部导航按钮</span>
                                        </li>
                                        <li>
                                            <strong>标签：</strong>
                                            <input type="text" class="text_input" name="tags" placeholder='' value="<?php echo $list["tags"];?>"    /><span class="Validform_checktip">标签</span>
                                        </li>
                                        <li>
                                            <strong>销售等级：</strong>
                                            <input type="text" class="text_input" name="levels" placeholder='' value="<?php echo $list["levels"];?>"   /><span class="Validform_checktip">销售等级</span>
                                        </li>

                                        <li>
                                            <strong>银行信息：</strong>
                                            <input type="text" class="text_input" name="bank" placeholder='' value="<?php echo $list["bank"];?>"    /><span class="Validform_checktip">银行信息</span>
                                        </li>
                                        <li>
                                            <strong>分享：</strong>
                                            <input type="text" class="text_input" name="share" placeholder=''value="<?php echo $list["share"];?>"     /><span class="Validform_checktip">分享</span>
                                        </li>
                                        <li>
                                            <strong>服务电话：</strong>
                                            <input type="text" class="text_input" name="mobel" placeholder=''value="<?php echo $list["mobel"];?>"     /><span class="Validform_checktip">分享</span>
                                        </li>
                                        <li>
                                            <strong>支付方式：</strong>
                                            <input type="text" class="text_input" name="pay_types" placeholder='' value="<?php echo $list["pay_types"];?>"      /><span class="Validform_checktip">支付方式</span>
                                        </li>
                                        <li>
                                            <strong>订单状态：</strong>
                                            <input type="text" class="text_input" name="order_status" placeholder=''  value="<?php echo $list["order_status"];?>"   /><span class="Validform_checktip">订单状态</span>
                                        </li>
                                        <li>
                                            <strong>文章属性：</strong>
                                            <input type="text" class="text_input" name="attr" placeholder='' value="<?php echo $list["attr"];?>"   /><span class="Validform_checktip">文章属性</span>
                                        </li>
                                        <li>
                                            <strong>服务器接口地址：</strong>
                                            <input type="text" class="text_input" name="host" placeholder='' value="<?php echo $list["host"];?>"  ignore="ignore" /><span class="Validform_checktip">服务器接口地址</span>
                                        </li>
                                        <li>
                                            <strong>品牌：</strong>
                                            <input type="text" class="text_input" name="brand" placeholder='' value="<?php echo $list["brand"];?>"  ignore="ignore" /><span class="Validform_checktip">品牌</span>
                                        </li>
                                        <li>
                                            <strong>技能：</strong>
                                            <input type="text" class="text_input" name="skill" placeholder='' value="<?php echo $list["skill"];?>"  ignore="ignore" /><span class="Validform_checktip">技能</span>
                                        </li>
                                    </ul>
                                    <div class="input1">
                                        <input type="submit" class="button_search "  id="btn_sub" value="提交" />
                                    </div>
                                </dd>
                            </form>
                        </dl>
                    </div>
            </dd>
        </dl>
    </div>
    <?php include $this->admin_tpl('copyright') ?>