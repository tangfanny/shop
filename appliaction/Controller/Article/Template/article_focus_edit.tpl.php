<?php include $this->admin_tpl("header"); ?>
<div class="content">
    <style>
        #Validform_msg{display: none}
    </style>
    <div id="top-alert" class="fixed alert alert-error" style="display: none;">
        <button class="close fixed" style="margin-top: 4px;">&times;</button>
        <div class="alert-content">内容管理</div>
    </div>
    <div class="site">
        <a href="#">内容管理</a> > <a href="<?php echo U('lists')?>">幻灯片列表</a> > 编辑/添加
    </div>
    <script type="text/javascript" src="/statics/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="/statics/js/Validform_v5.3.2_min.js"></script>
    <script type="text/javascript" src="/statics/js/Validform_Datatype.js"></script>
    <script type="text/javascript" src="/statics/js/artDialog/artDialog.js?skin=default"></script>
    <script type="text/javascript" src="/statics/js/artDialog/plugins/iframeTools.js" ></script>
    <span class="line_white"></span>
    <div class="install mt10">
        <dl>
            <div class="install mt10">
                <dl>
                    <form action="<?php echo U('Article_focus/update')?>" class="addform" method="post" autocomplete="off">
                        <dd>
                            <ul class="web">
                                <li>
                                    <strong>图片地址：</strong>
                                    <input type="file" class="am-hide" id="pickfiles" >
                                    <input type="hidden" id='chengxing' name="pic" value="<?php echo $info['pic'];?>">
                                    <div id="container">
                                    </div>
                                    <div>
                                        <?php if(is_numeric($info['pic']) && strlen($info['pic'])==18):?>
                                            <img  src="<?php echo IMG_URL.Img_ADDRESS.$info['pic'].'?imageView2/2/w/200 ';?>" id="imgpreview"/>
                                        <?php elseif(empty($info['pic'])): ?>
                                            <img src="" id="imgpreview" alt="">
                                        <?php else: ?>
                                            <img  src="<?php echo IMG_URL.$info['pic'].'?imageView2/2/w/200' ;?>" id="imgpreview"/>
                                        <?php endif;?>
                                    </div>
                                </li>
                                <li>
                                    <strong>链接地址：</strong>
                                    <input type="text" class="text_input"   name="url"   value="<?php echo $info['url'] ?>">
                                    <span style="padding-left: 330px;" class="Validform_checktip" >请选择按钮的默认颜色</span>
                                </li>
                                <li>
                                    <strong>文字说明：</strong>
                                    <input type="text" class="text_input" name="text"  value="<?php echo $info['text']  ?>" />
                                    <span class="Validform_checktip" style="margin-left:26px;">输入数字改变按钮显示排序，数字越小越靠前</span>
                                </li>
                                <li>
                                    <strong>链接排序：</strong>
                                    <input type="text" class="text_input" name="sort"   value="<?php echo $info['sort'] ? $info['sort'] : 100 ?>" />
                                    <span class="Validform_checktip" style="margin-left:26px;">输入数字改变按钮显示排序，数字越小越靠前</span>
                                </li>
                                <li>
                                    <strong>是否显示：</strong>
                                    <input type="radio" name="status" value="1" <?php if ($info['status'] == 1): ?> checked="checked"<?php endif ?> />显示
                                    <input type="radio" name="status" value="0" <?php if ($info['status'] == 0): ?> checked="checked"<?php endif ?> />禁用
                        <span class="Validform_checktip"  style="margin-left:245px;">
                        选中否，按钮将不在前台中出现，默认为显示</span>
                                </li>
                            </ul>
                            <div class="submit">
                                <?php if(!empty($info)){ ?>
                                    <input type="hidden" value="edit" name="opt" />
                                    <input type="hidden" value="<?php echo $info['id'] ?>" name="id" />
                                <?php }else{ ?>
                                    <input type="hidden" value="add" name="opt" />
                                <?php }; ?>
                                <input type="submit" class="button_search" value="提交"/>
                                <a href="<?php echo U('lists')?>">返回</a>
                            </div>
                        </dd>
                    </form>
            </div>
        </dl>
    </div>
    <?php include $this->admin_tpl('copyright'); ?>
</div>
<script type="text/javascript" src="<?php echo __QINIU__;?>plupload/js/plupload.full.min.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>plupload/js/i18n/zh_CN.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>ui.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>qiniu.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>highlight.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>main-upload.js"></script>

