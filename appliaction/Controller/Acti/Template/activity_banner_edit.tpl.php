<?php include $this->admin_tpl("header"); ?>
<div class="content">
    <style>
        #Validform_msg{display: none}
    </style>
    <div id="top-alert" class="fixed alert alert-error" style="display: none;">
        <button class="close fixed" style="margin-top: 4px;">&times;</button>
        <div class="alert-content">运营推广</div>
    </div>
    <div class="site">
        活动模板Banner 编辑/添加
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
                    <form action="<?php echo U('ActivityNav/bannerUpdate')?>" class="addform" method="post" autocomplete="off">
                        <dd>
                            <ul class="web">
                                <li>
                                    <strong>图片标题：</strong>
                                    <input type="text" class="text_input" name="name"  value="<?php echo $info['name'] ?>"  datatype="*"/><span style="padding-left: 80px;" >填写图片标题</span>
                                </li>
                                <li>
                                    <strong>图片地址：</strong>
                                    <input type="file" class="am-hide" id="pickfiles" >
                                    <input type="hidden" id='chengxing' name="pic" value="<?php echo $info['pic'];?>">
                                    <div id="container">
                                    </div>
                                    <div>
                                        <?php if(empty($info['pic'])): ?>
                                            <img src="" id="imgpreview" alt="">
                                        <?php else: ?>
                                            <img  src="<?php echo IMG_URL.$info['pic'].'?imageView2/2/w/200' ;?>" id="imgpreview"/>
                                        <?php endif;?>
                                    </div>
                                </li>
                                <li>
                                    <strong>链接地址：</strong>
                                    <input type="text" class="text_input" name="url"  value="<?php echo $info['url']  ?>" />
                                    <span class="Validform_checktip" style="margin-left:26px;">输入banner对应链接地址</span>
                                </li>
                                <li>
                                    <strong>链接排序：</strong>
                                    <input type="text" class="text_input" name="rankid"   value="<?php echo $info['rankid'] ? $info['rankid'] : 100 ?>" />
                                    <span class="Validform_checktip" style="margin-left:26px;">输入数字改变按钮显示排序，数字越小越靠前</span>
                                </li>
                                <li>
                                    <strong>是否显示：</strong>
                                    <input type="radio" name="is_show" value="1" <?php if ($info['is_show'] == 1): ?> checked="checked"<?php endif ?> />显示
                                    <input type="radio" name="is_show" value="0" <?php if ($info['is_show'] == 0): ?> checked="checked"<?php endif ?> />禁用
                                        <span class="Validform_checktip"  style="margin-left:245px;">
                                        选中否，banner将不在前台中出现，默认为显示</span>
                                </li>
                                <li>
                                    <strong>添加时间：</strong>
                                    <input type="text" class="time_input" name="addtime"  id="start"  value="<?php echo isset($info["addtime"])?date('Y-m-d H:i:s', $info["addtime"]):date('Y-m-d H:i:s',NOW_TIME)?>" style="width:225px;margin-right: 50px;"/>
                                    <span  style="margin-left:29px;">设置banner添加的时间，格式 yyyy-mm-dd，留空为不限制起始时间</span>
                                </li>
                                <input type="hidden" name="id" value="<?php echo $info['id']; ?>" />
                            </ul>
                            <div class="submit">
                                <?php if(!empty($info)){ ?>
                                    <input type="hidden" value="edit" name="opt" />
                                    <input type="hidden" value="<?php echo $info['aid'] ?>" name="aid" />
                                    <input type="submit" class="button_search" value="提交"/>
                                    <a href="<?php echo U('navList',array('id'=>$info['aid']))?>">返回</a>
                                <?php }else{ ?>
                                    <input type="hidden" value="add" name="opt" />
                                    <input type="hidden" value="<?php echo $_GET['aid'] ?>" name="aid" />
                                    <input type="hidden" name="aid" value="<?php echo $id ?>"/>
                                    <input type="submit" class="button_search" value="提交"/>
                                    <a href="<?php echo U('navList',array('id'=>$id))?>">返回</a>
                                <?php }; ?>
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
        };
        laydate(start);
        laydate(end);
    });
</script>
