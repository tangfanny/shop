<?php include $this->admin_tpl("header"); ?>
<div class="content">
    <style>
        #Validform_msg{display: none}
    </style>
    <div id="top-alert" class="fixed alert alert-error" style="display: none;">
        <button class="close fixed" style="margin-top: 4px;">&times;</button>
        <div class="alert-content">这是内容</div>
    </div>
    <div class="site">
          <a href="#">商品管理</a> > 分类列表 > 编辑分类
    </div>
    <span class="line_white"></span>
    <div class="install mt10">
        <dl>
             <dd>
                <div class="install mt10">
                    <div class="install mt10">
                        <dl>
                            <form action="<?php echo U('SafetyAdvisor/auth')?>" class="addform" method="post">
                                <dd>
                                    <ul class="web">
                                        <li>
                                            <strong>手机号：</strong>
                                            <span></span>
                                            <span><?php echo $data['mobile'];?></span>
                                        </li>
                                        <li>
                                            <strong>用户昵称：</strong>
                                            <span></span>
                                            <span><?php echo $data['nikename'];?></span>
                                        </li>
                                        <li>
                                            <strong>注册时间：</strong>
                                            <span></span>
                                            <span><?php echo $data['createtime'];?></span>
                                        </li>
                                        <li>
                                            <strong>真实姓名：</strong>
                                            <span></span>
                                            <span><?php echo $data['name'];?></span>
                                        </li> 
                                         <li>
                                            <strong>所在城市：</strong>
                                            <span></span>
                                            <span><?php echo $data['city'];?></span>
                                        </li> 
                                        <li>
                                            <strong>擅长品类：</strong>
                                            <span></span>
                                            <span><?php echo $data['category'];?></span>
                                        </li> 
                                        <li>
                                            <strong>擅长品牌：</strong>
                                            <span></span>
                                            <span><?php echo $data['brand'];?></span>
                                        </li>
                                        <li>
                                            <strong>荣誉证书：</strong>
                                            <span></span>
                                            <div style="padding-left: 100px;">
                                            <?php
                                                foreach($data['certificate'] as $img) {
                                            ?>
<!--                                            <p style="padding-bottom: 10px"><img src="--><?php //echo $img;?><!--" /></p>-->
                                                    <?php if(is_numeric($img) && strlen($img==18)):?>
                                                        <img  src="<?php echo IMG_URL.Img_ADDRESS.$img.'?imageView2/2/w/200 ';?>" />
                                                    <?php elseif(empty($img)): ?>
                                                    <?php else: ?>
                                                        <img  src="<?php echo IMG_URL.$img.'?imageView2/2/w/200' ;?>" />
                                                    <?php endif;?>
                                            <?php }?>

                                            </div>
                                        </li>
                                        <li>
                                            <strong>审核时间：</strong>
                                            <span></span>
                                            <span><?php echo $data['authtime'];?></span>
                                        </li>
                                        <li>
                                            <strong>审核状态：</strong>
                                            <span></span>
                                            <span>
                                            <select name="auth_status" style="margin-right: 96px;">
                                                <option value="0" <?php if($data['auth_status'] == 0) echo "selected";?>>审核中</option>
                                                <option value="1" <?php if($data['auth_status'] == 1) echo "selected";?>>审核通过</option>
                                                <option value="2" <?php if($data['auth_status'] == 2) echo "selected";?>>驳回</option>
                                            </select>
                                            </span>
                                        </li>
                                        <li>
                                            <strong>驳回理由：</strong>
                                            <span></span>
                                            <span>
                                            <textarea name="message" rows="4" cols="20"><?php echo $data['auth_message'] ?></textarea>
                                            </span>
                                        </li>
                                    </ul>
                                    <div class="submit">
                                        <input type="hidden" name="id" value="<?php echo $data['id'] ?>" />
                                        <input type="submit" class="button_search" value="保存"/>
                                        <a href="<?php echo U('index')?>">返回</a>
                                    </div>
                                </dd>
                            </form>  
                        </dl>
                    </div>
            </dd>
        </dl>
    </div>
</div>
<script>
    $(function() {

        /*
        var demo = $(".addform").Validform({
            btnSubmit: "#btn_sub",
            btnReset: ".btn_reset",
            tiptype: function(){},
            label: ".label",
            showAllError: false,
            ajaxPost: true,
            callback: function(data) {
                $("#Validform_msg").hide();
                if (data.status == "0") {
                    art.dialog({width: 320, time: 5, title: '温馨提示(5秒后关闭)', content: data.info, ok: true});
                }
                if (data.status == "1") {
                    window.location.href = data.url;
                }
            }
        });
        */
    });
</script>
</body>
</html>