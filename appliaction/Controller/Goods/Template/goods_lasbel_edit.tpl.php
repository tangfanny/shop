<?php include $this->admin_tpl("header"); ?>
<style>
#Validform_msg{display: none}
.operator{cursor: pointer;padding:10px;}
.spec_input{margin:10px;}
img{cursor: pointer}
</style>
<div class="content">
    <div id="top-alert" class="fixed alert alert-error" style="display: none;">
        <button class="close fixed" style="margin-top: 4px;">&times;</button>
        <div class="alert-content">这是内容</div>
    </div>
    <div class="site">
         <a href="#">商品管理</a> > 商品标签 > 修改商品标签
    </div>
    <span class="line_white"></span>
    <div class="install mt10">
        <dl>
            <dd>
                <div class="install mt10">
                    <div class="install mt10">
                        <dl>
                            <form action="<?php echo U('edit')?>" class="addform" method="post">
                                <input type="hidden" value="<?php echo $info["id"]?>" name="id"/>
                                <dd>
                                    <ul class="web">
                                        <li>
                                            <strong>标签名称：</strong>
                                            <input type="text" value="<?php echo $info['name']; ?>" class="text_input" datatype="*" nullmsg="请输入标签名称！" name="name"  /><span>填写标签名称</span>
                                        </li>
                                        <li>
                                        <strong>商品品牌：</strong>
                                            <select name="location" class="select" style="margin-right: 48px;">
                                               <option value="">请选择</option>
                                               <option value="1" <?php echo $info["location"]==1?"selected":""?>>左上</option>
                                               <option value="2" <?php echo $info["location"]==2?"selected":""?>>左下</option>
                                               <option value="3" <?php echo $info["location"]==3?"selected":""?>>右上</option>
                                               <option value="4" <?php echo $info["location"]==4?"selected":""?>>右下</option>
                                               <option value="5" <?php echo $info["location"]==5?"selected":""?>>居中</option>
                                           </select><span>为标签选择出现的位置。</span>
                                        </li>
                                        <li style="line-height:24px;">
                                            <strong>商品图片：</strong>
                                            <input type="file" class="am-hide" id="pickfiles" >
                                            <input type="hidden" id='chengxing' name="img" value="<?php echo $info['img'];?>">
                                            <div id="container">
                                            </div>
                                            <div>
                                                <?php if(is_numeric($info['img']) && strlen($info['img'])==18):?>
                                                    <img  src="<?php echo IMG_URL.Img_ADDRESS.$info['img'].'?imageView2/2/w/200 ';?>" id="imgpreview"/>
                                                <?php elseif(empty($info['img'])): ?>
                                                    <img src="" id="imgpreview" alt="">
                                                <?php else: ?>
                                                    <img  src="<?php echo IMG_URL.$info['img'].'?imageView2/2/w/200' ;?>" id="imgpreview"/>
                                                <?php endif;?>

                                            </div>
                                         </li>                                           
                                        <li>
                                            <strong>状态：</strong>
                                            <input type="radio" name="status" value="1" <?php echo $info["status"]==1?"checked='checked'":""?> /> 显示 <input type="radio" name="status" value="0"  <?php echo $info["status"]==0?"checked='checked'":""?>/> 禁用<span class="Validform_checktip" style="margin-left:214px;">设置商品规格是否显示，默认为显示</span>
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
        <?php include $this->admin_tpl('copyright'); ?>
    </div>
</div>
</body>
    <!--编辑器开始-->
<script type="text/javascript" src="<?php echo __QINIU__;?>plupload/js/plupload.full.min.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>plupload/js/i18n/zh_CN.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>ui.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>qiniu.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>highlight.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>main-upload.js"></script>


