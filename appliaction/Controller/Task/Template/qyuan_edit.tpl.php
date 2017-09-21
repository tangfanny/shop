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
        <a >请愿编辑</a>
        >
    </div>
    <span class="line_white"></span>
    <div class="install mt10">
        <dl>
            <dd>
                <div class="install mt10">
                    <div class="install mt10">
                        <dl>
                            <form action="<?php echo U('Qyuan/edit');?>" method="post">
            <dd>
                <ul class="web">
                    <li>
                        <div class="c1">项目LOGO：</div>
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
                        <div class="c1">标题：</div><span>
                        <input type="text" class="text_input" name="title"   value="<?php echo $info['title'] ?>"  datatype="*"/><span style="padding-left: 80px;" >请填写您的项目名称</span>
                   </span>
                    </li>
                    <li>
                        <div class="c1">简介：</div><span><script id="am-container" name="description" type="text/plain" style="width:1024px;height:450px;" ><?php echo  $info['description'];?></script></span>
                    </li>
                    <li>
                        <div class="c1">详细描述：</div><span><script id="am-container1" name="content" type="text/plain" style="width:1024px;height:450px;" ><?php echo  $info['content'];?></script></span>
                    </li>
                    <li><input type="hidden" name="idx" value="<?php echo $info['idx'];?> "></li>
                    <li>
                        <input type='submit' value='提交请愿' class='btn btn-block btn-primary'>
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
<!--<script type="text/javascript" src="--><?php //echo JS_PATH;?><!--EasyUI/jquery.min.js"></script>-->
<script type="text/javascript" src="<?php echo __QINIU__;?>plupload/js/plupload.full.min.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>plupload/js/i18n/zh_CN.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>ui.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>qiniu.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>highlight.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>main-upload.js"></script>
<script type="text/javascript" src="<?php echo __UEDITOR__; ?>ue/ueditor.config.js"></script>
<script type="text/javascript" src="<?php echo __UEDITOR__; ?>ue/ueditor.all.js"></script>
<script>
        var ue = UE.getEditor('am-container');
        var ue = UE.getEditor('am-container1');
        var str = window.location.host;
        var strs= new Array();
        strs    = str.split(".");
        var host = strs[strs.length-2]+"."+strs[strs.length-1];
        document.domain = host;

</script>