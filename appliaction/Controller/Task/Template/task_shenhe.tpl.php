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
        <a href="<?php echo U('Task/lists');?>">众测管理</a> >
        <a href="<?php echo U('Task/lists');?>">众测审核</a>
    </div>
    <span class="line_white"></span>
    <div class="install mt10">
        <dl>
            <dd>
                <div class="install mt10">
                    <div class="install mt10">
                        <dl>
                            <form action="<?php echo U('Task/shenhe');?>" method="post">
            <dd>
                <ul class="web">
                    <li>
                        <div class="c1">logo：</div>
                        <span>
                            <?php if(is_numeric($info['company_pic']) && strlen($info['company_pic'])==18):?>
                                <img  src="<?php echo IMG_URL.Img_ADDRESS.$info['company_pic'].'?imageView2/2/w/200 ';?>"/>
                            <?php elseif(empty($info['company_pic'])): ?>
                            <?php else: ?>
                                <img  src="<?php echo IMG_URL.$info['company_pic'].'?imageView2/2/w/200' ;?>"/>
                            <?php endif;?>
                           </span>
                    </li>
                    <li>
                        <div class="c1">微信图片：</div>
                        <span>
                            <?php if(is_numeric($info['wechat_pic']) && strlen($info['wechat_pic'])==18):?>
                                <img  src="<?php echo IMG_URL.Img_ADDRESS.$info['wechat_pic'].'?imageView2/2/w/200 ';?>"/>
                            <?php elseif(empty($info['wechat_pic'])): ?>
                            <?php else: ?>
                                <img  src="<?php echo IMG_URL.$info['wechat_pic'].'?imageView2/2/w/200' ;?>"/>
                            <?php endif;?>
                           </span>
                    </li>
                    <li>
                        <div class="c1">App图片：</div>
                        <span>
                            <?php if(is_numeric($info['app_pic']) && strlen($info['app_pic'])==18):?>
                                <img  src="<?php echo IMG_URL.Img_ADDRESS.$info['app_pic'].'?imageView2/2/w/200 ';?>"/>
                            <?php elseif(empty($info['app_pic'])): ?>
                            <?php else: ?>
                                <img  src="<?php echo IMG_URL.$info['app_pic'].'?imageView2/2/w/200' ;?>"/>
                            <?php endif;?>
                           </span>
                    </li>
                    <li>
                        <div class="c1">网页图片：</div>
                        <span>
                            <?php if(is_numeric($info['web_pic']) && strlen($info['web_pic'])==18):?>
                                <img  src="<?php echo IMG_URL.Img_ADDRESS.$info['web_pic'].'?imageView2/2/w/200 ';?>"/>
                            <?php elseif(empty($info['web_pic'])): ?>
                            <?php else: ?>
                                <img  src="<?php echo IMG_URL.$info['web_pic'].'?imageView2/2/w/200' ;?>"/>
                            <?php endif;?>
                            </span>
                    </li>
                    <li>
                        <div class="c1">众测id：</div><span><?php echo $info['task_id']; ?></span>
                    </li>
                    <li>
                        <div class="c1">标题：</div><span><?php echo $info['title']; ?></span>
                    </li>
                    <li>
                        <div class="c1">悬赏金额：</div><span><?php echo $info['sec_price']; ?></span>
                    </li>
                    <li>
                        <div class="c1">浏览人数：</div><span><?php echo $info['hits']; ?></span>
                    </li>
                    <li>
                        <div class="c1">参与人数：</div><span><?php echo $info['enroll_num']; ?></span>
                    </li>
                    <li>
                        <div class="c1">支持人数：</div><span><?php echo $info['follow_numbers']; ?></span>
                    </li>
                    <li>
                        <div class="c1">项目周期：</div><span><?php echo  isset($info["start_time"])?date('Y-m-d H:i:s', $info["start_time"]):date('Y-m-d H:i:s',NOW_TIME)?></span><span style="color:#000;">至</span><span><?php echo date("Y年m月d日 H:i:s",$info['end_time']); ?></span>
                    </li>
                    <li>
                        <div class="c1">创建时间：</div><span><?php echo  isset($info["create_time"])?date('Y-m-d H:i:s', $info["create_time"]):date('Y-m-d H:i:s',NOW_TIME)?></span>
                    </li>
                    <li>
                        <div class="c1">创建用户id：</div><span><?php echo $info['create_user_id']; ?></span>
                    </li>
                    <li>
                        <div class="c1">是否公开：</div><span>
                            <?php
                            if ($info['isopen']==0) {
                                echo " 公开";
                            }else{
                                echo "私密";
                            }
                            ?></span>
                    </li>
                    <li>
                        <div class="c1">自动报名：</div><span>
                            <?php
                            if ($info['isautobm']==0) {
                                echo " 自动";
                            }else{
                                echo "手动";
                            }
                            ?></span>
                    </li>
                    <li>
                        <div class="c1">报名方式：</div><span>
                            <?php
                            if ($info['sign_type']==1) {
                                echo " 自动报名";
                            }elseif($info['sign_type']==2){
                                echo "审核报名";
                            }elseif($info['sign_type']==3){
                                echo "需要实名认证";
                            }
                            ?></span>
                    </li>
                    <li>
                        <div class="c1">审核状态：</div><span>
                            <?php
                            if ($info['pub_status']==0) {
                                echo " 未通过";
                            }elseif($info['pub_status']==1){
                                echo "审核通过";
                            }elseif($info['pub_status']==2){
                                echo "驳回";
                            }elseif($info['pub_status']==7){
                                echo "已完成";
                            }elseif($info['pub_status']==8){
                                echo "己取消";
                            }elseif($info['pub_status']==9){
                                echo "己过期";
                            }
                            ?></span>
                    </li>
                    <li>
                        <div class="c1">实物奖励：</div><span><?php echo $info['shiwujianli']; ?></span>
                    </li>
                    <li>
                        <div class="c1">奖励说明：</div><span><?php echo $info['description']; ?></span>
                    </li>
                    <li>
                        <div class="c1">注意事项：</div><span><?php echo $info['notes']; ?></span>
                    </li>
                    <li>
                        <div class="c1">需求描述：</div><span><?php echo $info['content']; ?></span>
                    <li>
                        <div class="c1">授权人手机：</div><span><?php echo $info['accre_tel']; ?></span>
                    </li>
                    <li>
                        <div class="c1">授权状态：</div><span> <?php
                            if ($info['accre_type']==0) {
                                echo " 未授权";
                            }elseif($info['accre_type']==1){
                                echo "已授权";
                            }
                            ?></span>
                    </li>
                    <li>
                        <div class="c1">授权书：</div><span>
                            <?php if(is_numeric($info['doc']) && strlen($info['doc'])==18):?>
                                <img  src="<?php echo IMG_URL.Img_ADDRESS.$info['doc'].'?imageView2/2/w/200 ';?>"/>
                            <?php elseif(empty($info['doc'])): ?>
                            <?php else: ?>
                                <img  src="<?php echo IMG_URL.$info['doc'].'?imageView2/2/w/200' ;?>"/>
                            <?php endif;?></span>
                    </li>
                    <li>
                        <?php if ($info['accre_type']  == 0 ): ?>
                        <?php else: ?>
                        <div class="c1">评级（必选）：</div>
                        <div>
                            <select class="form-control" name="start_level" required >
                                <option value="" selected="selected">请选择星级</option>
                                <option value="1" <?php if($info['start_level'] == 1){echo 'selected';}?>>★</option>
                                <option value="2" <?php if($info['start_level'] == 2){echo 'selected';}?>>★★</option>
                                <option value="3" <?php if($info['start_level'] == 3){echo 'selected';}?>>★★★</option>
                                <option value="4" <?php if($info['start_level'] == 4){echo 'selected';}?>>★★★★</option>
                                <option value="5" <?php if($info['start_level'] == 5){echo 'selected';}?>>★★★★★</option>
                            </select>
                        </div>
                        <?php endif;?>
                    </li>
                    <li>
                        <?php if ($info['accre_type']  == 0 ): ?>
                        <?php else: ?>
                        <div class="c1">审核：</div>
                        <div>
                            <select class="form-control" name="pub_status" id="pub_status" required>
                                <option value="" selected>请选择状态</option>
                                <option value="0" <?php if($info['pub_status'] == 0){echo 'selected';}?>>未通过</option>
                                <option value="1" <?php if($info['pub_status'] == 1){echo 'selected';}?>>审核通过</option>
                                <option value="2" <?php if($info['pub_status'] == 2){echo 'selected';}?>>驳回</option>
                                <option value="7" <?php if($info['pub_status'] == 7){echo 'selected';}?>>已完成</option>
                                <option value="8" <?php if($info['pub_status'] == 8){echo 'selected';}?>>已取消</option>
                                <option value="9" <?php if($info['pub_status'] == 9){echo 'selected';}?>>已过期</option>
                            </select>
                        </div>
                        <?php endif;?>
                    </li>
                    <li>
                        <?php if ($info['accre_type']  == 0 ): ?>
                        <?php else: ?>
                        <div class="c1">驳回原因：</div><textarea rows="8" cols="97" class="form-control" id="refusal" name="refusal" style="border-radius: 4px;width: 400px;"><?php echo $info['refusal']; ?></textarea><span>若选择驳回请填写驳回原因</span>
                        <?php endif;?>
                    </li>
                    <li>
                        <input type="hidden" name="task_id" value="<?php echo $info['task_id']; ?>">
                    </li>
                    <li>
                        <input type="hidden" name="uid" value="<?php echo $info['create_user_id']; ?>">
                    </li>
                    <li>
                        <input type="hidden" name="title" value="<?php echo $info['title']; ?>">
                    </li>
                    <li>
                        <?php if ($info['accre_type']  == 0 ): ?>
                        <?php endif;?>
                        <input type='submit' value='众测审核' id="post_submit" class='btn btn-block btn-primary'>
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
<script type="text/javascript">
    $("#post_submit").click(function(){
        var status = $("#pub_status option:selected").val();
        var refusal = $("#refusal").val();
        if (status == 2) {
            if (refusal == '') {
                alert("若选择驳回请填写驳回原因！");
                return false;
            }
        }else{
            $("#refusal").html("");
        }
        if(status == 0){
            alert("请选择状态！");
            return false;
        }
    });
</script>
