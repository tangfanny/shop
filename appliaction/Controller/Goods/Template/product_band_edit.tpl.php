<?php include $this->admin_tpl("header"); ?>
    <!-- 内容区 -->
    <div class="content">
        <div id="top-alert" class="fixed alert alert-error" style="display: none;">
            <button class="close fixed" style="margin-top: 4px;">&times;</button>
            <div class="alert-content">这是内容</div>
        </div>
        <div class="site">
             <a href="#">商品管理</a> > 品牌列表 > 编辑品牌
        </div>
        <span class="line_white"></span>
    <div class="install mt10">
        <dl>
            <dd>
                <div class="install mt10">
                    <div class="install mt10">
                        <dl>
                            <form action="<?php echo U('ProductBand/edit'); ?>" class="addform" method="post">
                                <dd>
                                    <ul class="web">
                                        <li>
                                            <strong>名称：</strong>
                                            <input type="text" class="text_input" name="name" placeholder='' datatype="*" value="<?php echo $info['name'];?>" /><span class="Validform_checktip ">设置商品品牌名称</span>
                                        </li>
                                        <li>
                                            <strong>网址：</strong>
                                            <input type="text" class="text_input" name="url" placeholder='' datatype="url" ignore="ignore" value="<?php echo $info['url'];?>" /><span class="Validform_checktip">设置品牌链接，请填写http://</span>
                                        </li>
                                        <li style="line-height:24px;">
				                            <strong>LOGO：</strong>
                                            <input type="file" class="am-hide" id="pickfiles" >
                                            <input type="hidden" id='chengxing' name="logo" value="<?php echo $info['logo'];?>">
                                            <div id="container">
                                            </div>
                                            <div>
                                                <?php if(is_numeric($info['logo']) && strlen($info['logo'])==18):?>
                                                    <img  src="<?php echo IMG_URL.Img_ADDRESS.$info['logo'].'?imageView2/2/w/200 ';?>" id="imgpreview"/>
                                                <?php elseif(empty($info['logo'])): ?>
                                                    <img src="" id="imgpreview" alt="">
                                                <?php else: ?>
                                                    <img  src="<?php echo IMG_URL.$info['logo'].'?imageView2/2/w/200' ;?>" id="imgpreview"/>
                                                <?php endif;?>

                                            </div>
				                        </li>
                                        <li>
                                            <strong>推荐：</strong>
                                            <input type="radio" name="isrecommend" value="1" <?php if ($info['isrecommend'] == 1): ?>checked="checked"<?php endif ?>/>是 <input type="radio" name="isrecommend" value="0" <?php if ($info['isrecommend'] == 0): ?>checked="checked"<?php endif ?>/>否<span class="Validform_checktip"  style="margin-left:253px;">是否在前台推荐该品牌</span>
                                        </li>
                                        <li>
                                            <strong>状态：</strong>
                                            <input type="radio" name="status" value="1" <?php if ($info['status'] == 1): ?> checked="checked"<?php endif ?> />显示 
                                            <input type="radio" name="status" value="0" <?php if ($info['status'] == 0): ?> checked="checked"<?php endif ?> />禁用
                                            <span class="Validform_checktip"  style="margin-left:225px;">设置品牌是否显示，默认为显示</span>
                                        </li>
                                        <li>
                                            <strong>排序：</strong>
                                            <input type="text" class="text_input" name="sort" placeholder=''  datatype="n" value="<?php echo $info['sort'];?>"/><span class="Validform_checktip" >输入数字显示排序，数字越小越靠前数字越大越靠后</span>
                                        </li>
                                        <li>
                                            <strong>描述：</strong>
                                            <textarea name="descript" rows="4" cols="20" style="margin-right: 50px;"><?php echo $info['descript'];?></textarea>
                                            <span class="Validform_checktip" style="margin-left:4px;">请填写品牌描述，品牌描述可显示在前台品牌专区页面</span>
                                        </li>
                                    </ul>
                                    <div class="submit">
                                        <input type="hidden" name="id" value="<?php echo $info['id'] ?>" />
                                         <input type="submit" class='button_search' value='提交'/>
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
<!--编辑器开始-->
<script type="text/javascript" src="<?php echo __QINIU__;?>plupload/js/plupload.full.min.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>plupload/js/i18n/zh_CN.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>ui.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>qiniu.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>highlight.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>main-upload.js"></script>
<script>
    $(function() {
		//表单验证
        var demo = $(".addform").Validform({
            btnSubmit: "#btn_sub",
            btnReset: ".btn_reset",
            tiptype: 3,
            label: ".label",
            showAllError: false,
            ajaxPost: true,
            callback: function(data) {
                $("#Validform_msg").hide();
                if (data.status == "0") {
                    art.dialog({width: 320, time: 5, title: '温馨提示(5秒后关闭)', content: data.info, ok: true});
                }
                if (data.status == "1") {
                    window.location.href = '<?php echo U('lists') ?>';
                }
            },
            tiptype:function(msg,o,cssctl){
            }
        });
    });
</script>
</body>
</html>
