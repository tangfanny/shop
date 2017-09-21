<?php include $this->admin_tpl("header"); ?>
<div class="content">
    <style>
        #Validform_msg{display: none}
        .web > li{line-height:40px;}
        .web li span{padding-left:0px;}
        .website{float: right;margin: 13px 0px;cursor:pointer;}
    </style>
    <div id="top-alert" class="fixed alert alert-error" style="display: none;">
        <button class="close fixed" style="margin-top: 4px;">&times;</button>
        <div class="alert-content">这是内容</div>
    </div>
    <div class="site">
        <a href="<?php echo U('lists')?>">活动列表</a> > 添加/编辑活动
    </div>
    <span class="line_white"></span>
    <div class="install mt10">
        <dl>
            <dd>
                <div class="install mt10">
                    <div class="install mt10">
                        <dl>
                            <form action="<?php echo U('activity/add')?>" class="addform" method="post">
            <dd>
                <ul class="web">
                    <li>
                        <span style="padding:0px !important;margin-right:125px;"><h3>上导航</h3></span>
                        <a href="<?php echo U('ActivityNav/navList',array('id'=>$id))?>">进入上导航设置</a>
                    </li>
                    <li>
                        <span style="padding:0px !important;margin-right:117px;"><h3>Banner</h3></span>
                        <a href="<?php echo U('ActivityNav/bannerDisplay',array('id'=>$id,'aid'=>$aid))?>">进入Banner设置</a>
                    </li>
                    <li>
                        <span style="padding:0px !important;margin-right:109px;"><h3>背景颜色</h3></span>
                        <input type="text" class="text_input" name="b_c" placeholder='' value="<?php echo $arrp[0]['b_c']; ?>">
                    </li>
                    <li>
                        <span style="padding:0px !important;margin-right:109px;"><h3>是否上线</h3></span>
                        <b style="margin-right: 44px;">
                            <label><input type="radio" name="status" value="1" <?php if (isset($arrp[0]['status']) && $arrp[0]['status'] == 1): ?>
                                    checked
                                <?php else: ?>
                                    checked
                                <?php endif ?>/> 上线 </label>
                            <label><input type="radio" name="status" value="0" <?php if (isset($arrp[0]['status']) && $arrp[0]['status'] == 0): ?>
                                    checked
                                <?php endif ?>/> 未上线 </label>
                            <label><input type="radio" name="status" value="2" <?php if (isset($arrp[0]['status']) && $arrp[0]['status'] == 2): ?>
                                    checked
                                <?php endif ?>/> 下线 </label>
                        </b>
                    </li>
                    <li>
                        <span style="padding:0px !important;margin-right:100px;"><h3>图片部件---1</h3></span>
                                <a href="<?php echo U('ActivityGoods/goodsMultimg',array('id'=>$id,'cid'=>1))?>" class="multimg">图片上传</a>
                        <a href="<?php echo U('Activity/imgList',array('id'=>$id,'cid'=>1))?>" class="multimg">编辑图片</a>
                        <span class="acti_near"><?php echo $argoods['1']?></span>
                        <span class="ajax_off website"></span>
                    </li>
                    <li>
                        <span style="padding:0px !important;margin-right:100px;"><h3>商品部件---2</h3></span>
                        <input type="hidden" name="cid[]" value="2" id="cid_2">
                        <input type="hidden" name="path[]" value="">
                        <a href="<?php echo U('ActivityGoods/goodsList',array('id'=>$id,'cid'=>2)) ?>">进入商品设置</a>
                        <span class="acti_near"><?php echo $argoods['2']?></span>
                        <span class="ajax_off website"></span>
                    </li>
                    <li>
                        <span style="padding:0px !important;margin-right:100px;"><h3>图片部件---3</h3></span>
                        <a href="<?php echo U('ActivityGoods/goodsMultimg',array('id'=>$id,'cid'=>3))?>" class="multimg">图片上传</a>
                        <a href="<?php echo U('Activity/imgList',array('id'=>$id,'cid'=>3))?>" class="multimg">编辑图片</a>
                        <span class="ajax_off website"></span>
                    </li>
                    <li>
                        <span style="padding:0px !important;margin-right:100px;"><h3>商品部件---4</h3></span>
                        <input type="hidden" name="path[]" value="">
                        <a href="<?php echo U('ActivityGoods/goodsList',array('id'=>$id,'cid'=>4)) ?>">进入商品设置</a>
                        <span class="acti_near"><?php echo $argoods['4']?></span>
                        <span class="ajax_off website"></span>
                    </li>
                    <li>
                        <span style="padding:0px !important;margin-right:100px;"><h3>图片部件---5</h3></span>
                        <a href="<?php echo U('ActivityGoods/goodsMultimg',array('id'=>$id,'cid'=>5))?>" class="multimg">图片上传</a>
                        <a href="<?php echo U('Activity/imgList',array('id'=>$id,'cid'=>5))?>" class="multimg">编辑图片</a>
                        <span class="ajax_off website"></span>
                    </li>
                    <li>
                        <span style="padding:0px !important;margin-right:100px;"><h3>商品部件---6</h3></span>
                        <input type="hidden" name="path[]" value="">
                        <a href="<?php echo U('ActivityGoods/goodsList',array('id'=>$id,'cid'=>6))?>">进入商品设置</a>
                        <span class="acti_near"><?php echo $argoods['6']?></span>
                        <span class="ajax_off website"></span>
                    </li>
                    <li>
                        <span style="padding:0px !important;margin-right:100px;"><h3>图片部件---7</h3></span>
                        <a href="<?php echo U('ActivityGoods/goodsMultimg',array('id'=>$id,'cid'=>7))?>" class="multimg">图片上传</a>
                        <a href="<?php echo U('Activity/imgList',array('id'=>$id,'cid'=>7))?>" class="multimg">编辑图片</a>
                        <span class="ajax_off website"></span>
                    </li>
                    <li>
                        <span style="padding:0px !important;margin-right:100px;"><h3>商品部件---8</h3></span>
                        <input type="hidden" name="path[]" value="">
                        <a href="<?php echo U('ActivityGoods/goodsList',array('id'=>$id,'cid'=>8)) ?>">进入商品设置</a>
                        <span class="acti_near"><?php echo $argoods['8']?></span>
                        <span class="ajax_off website"></span>
                    </li>
                    <li>
                        <span style="padding:0px !important;margin-right:100px;"><h3>图片部件---9</h3></span>
                        <a href="<?php echo U('ActivityGoods/goodsMultimg',array('id'=>$id,'cid'=>9))?>" class="multimg">图片上传</a>
                        <a href="<?php echo U('Activity/imgList',array('id'=>$id,'cid'=>9))?>" class="multimg">编辑图片</a>
                        <span class="ajax_off website"></span>
                    </li>
                    <li>
                        <span style="padding:0px !important;margin-right:100px;"><h3>商品部件---10</h3></span>
                        <input type="hidden" name="path[]" value="">
                        <a href="<?php echo U('ActivityGoods/goodsList',array('id'=>$id,'cid'=>10)) ?>">进入商品设置</a>
                        <span class="acti_near"><?php echo $argoods['10']?></span>
                        <span class="ajax_off website"></span>
                    </li>
                    <li>
                        <span style="padding:0px !important;margin-right:109px;"><h3>分享title</h3></span>
                        <input type="text" class="text_input" name="s_title" placeholder='15字内' value="<?php echo $arrp[0]['s_title'] ?>">
                    </li>
                    <li>
                        <span style="padding:0px !important;margin-right:109px;"><h3>分享简介</h3></span>
                        <input type="text" class="text_input" name="s_desc" placeholder='25字内' value="<?php echo $arrp[0]['s_desc'] ?>">
                    </li>
                    <li>
                        <span style="padding:0px !important;margin-right:100px;"><h3>分享缩略图</h3></span>
                        <a  style="text-decoration:none;">单图上传</a>
                            <input type="file" class="am-hide" id="pickfiles" style="color:#f1f1f1; ">
                            <input type="hidden" id='chengxing' name="s_img" value="<?php echo $arrp[0]['s_img'];?>">
                            <div id="container"> </div>
                            <div >
                                    <?php if(is_numeric($arrp[0]['s_img']) && strlen($arrp[0]['s_img'])==18):?>
                                        <img  src="<?php echo IMG_URL.Img_ADDRESS.$arrp[0]['s_img'].'?imageView2/2/w/200 ';?>"   id="imgpreview"/>
                                    <?php elseif(empty($arrp[0]['s_img'])): ?>
                                        <img src=""  id="imgpreview" alt="">
                                    <?php else: ?>
                                        <img  src="<?php echo IMG_URL.$arrp[0]['s_img'].'?imageView2/2/w/200' ;?>"  id="imgpreview"/>
                                    <?php endif;?>
                                </div>
                        <span class="ajax_off website"></span>
                    </li>
                    <dl class="gzzt clearfix mt10">
            <dd>
                <div class="time fl">
                    <strong>开始时间：</strong>
                    <input type="text" id="start" name='start_time' value='<?php if (!empty($arrp[0]["start_time"])){ echo date('Y-m-d H:i:s',$arrp[0]['start_time']);}else{ echo date('Y-m-d H:i:s');}?>' style='width:130px' />
                    <strong>结束时间：</strong>
                    <input type="text" id="end" name='end_time' value='<?php if(!empty($arrp[0]["end_time"])){ echo date('Y-m-d H:i:s', $arrp[0]['end_time']);}else{ echo date('Y-m-d H:i:s',time()+2592000);}?>' style='width:130px' />
                    </select>
                </div>
            </dd>
        </dl>
        </li>
        </ul>
        <div class="submit">
            <input type="hidden" name="aid" value="<?php echo $id?>">
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
<?php include $this->admin_tpl("copyright"); ?>
</div>
<script type="text/javascript" src="<?php echo __QINIU__;?>plupload/js/plupload.full.min.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>plupload/js/i18n/zh_CN.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>ui.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>qiniu.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>highlight.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>main-upload.js"></script>
<!--时间选择-->
<?php echo jsfile('hddate');?>
<?php echo jsfile('hdvalid');?>
<script>
    $(function() {
        var start = {
            elem: '#start',
            format: 'YYYY-MM-DD hh:mm:ss',
            min: laydate.now(), //设定最小日期为当前日期
            max: '2099-06-16 23:59:59', //最大日期
            istime: true,
            istoday: true,
            choose: function(datas){
                end.min = datas; //开始日选好后，重置结束日的最小日期
                end.start = datas //将结束日的初始值设定为开始日
            }
        };
        var end = {
            elem: '#end',
            format: 'YYYY-MM-DD hh:mm:ss',
            // min: laydate.now(30),
            max: '2099-06-16 23:59:59',
            istime: true,
            istoday: true,
            choose: function(datas){
                start.max = datas; //结束日选好后，重置开始日的最大日期
            }
        };

        laydate(start);
        laydate(end);

        $('.ajax_off').click(function(){
            var s = $(this).parent('li');
            s.find('input[type=hidden]').attr('disabled',true); //禁止提交
            s.css('display','none');
        })
    });
</script>


