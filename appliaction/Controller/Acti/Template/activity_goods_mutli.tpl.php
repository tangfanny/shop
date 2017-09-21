<?php include $this->admin_tpl('header'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>webuploader.css" />
<script type="text/javascript" src="<?php echo JS_PATH;?>image-upload/webuploader.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>image-upload/upload.js"></script>
<form action="<?php echo U('ActivityGoods/goodsMultimg')?>" method="post">
    <div class="upload_more" style="margin-top: 20px;">
        <span >多图上传</span>
        <input type="file" class="am-hide" id="pickfiles3" style="color:#f1f1f1; ">
        <div id="container"></div>
        <div id="scan" >
            <?php   if (!empty($v['pics'])): ?>
                <?php foreach ($v['pics'] as $k=>$va):?>
                    <img data-id='<?php echo $va ;?>' id="photos<?php echo explode('.',$va)[0];?>" onclick='delete_img("<?php echo explode('.',$va)[0];?>")'  class='preview' src='<?php echo IMG_URL.$va ;?>' />
                <?php endforeach;?>
            <?php endif ?>
        </div>
        <div id="hid">
            <?php   if (!empty($v['pics'])): ?>
                <?php foreach ($v['pics'] as $k=>$va):?>
                    <input data-id='<?php echo $va ;?>' type='hidden' name='goodsphoto[]' id='hid-val' value='<?php echo $va ;?>' />
                <?php endforeach;?>
            <?php endif ?>
        </div>

    </div>
<div class="submit">
    <input type="hidden" name="id" value="<?php echo $id; ?>" />
    <input type="hidden" name="cid" value="<?php echo $cid;?>"/>
    <input type="submit" class='button_search' value='提交'/>
    <a href="<?php echo U('Activity/edit',array('id'=>$id))?>">返回</a>
</div>
</form>

<!--模板-->
<script type="text/javascript" src="<?php echo JS_PATH; ?>artTemplate/artTemplate.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>artTemplate/artTemplate-plugin.js"></script>
<!--编辑器开始-->
<script type="text/javascript" src="<?php echo __QINIU__;?>plupload/js/plupload.full.min.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>plupload/js/i18n/zh_CN.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>ui.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>qiniu.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>highlight.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>uploadUtils.js"></script>
<script>
    var upload_more = $(".upload_more");
    initUploadMore(upload_more);
</script>
