<?php include $this->admin_tpl("header"); ?>
    <!-- 内容区 -->
    <div class="content">
        <div id="top-alert" class="fixed alert alert-error" style="display: none;">
            <button class="close fixed" style="margin-top: 4px;">&times;</button>
            <div class="alert-content">这是内容</div>
        </div>
        <div class="site">
             <a href="#">商品管理</a> > 品牌列表 > 添加品牌
        </div>
        <span class="line_white"></span>
    <div class="install mt10">
        <dl>
            <dd>
                <div class="install mt10">
                    <div class="install mt10">
                        <dl>
                            <form action="<?php echo U('Product_band/add');?>" class="addform" method="post">
                                <dd>
                                    <ul class="web">
                                        <li>
                                            <strong>品牌名称：</strong>
                                            <input type="text" class="text_input" name="name" placeholder='' datatype="*"/><span class="Validform_checktip ">设置商品品牌名称
                                            </span>
                                        </li>
                                        <li>
                                            <strong>网址：</strong>
                                            <input type="text" class="text_input" name="url" placeholder='' datatype="url"  /><span class="Validform_checktip">设置品牌链接，请填写http://</span>
                                        </li>
                                        <li style="line-height:24px;">
				                            <strong>LOGO：</strong>
                                            <input type="file" class="am-hide" id="pickfiles" >
                                            <input type="hidden" id='chengxing' name="logo">
                                            <div id="container">
                                            </div>
                                            <div>
                                                <img src="" id="imgpreview" alt="">
                                            </div>
				                        </li>
                                        <li>
                                            <strong>推荐：</strong>
                                            <input type="radio" name="isrecommend" value="1" />是 <input type="radio" name="isrecommend" value="0" checked="checked"/>否<span class="Validform_checktip"  style="margin-left:253px;">是否在前台推荐该品牌</span>
                                        </li>
                                        <li>
                                            <strong>状态：</strong>
                                            <input type="radio" name="status" value="1" checked="checked" />显示 <input type="radio" name="status" value="0" />禁用<span class="Validform_checktip"  style="margin-left:229px;">设置品牌是否显示，默认为显示</span>
                                        </li>                                       
                                        <!--<li>
                                            <strong>推荐：</strong>
                                            <input type="radio" name="pushstatus" value="1" />是 <input type="radio" name="pushstatus" value="0" checked="checked" />否<span class="Validform_checktip"  style="margin-left:250px;">默认为不推荐</span>
                                        </li>-->
                                        <li>
                                            <strong>排序：</strong>
                                            <input type="text" class="text_input" name="sort" placeholder=''  datatype="n" value="100" /><span class="Validform_checktip">输入数字显示排序，数字越小越靠前数字越大越靠后</span>
                                        </li>
                                        <li>
                                            <strong>描述：</strong>
                                            <textarea name="descript" rows="4" cols="20" style="margin-right: 50px;"></textarea>
                                            <span class="Validform_checktip" style="margin-left:4px;">请填写品牌描述，品牌描述可显示在前台品牌专区页面</span>
                                        </li>
                                    </ul>
                                    <div class="submit">
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
    <?php include $this->admin_tpl("copyright"); ?>
</div>
<!-- /内容区 -->
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