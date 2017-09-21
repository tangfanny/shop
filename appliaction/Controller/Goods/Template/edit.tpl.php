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
                            <form action="<?php echo U('goods/ServiceGoods/update') ?>" class="addform" method="post">
                                <dd>
                                    <ul class="web">
                                        <li>
                                            <strong>认证会员名：</strong>
                                            <span></span>
                                            <span><?php echo htmlspecialchars($data['name']); ?></span>
                                        </li>
                                        <li>
                                            <strong>认证手机号：</strong>
                                            <span></span>
                                            <span><?php echo htmlspecialchars($data['mobile']); ?></span>
                                        </li>
                                        <li>
                                            <strong>注册时间：</strong>
                                            <span></span>
                                            <span><?php echo htmlspecialchars($data['createtime']); ?></span>
                                        </li>
                                        <li>
                                            <strong>服务标题：</strong>
                                            <span></span>
                                            <span><input type="text" class="text_input" name="title" value="<?php echo htmlspecialchars($data['title']); ?>" placeholder='' datatype="*"/></span>
                                        </li> 
                                        <li>
                                            <strong>服务费用（天）：</strong>
                                            <span></span>
                                            <span><input type="text" class="text_input" name="price" value="<?php echo htmlspecialchars($data['price']); ?>" placeholder='' datatype="*"/></span>
                                        </li> 
                                        <li>
                                            <strong>擅长技能：</strong>
                                            <span></span>
                                            <span>

<!--                                                <select name="skill_array[]" multiple="multiple" size="4">-->

                                                <?php
                                                foreach ($skill_array as $cs) {
                                                    $sel = "";
                                                    foreach ($data['category'] as $o_cate) {
                                                        if ($o_cate['type'] == '1' && $o_cate['id'] == $cs['id']) {
                                                            $sel = "checked='checked'";
                                                        }
                                                    }
//                                                    echo "<option value='{$cs['id']}' {$sel} >{$cs['name']}</option>";
                                                    echo "<input name='category[]' {$sel} type='checkbox' value='{$cs['id']}' />{$cs['name']}</br>";
                                                }
                                                ?>
                                                <!--                                                </select>-->
                                            </span>
                                        </li> 
                                        <li>
                                            <strong>擅长品牌：</strong>
                                            <span></span>
                                            <span>
<!--                                                <select name="brand[]" multiple="multiple" size="4">-->
                                                <?php
                                                foreach ($brand_array as $bs) {
                                                    $sel = "";
                                                    foreach ($data['brand'] as $o_cate) {
                                                        if ($o_cate['type'] == '2' && $o_cate['id'] == $bs['id']) {
                                                            $sel = "checked='checked'";
                                                        }
                                                    }
                                                    echo "<input name='skill_array[]' type='checkbox' {$sel} value='{$bs['id']}' />{$bs['name']}</br>";
                                                }
                                                ?>
                                                <!--</select>-->
                                            </span>
                                        </li>
                                        <li>
                                            <strong>经验：</strong>
                                            <span></span>
                                            <span><input type="text" class="text_input" name="work_year" value="<?php echo htmlspecialchars($data['work_year']); ?>" placeholder='' datatype="*"/>年</span>
                                        </li>
                                        <li>
                                            <strong>描述：</strong>
                                            <span></span>
                                            <span><input type="text" class="text_input" name="brief_desc" value="<?php echo htmlspecialchars($data['brief_desc']) ?>" placeholder='' datatype="*"/></span>
                                        </li>
                                          <li>
                                            <strong>简介：</strong>
                                            <span></span>
                                            <span><input type="text" class="text_input" name="detail_desc" value="<?php echo htmlspecialchars($data['detail_desc']) ?>" placeholder='' datatype="*"/></span>
                                        </li>
                                        <li>
                                            <strong>荣誉证书：</strong>
                                            <span></span>
                                            <div style="padding-left: 100px;">
                                                <?php
                                                foreach ($data['certificate'] as $img) {
                                                ?>
                                                <?php if(is_numeric($img['certificate']) && strlen($img['certificate'])==18):?>
                                                    <img  src="<?php echo IMG_URL.Img_ADDRESS.$img['certificate'].'?imageView2/2/w/200 ';?>" id="imgpreview"/>
                                                <?php elseif(empty($img['certificate'])): ?>
                                                <?php else: ?>
                                                    <img  src="<?php echo IMG_URL.$img['certificate'].'?imageView2/2/w/200' ;?>" id="imgpreview"/>
                                                <?php endif;?>
                                                <?php } ?>
                                            </div>
                                        </li>
                                        <li>
                                            <strong>是否上架：</strong>
                                            <span></span>
                                            <span>
                                                <label><input type="radio" name="status" value="1" <?php echo $data['goods_status'] ? "checked" : ""; ?>/> 是 </label>&nbsp;&nbsp;
                                                <label><input type="radio" name="status" value="0" <?php echo !$data['goods_status'] ? "checked" : ""; ?>/> 否 </label>
                                            </span>
                                        </li>
                                    </ul>
                                    <div class="submit">
                                        <input type="hidden" name="id" value="<?php echo $data['id'] ?>" />
                                        <input type="submit" class="button_search" value="保存"/>
                                        <a href="<?php echo U('index') ?>">返回</a>
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