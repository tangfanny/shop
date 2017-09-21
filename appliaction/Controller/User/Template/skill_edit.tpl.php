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
        <a href="#">会员管理</a> > 技能列表 > 编辑技能
    </div>
    <span class="line_white"></span>
    <div class="install mt10">
        <dl>
            <dd>
                <div class="install mt10">
                    <div class="install mt10">
                        <dl>
                            <form action="<?php echo U('Skill/edit')?>" class="addform" method="post">
            <dd>
                <ul class="web">
                    <li>
                        <strong>名称：</strong>
                        <input type="text" class="text_input" name="name" value="<?php echo $data['name'] ?>" placeholder='' datatype="*"/><span style="padding-left: 52px;" class="Validform_checktip ">请填写技能名称</span>
                    </li>

                    <li>
                        <strong>APP名称：</strong>
                        <input type="text" class="text_input" name="app_name" value="<?php echo $data['app_name'] ?>" placeholder='' /><span style="padding-left: 52px;" class="Validform_checktip ">请填写APP名称</span>
                    </li>
                    <li>
                        <strong>App图片：</strong>
                        <input type="file" class="am-hide" id="pickfiles" >
                        <input type="hidden" id='chengxing' name="app_img">
                        <div id="container">
                        </div>
                        <div>
                            <?php if(is_numeric($data['app_img']) && strlen($data['app_img'])==18):?>
                                <img  src="<?php echo IMG_URL.Img_ADDRESS.$data['app_img'].'?imageView2/2/w/200 ';?>" id="imgpreview"/>
                            <?php elseif(empty($data['app_img'])): ?>
                                <img src="" id="imgpreview" alt="">
                            <?php else: ?>
                                <img  src="<?php echo IMG_URL.$data['app_img'].'?imageView2/2/w/200' ;?>" id="imgpreview"/>
                            <?php endif;?>
                        </div>
                    </li>
                    <li>
                        <strong>Appurl：</strong>
                        <input type="text" class="text_input" name="app_url" value="<?php echo $data['app_url'] ?>" placeholder='' />
                        <span style="padding-left: 52px;" class="Validform_checktip ">请输入地址</span>
                    </li>
                    <li>
                        <strong>App分类名称：</strong>
                        <select name="app_category" style="margin-right: 43px;">
                            <option value="<?php echo $data['app_category'] ?>"><?php echo $data['app_category'] ?></option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="99">99</option>
                        </select>
                        <span style="padding-left: 52px;" class="Validform_checktip ">请输入App技能名称（0:空；1:广告页；2:页面；3:专题页面；4:资讯页面；5:众测页面；99:技能；）</span>
                    </li>
                    <li>

                        <strong>顶级技能：</strong>
                        <select name="parent_id" style="margin-right: 96px;">
                            <option value="0">请选择</option>
                            <?php foreach ($tree as $key => $vo): ?>
                                <!--                                                    <option value="--><?php //echo $vo['value']; ?><!--">-->
                                <?php if ($vo['value'] == $data['parent_id']): ?>
                                    <option value="<?php echo $vo['value'];?>"  selected = "selected">
                                <?php endif; ?>
                                <?php echo $vo['text'] ?></option>
                            <?php endforeach; ?>
                        </select>
                                            <span style="margin-left:-47px;">
                                           	 选择技能隶属哪个技能下
                                            </span>
                    </li>

                    <!--                                        <li>-->
                    <!--                                            <strong>顶级分类：</strong>-->
                    <!--                                            <select name="parent_id" style="margin-right: 96px;">-->
                    <!--                                                <option value="0">顶级分类</option>-->
                    <!--                                                --><?php //foreach ($info as $key => $vo): ?>
                    <!--                                                    <option value="--><?php //echo $vo['value'];?><!--">--><?php //echo $vo['text'];?><!--</option>-->
                    <!--                                                --><?php //endforeach ?>
                    <!--                                            </select>-->
                    <!--                                            <span style="margin-left:-51px;">-->
                    <!--                                            	选择分类隶属哪个分类下-->
                    <!--                                            </span>-->
                    <!--                                        </li>-->
                    <li>
                        <strong>导航：</strong>
                        <input type="radio" name="show_in_nav" value="1" <?php echo ($data['show_in_nav'] == 1) ? 'checked' : ''; ?>/> 显示 <input type="radio" name="show_in_nav" value="0" <?php echo ($data['show_in_nav'] == 0) ? 'checked' : ''; ?>/> 禁用<span class="Validform_checktip"  style="margin-left:224px;">禁用导航，技能将不在前台导航中出现，默认为显示</span>
                    </li>
                    <li>
                        <strong>APP首页导航是否显示：</strong>
                        <input type="radio" name="app_flag" value="1" <?php echo ($data['app_flag'] == 1) ? 'checked' : ''; ?>/> 显示 <input type="radio" name="app_flag" value="0" <?php echo ($data['app_flag'] == 0) ? 'checked' : ''; ?>/> 禁用<span class="Validform_checktip"  style="margin-left:224px;">禁用导航，技能将不在前台导航中出现，默认为显示</span>
                    </li>
                    <li>
                        <strong>状态：</strong>
                        <input type="radio" name="status" value="1" checked="checked" /> 显示 <input type="radio" name="status" value="0"  /> 禁用<span class="Validform_checktip" style="margin-left:224px; ">禁用技能，用户在前台将看不到此条技能，默认为显示</span>
                    </li>
                    <li>
                        <strong>价格分级：</strong>
                        <input type="text" class="text_input" name="grade" placeholder=''  value="<?php echo $data['grade'];?>" /><span class="Validform_checktip" style="margin-left:2px;">填写技能下筛选价格分级，每个价格区间用","分隔，如：0-199,200-499</span>
                    </li>
                    <li>
                        <strong>排序：</strong>
                        <input type="text" class="text_input" name="sort"  value="<?php echo $data['sort'] ?>" placeholder=''  datatype="n" value="100" /><span class="Validform_checktip" style="margin-left:2px;">输入数字改变技能显示排序，数字越小越靠前</span>
                    </li>
                    <li>
                        <strong>关键字：</strong>
                        <input type="text" class="text_input" name="keywords"  value="<?php echo $data['keywords'] ?>" placeholder=''  /><span class="Validform_checktip" style="margin-left:2px;">关键词出现在页面头部的Keywords标签中，用于记录本技能的关键字，多个关键字请用分隔符分隔</span>
                    </li>
                    <li>
                        <strong>描述：</strong>
                        <textarea name="descript" rows="4" cols="20"><?php echo $data['descript'] ?></textarea><span style="padding-left: 0px;">描述出现在页面头部的Description标签中，用于记录本页面的描述信息，建议不超过80个字</span>
                    </li>
                </ul>
                <div class="submit">
                    <input type="hidden" name="id" value="<?php echo $data['id'] ?>" />
                    <input type="hidden" name="old_pid" value="<?php echo $data['parent_id'] ?>" />
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
<script type="text/javascript" src="<?php echo __QINIU__;?>plupload/js/plupload.full.min.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>plupload/js/i18n/zh_CN.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>ui.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>qiniu.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>highlight.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>main-upload.js"></script>
<script>
    $(function() {
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
    });
</script>
