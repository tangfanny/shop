<?php  include $this->admin_tpl('header'); ?>
<block name="style">
    <style>
        #Validform_msg{display: none}
    </style>
</block>
<div class="content">
<block name="site">
    <div class="site">
         <a href="#">站点设置</a> > 注册与登录设置
    </div>
    <span class="line_white"></span>
</block>
<block name="body">
    <div class="install mt10">
        <dl>
            <dd>
                <form name="form" method="post" action="<?php echo U('Site/insert?ct=reg') ?>">
                    <ul class="web">
                        <li>
                            <strong>允许新会员注册设置：</strong>
                            <b>
                                <label><input type="radio" name="reg_isreg" id="RadioGroup1_0" value="1"
                                 <?php if (C('reg_isreg') == 1) { ?> checked    <?php } ?> /> 允许 </label>
                                <label><input type="radio" name="reg_isreg" id="RadioGroup1_1" value="0" <?php if (C('reg_isreg') == 0) { ?> checked    <?php } ?> /> 关闭 </label>
                            </b>
                            <span style="margin-left:-1px">设置是否允许新会员注册，默认为允许 </span>
                        </li>
                        <li>
                            <strong>商城注册文件名：</strong>
                            <input type="text" value="<?php echo C('reg_regfile') ?>" class="text_input" name="reg_regfile" /><span style="margin-left:2px">设置商城注册页的文件名，默认为“register.php”，如果您更改了此设置，需要您手动重命名文件名称</span>
                        </li>
                        <li>
                            <strong>注册链接文字：</strong>
                            <input type="text" value="<?php echo C('reg_regtext') ?>" class="text_input" name="reg_regtext" /><span style="margin-left:2px">您可以对商城注册页的链接文字进行重命名，如：成为会员，默认为注册，</span>
                        </li>
                        <!--<li>
                            <strong>新用户注册验证：</strong>
                            <select name="reg_regvalidation" style="margin-right: 50px;">
                                <option value="0" 
                                 <?php if (C('reg_regvalidation') == 0) { ?> selected    <?php } ?>>无需验证</option>
                                <option value="1" 
                                < <?php if (C('reg_regvalidation') == 1) { ?> selected    <?php } ?>>手机验证</option>
                            </select><span>选择“无需验证”用户可直接注册成功；选择“Email 验证”将向用户填写的Email发送一封验证邮件以确认邮箱的有效性</span>
                        </li>-->
                        <li>
                            <strong>网站服务条款：</strong>
                            <textarea name="reg_terms"><?php echo C('reg_terms') ?></textarea>
                            <p>您可以在这里编辑网站服务条款的详细内容</p>
                        </li>
                    </ul>
                    <div class="input1">
                        <input type="submit" value="提交" class="button_search">
                    </div>
                    <input type="hidden" name="files" value="reg.php" />
                </form>
            </dd>
        </dl>
    </div>
</block>
<block name="script">
</block>
<?php include $this->admin_tpl('copyright') ?>