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
        <a href="<?php echo U('Task/lists');?>">众测编辑</a>
        >
    </div>
    <span class="line_white"></span>
    <div class="install mt10">
        <dl>
            <dd>
                <div class="install mt10">
                    <div class="install mt10">
                        <dl>
                            <form action="<?php echo U('Task/edit');?>" method="post">
            <dd>
                <ul class="web">
                    <li>
                        <div class="c1">项目LOGO：</div>
                        <input type="file" class="am-hide" id="pickfiles" >
                        <input type="hidden" id='chengxing' name="company_pic" value="<?php echo $info['company_pic'];?>">
                        <div id="container">
                        </div>
                        <div>
                            <?php if(is_numeric($info['company_pic']) && strlen($info['company_pic'])==18):?>
                                <img  src="<?php echo IMG_URL.Img_ADDRESS.$info['company_pic'].'?imageView2/2/w/200 ';?>" id="imgpreview"/>
                            <?php elseif(empty($info['company_pic'])): ?>
                                <img src="" id="imgpreview" alt="">
                            <?php else: ?>
                                <img  src="<?php echo IMG_URL.$info['company_pic'].'?imageView2/2/w/200' ;?>" id="imgpreview"/>
                            <?php endif;?>
                        </div>
                    </li>
                    <li>
                        <div class="c1">起始时间：</div>
                        <span><input type="text" class="time_input" name="start_time"  id="start"  value="<?php echo isset($info["start_time"])?date('Y-m-d H:i:s', $info["start_time"]):date('Y-m-d H:i:s',NOW_TIME)?>" style="width:225px;margin-right: 50px;"/></span>
                        <span  style="margin-left:29px;">设置按钮起始生效的时间，格式 yyyy-mm-dd，留空为不限制起始时间</span>
                    </li>
                    <li>
                        <div class="c1">结束时间：</div>
                        <span><input type="text" class="time_input" name="end_time"  id="end"  value="<?php echo isset($info["end_time"])?date('Y-m-d H:i:s', $info["end_time"]):date('Y-m-d H:i:s',time()+30*86400)?>" style="width:225px;margin-right: 50px;"/></span>
                        <span  style="margin-left:29px;">设置按钮结束生效的时间，格式 yyyy-mm-dd，留空为不限制起始时间</span>
                    </li>
                    <li>
                        <div class="c1">是否公开：</div>
                        <input name="isopen" type="radio" value="0" <?php if($info['isopen'] == 0) echo 'checked'; ?>>公开
                        <input name="isopen" type="radio" value="1" <?php if($info['isopen'] == 1) echo 'checked'; ?>>私密
                    </li>
                    <li>
                        <div class="c1">项目名称：</div><span>
                        <input type="text" class="text_input" name="title"   value="<?php echo $info['title'] ?>"  datatype="*"/><span style="padding-left: 80px;" >请填写您的项目名称</span>
                   </span>
                    </li>
                    <li>
                        <div class="c1">悬赏金额(RMB)：</div><span> <input type="text" class="text_input" name="sec_price"  value="<?php echo $info['sec_price']; ?>"  datatype="*"/><span style="padding-left: 80px;" >为您的需求制定一定悬赏金</span>
                    </li>
                    <li>
                        <div class="c1">奖励说明(实物)：</div><span><script id="am-container" name="shiwujianli" type="text/plain" style="width:1024px;height:450px;" ><?php echo  $info['shiwujianli'];?></script></span>
                    </li>
                    <li>
                        <div class="c1">项目简介：</div><span><script id="am-container1" name="jianjie" type="text/plain" style="width:1024px;height:450px;" ><?php echo  $info['jianjie'];?></script></span>
                    </li>
                    <li>
                        <div class="c1">奖励说明：</div><span><script id="am-container2" name="description" type="text/plain" style="width:1024px;height:450px;" ><?php echo  $info['description'];?></script></span>
                    </li>
                    <li>
                        <div class="c1">需求描述：</div><span><script id="am-container3" name="content" type="text/plain" style="width:1024px;height:450px;" ><?php echo  $info['content'];?></script></span>
                    </li>
                    <li>
                        <div class="c1">注意事项：</div><span><script id="am-container4" name="notes" type="text/plain" style="width:1024px;height:450px;" ><?php echo  $info['notes'];?></script></span>
                    </li>
                    <li><input type="hidden" name="task_id" value="<?php echo $info['task_id'];?> "></li>
                    <li>
                        <input type='submit' value='提交' class='btn btn-block btn-primary'>
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

<script type="text/javascript" src="<?php echo __QINIU__;?>plupload/js/plupload.full.min.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>plupload/js/i18n/zh_CN.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>ui.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>qiniu.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>highlight.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>main-upload.js"></script>
<script type="text/javascript" src="<?php echo __UEDITOR__; ?>ue/ueditor.config.js"></script>
<script type="text/javascript" src="<?php echo __UEDITOR__; ?>ue/ueditor.all.js"></script>
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

    var ue = UE.getEditor('am-container');
    var ue = UE.getEditor('am-container1');
    var ue = UE.getEditor('am-container2');
    var ue = UE.getEditor('am-container3');
    var ue = UE.getEditor('am-container4');

        var str = window.location.host;
        var strs= new Array();
        strs    = str.split(".");
        var host = strs[strs.length-2]+"."+strs[strs.length-1];
        document.domain = host;
    });

</script>