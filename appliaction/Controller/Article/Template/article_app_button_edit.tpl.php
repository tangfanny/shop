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
        <a href="#">内容管理</a> > <a href="<?php echo U('lists')?>">App按钮列表</a> > 按钮信息
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
                      <form action="<?php echo U('Article_app_button/update')?>" class="addform" method="post" autocomplete="off">
                        <dd>
                <ul class="web">
                    <li>
                        <strong>按钮名称：</strong>
                        <input type="text" class="text_input" name="name"  value="<?php echo $info['name'] ?>"  datatype="*"/><span style="padding-left: 80px;" >填写按钮名称</span>
                    </li>
                    <li>
                        <strong>选中图片地址（必填）：</strong>
                        <div class="upload_select">
                            <input type="file" class="am-hide" id="pickfiles1" >
                            <input type="hidden" class="upload_url" name="img_selected" value="<?php echo $info['img_selected'];?>">
                            <div id="container">                                            </div >
                            <div id="scan">
                                <?php if(is_numeric($info['img_selected']) && strlen($info['img_selected'])==18):?>
                                    <img  src="<?php echo IMG_URL.Img_ADDRESS.$info['img_selected'].'?imageView2/2/w/200 ';?>" class="preview"  id="imgpreview"/>
                                <?php elseif(empty($info['img_selected'])): ?>
                                    <img src="" class="preview" id="imgpreview" alt="">
                                <?php else: ?>
                                    <img  src="<?php echo IMG_URL.$info['img_selected'].'?imageView2/2/w/200' ;?>" class="preview"  id="imgpreview"/>
                                <?php endif;?>
                            </div>
                        </div>
                    </li>
                     <li>
                        <strong>默认图片地址（必填）：</strong>
                         <div class="upload_select">
                             <input type="file" class="am-hide" id="pickfiles2" >
                             <input type="hidden" class="upload_url" name="img_default" value="<?php echo $info['img_default'];?>">
                             <div id="container">                                                </div>
                             <div id="scan">
                                 <?php if(is_numeric($info['img_default']) && strlen($info['img_default'])==18):?>
                                     <img  src="<?php echo IMG_URL.Img_ADDRESS.$info['img_default'].'?imageView2/2/w/200 ';?>" class="preview" id="imgpreview1"/>
                                 <?php elseif(empty($info['img_default'])): ?>
                                     <img src="" class="preview" id="imgpreview1" alt="">
                                 <?php else: ?>
                                     <img  src="<?php echo IMG_URL.$info['img_default'].'?imageView2/2/w/200' ;?>" class="preview" id="imgpreview1"/>
                                 <?php endif;?>
                             </div>
                         </div>
                    </li>
<!--                    <li>-->
<!--                        <strong>节日选中图片地址：</strong>-->
<!--                        <input type="hidden" class="text_input" name="day_img_selected"  value="--><?php //echo $info['day_img_selected'] ?><!--" />-->
<!--                        <span class="upimg" style="cursor:pointer;font-weight:bold;color:#0081c2;border: solid 1px;padding-left: 5px;" >点击这里上传</span>-->
<!--                        <span><img style="height: 40px;width:40px;" src="--><?php // echo $info['day_img_selected'] ;?><!--" /></span>-->
<!--                        <span>请输入按钮图片的图片调用地址</span>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <strong>节日默认图片地址：</strong>-->
<!--                        <input type="hidden" class="text_input" name="day_img_default"  value="--><?php //echo $info['day_img_default'] ?><!--"  />-->
<!--                        <span class="upimg" style="cursor:pointer;font-weight:bold;color:#0081c2;border: solid 1px;padding-left: 5px;" >点击这里上传</span>-->
<!--                        <span><img style="height: 40px;width:40px;" src="--><?php // echo $info['day_img_default'] ;?><!--" /></span>-->
<!--                        <span>请输入按钮图片的图片调用地址</span>-->
<!--                    </li>-->
                     <li>
                        <strong>选中颜色：</strong>
              <input type="color" class="color_input"  id="bgcolor" oninput="changeBackground(bgcolor.value)" name="color_selected" placeholder=''   value="<?php echo $info['color_selected'] ?>">
                        <span style="padding-left: 330px;" class="Validform_checktip" >请选择按钮的选中颜色</span>
                    </li>
                    <li>
                        <strong>默认颜色：</strong>
                        <input type="color" class="color_input"  id="bgcolor" oninput="changeBackground(bgcolor.value)" name="color_default" placeholder=''   value="<?php echo $info['color_default'] ?>">
                        <span style="padding-left: 330px;" class="Validform_checktip" >请选择按钮的默认颜色</span>
                    </li>
<!--                     <li>-->
<!--                        <strong>起始时间：</strong>-->
<!--                        <input type="text" class="time_input" name="start_time"  id="start"  value="--><?php //echo isset($info["start_time"])?date('Y-m-d H:i:s', $info["start_time"]):date('Y-m-d H:i:s',NOW_TIME)?><!--" style="width:225px;margin-right: 50px;"/>-->
<!--                        <span  style="margin-left:29px;">设置按钮起始生效的时间，格式 yyyy-mm-dd，留空为不限制起始时间</span>-->
<!--                    </li>-->
<!--                     <li>-->
<!--                        <strong>结束时间：</strong>-->
<!--                        <input type="text" class="time_input" name="end_time"  id="end"  value="--><?php //echo isset($info["end_time"])?date('Y-m-d H:i:s', $info["end_time"]):date('Y-m-d H:i:s',time()+30*86400)?><!--" style="width:225px;margin-right: 50px;"/>-->
<!--                        <span  style="margin-left:29px;">设置按钮结束生效的时间，格式 yyyy-mm-dd，留空为不限制起始时间</span>-->
<!--                    </li>-->
                    <li>
                        <input type="hidden" class="text_input" name="version"  datatype="n" value="<?php echo $info['version']+1 ?>" />
                    </li>
                    <li>
                        <strong>排序：</strong>
                        <input type="text" class="text_input" name="sort"  datatype="n" value="<?php echo $info['sort'] ? $info['sort'] : 100 ?>" />
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
<script type="text/javascript" src="<?php echo __QINIU__;?>uploadUtils.js"></script>
<script>
    var uploadBtns = $(".upload_select");
    initUploads(uploadBtns);
</script>
<!--日期控件-->
<?php echo jsfile('hddate');?>
<?php echo jsfile('hdvalid');?>
<script>
    $(function() {
        var start = {
            elem: '#start',
            format: 'YYYY-MM-DD hh:mm:ss',
            festival: true, //显示节日
            istime: true,
            istoday: true,
            choose: function(datas){ //选择日期完毕的回调
                return datas;
            }
        };
        var end = {
            elem: '#end',
            format: 'YYYY-MM-DD hh:mm:ss',
            festival: true, //显示节日
            min: laydate.now(),
            istime: true,
            istoday: true,
            choose: function(datas){
                start.max = datas; //结束日选好后，重置开始日的最大日期
            }
        }
        laydate(start);
        laydate(end);
    });
    function changeBackground(colorValue){
        document.body.style.bakcgroundColor = colorValue;
    }
</script>
