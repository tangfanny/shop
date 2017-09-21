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
            <a href="#">会员管理</a> > <a href="<?php echo U('lists');?>">会员审核</a>
        </div>
        <span class="line_white"></span>
    <div class="install mt10">
        <dl>
             <dd>
                <div class="install mt10">
                    <div class="install mt10">
                        <dl>
                            <form action="<?php echo U('edit')?>" class="addform" method="post">
                                <dd>
                                    <ul class="web">
                                        <li>
                                            <strong><?php echo $info["sale_key_name"]?>：</strong>
                                            <input type="text" class="text_input" name="sale_key_value" value="<?php echo $info['sale_key_value'] ?>" placeholder='' datatype="*"/><span style="padding-left: 52px;" class="Validform_checktip ">推荐注册会员个数</span>
                                        </li> 
                                         <li>
                                            <strong><?php echo $info["rebate_mode"]?>：</strong>
                                            <input type="text" class="text_input" name="rank" value="<?php echo $info['rank'] ?>" placeholder='' datatype="*"/><span style="padding-left: 52px;" class="Validform_checktip ">奖励对应的积分</span>
                                        </li> 
                                    </ul>
                                    <div class="submit">
                                        <input type="hidden" name="id" value="<?php echo $info['id'] ?>" />
                                        <input type="submit" class="button_search" value="提交"/>
										<a href="<?php echo U('lists')?>">返回</a>
                                    </div>
                                </dd>
                            </form>  
                        </dl>
                    </div>
            </dd>
        </dl>
    </div>
</div>
</body>
</html>