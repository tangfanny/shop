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
                            <form action="<?php echo U('verifysava');?>" method="post">
                                <input type="hidden" value="<?php echo $id;?>" name="id" />
                                <input type="hidden" value="<?php echo $is_whitehat_auth;?>" name="is_whitehat_auth" />
                                <input type="hidden" value="<?php echo $is_company_auth;?>" name="is_company_auth" />
                                <input type="hidden" value="<?php echo $is_saler_auth;?>" name="is_saler_auth" /> 
                                 <input type="hidden" value="<?php echo $info["mobile"];?>" name="mobile" /> 
                                <dd>
                                    <ul class="web">
                                        <li>
                                            <div class="c1">用户邮箱/手机：</div><span><?php echo $info['login']; ?></span>
                                        </li>
                                        <li>
                                            <div class="c1">用户昵称：</div><span><?php echo $info['nikename']; ?></span>
                                        </li>
                                        <li>
                                            <div class="c1">注册时间：</div><span><?php echo date("Y-m-d H:i:s",$info['acreate_time']); ?></span>
                                        </li>
                                        <li>
                                            <div class="c1">企业名称：</div><span><?php echo $info['company']; ?></span>
                                        </li>
                                        <li>
                                            <div class="c1">企业联系人：</div><span><?php echo $info['linkman']; ?></span>
                                        </li>
                                        <li>
                                            <div class="c1">联系电话：</div><span><?php echo $info['tel']; ?></span>
                                        </li>
                                        <li>
                                            <div class="c1">营业执照：</div><span><?php echo $info['business_license']; ?></span>
                                        </li>
                                        <li>
                                            <div class="c1">组织代码证：</div><span><?php echo $info['organization_code']; ?></span>
                                        </li>
                                        <li>
                                            <div class="c1">创建时间：</div><span><?php echo  date("Y-m-d H:i:s",$info['create_time']); ?></span>
                                        </li>
                                        <li>
                                            <div class="c1">审核时间：</div>
                                            <span>
                                                <?php if($info['check_time']==null):?> 
                                                    未审核
                                                <?php else:?>
                                                    <?php echo date("Y-m-d H:i:s", $info["check_time"]); ?></span>
                                                <?php endif;?>
                                                
                                        </li>
                                        <li>
                                                <div class="c1">审核状态：</div>
                                                <span>
                                                   <?php if($info['status'] == 1):?>
                                                    <?php echo "审核中"; ?>
                                                    <?php endif;?>
                                                 <?php if($info['status'] == 2):?>
                                                    <?php echo "审核通过"; ?>
                                                    <?php endif;?>  
                                                  <?php if($info['status'] == 3):?>
                                                    <?php echo "审核驳回"; ?>
                                                    <?php endif;?>     
                                                </span>
                                        </li>
                                        <li>
                                            <div class="c1">营业执照扫描件：</div>
                                            <span><?php if(is_numeric($info['business_license_image']) && strlen($info['business_license_image'])==18):?>
                                                    <img  src="<?php echo IMG_URL.Img_ADDRESS.$info['business_license_image'].'?imageView2/2/w/200 ';?>">
                                                <?php elseif(empty($info['business_license_image'])): ?>
                                                <?php else: ?>
                                                    <img  src="<?php echo IMG_URL.$info['business_license_image'].'?imageView2/2/w/200' ;?>">
                                                <?php endif;?></span>
                                        </li>
                                        <li>
                                            <select name="status" id="status" class="ns-select" onChange="javascript:c(this);">
                                                <option value="1" <?php if ($info['status'] == 1): ?>selected<?php endif ?>>审核中</option>
                                                <option value="2" <?php if ($info['status'] == 2): ?>selected<?php endif ?>>审核通过</option>
                                                <option value="3" <?php if ($info['status'] == 3): ?>selected<?php endif ?>>审核驳回</option>
                                            </select>
                                            <span id="prompt">选择一项审核状态</span>
                                        </li>
                                        <li>
                                        <textarea name="refusal" style="margin-right: 8px;width:248px"  id="refusal"><?php echo $info["auth_refuse"];?></textarea>
                                            <span>若选择驳回请填写驳回原因</span>
                                        </li>
                                        <li class="submit">
                                            <?php if($info['status'] == 1):?>
                                            <input type="submit" id="post_submit" class='button_search' value='提交'/>
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
</body>
</html>
