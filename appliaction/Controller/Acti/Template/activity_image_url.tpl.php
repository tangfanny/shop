<?php include $this->admin_tpl("header"); ?>
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/haidaoblue/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/icon.css">
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/hd_default_config.js"></script>
    <!-- 内容区 -->
    <div class="content">
        <div id="top-alert" class="fixed alert alert-error" style="display: none;">
            <button class="close fixed" style="margin-top: 4px;">&times;</button>
            <div class="alert-content">这是内容</div>
        </div>
        <div class="site">
             <a href="#">活动管理</a> > 图片编辑 > 链接编辑
        </div>
        <span class="line_white"></span>
    <div class="install mt10">
        <dl>
            <dd>
                <div class="install mt10">
                    <div class="install mt10">
                        <dl>
                            <form action="<?php echo $action ?>" class="addform" method="post" onsubmit="return checkForm();">
                                <dd>
                                    <ul class="web">
                                        <li>
                                            <strong>商品标题：</strong>
                                            <input type="file" class="am-hide" id="pickfiles" >
                                            <input type="hidden" id='chengxing' name="path" value="<?php echo $aimg['path'];?>">
                                            <div id="container">
                                                <div>
                                                    <?php if(is_numeric($aimg['path']) && strlen($aimg['path'])==18):?>
                                                        <img  src="<?php echo IMG_URL.Img_ADDRESS.$aimg['path'].'?imageView2/2/w/200 ';?>"  id="imgpreview"/>
                                                    <?php elseif(empty($aimg['path'])): ?>
                                                        <img src=""  id="imgpreview" alt="">
                                                    <?php else: ?>
                                                        <img  src="<?php echo IMG_URL.$aimg['path'].'?imageView2/2/w/200' ;?>"  id="imgpreview"/>
                                                    <?php endif;?>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <strong>关联商品：</strong>
                                            <input type="hidden" name="rgid" value="<?php echo $aimg['gid'];?>">
                                            <a href="javascript:goods_search();" class="fl chooseBtn1"><img src="<?php echo IMG_PATH; ?>admin/order-50.png"/></a>
                                            <span class="acti_near"><?php echo $aimg['goods_name'];?></span>
                                            <span class="re_set" style="cursor:pointer;">重置</span>
                                        </li>                                        
                                        <li>
                                            <strong>网址：</strong>
                                            <input type="text" class="text_input" name="url" placeholder='' datatype="url" ignore="ignore" value="<?php echo $aimg['url'];?>" disabled="disabled" /><span class="Validform_checktip">设置品牌链接，请填写http://</span>
                                        </li>                                  
                                        <li>
                                            <strong>排序：</strong>
                                            <input type="text" class="text_input" name="sort" placeholder=''  datatype="n" value="<?php echo $info['sort'];?>"/><span class="Validform_checktip" >输入数字显示排序，数字越小越靠前数字越大越靠后</span>
                                        </li>
                                    </ul>
                                    <div class="submit">
                                        <input type="hidden" name="id" value="<?php echo $aimg['id'] ?>" />
                                        <input type="hidden" name="cid" value="<?php echo $cid ?>"/>
                                        <input type="hidden" name="aid" value="<?php echo $aid ?>"/>
                                        <input type="submit" class='button_search' value='提交'/>
                                        <a href="<?php echo U('imgList',array('id'=>"$aid",'cid'=>"$cid"))?>">返回</a>
                                    </div>
                                </dd>
                            </form>  
                        </dl>
                    </div>
            </dd>
        </dl>
    </div>
</div>
<!--编辑器开始-->
<script type="text/javascript" src="<?php echo __QINIU__;?>plupload/js/plupload.full.min.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>plupload/js/i18n/zh_CN.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>ui.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>qiniu.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>highlight.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>main-upload.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>artTemplate/artTemplate.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>artTemplate/artTemplate-plugin.js"></script>
<script type="text/javascript" src="/statics/js/artDialog/artDialog.js?skin=default"></script>
<script type="text/javascript" src="/statics/js/artDialog/plugins/iframeTools.js"></script>
<!--关联商品--> 
<script type="text/javascript">
$(function() {

        if($('.acti_near').text() == ''){
            $('input[name=url]').removeAttr('disabled');
        }

        $('#search').on('click',function(){
            //alert('www');
            var gid = $('input[name=gid]').val();
            //alert(gid);
            //alert(typeof(gid));
            if(gid != '' && parseInt(gid) != NaN && typeof(parseInt(gid)) == 'number'){
                $.ajax({
                    type:'post',
                    data:{'gid':gid},
                    dataType:'json',
                    url:'<?php echo U('findGoods')?>',
                    success:function(data){
                        if(data.sta == 1){
                            $('input[name=rgid]').val(data.id);
                            art.dialog({width: 320, time: 5, title: '温馨提示(5秒后关闭)', content: data.name, ok: true});
                        }else{
                            art.dialog({width: 320, time: 5, title: '温馨提示(5秒后关闭)', content: '没有该商品', ok: true});
                        }
                    }
                })
            }
        })
        $('.re_set').on('click',function(){
            $('input[name=rgid]').val('');
            $('.acti_near').text('');
            $('input[name=url]').removeAttr('disabled');
        })
});

function checkForm(){
    var gid = $('input[name=rgid]').val();
    var url = $('input[name=url]').val();
    if(gid =='' && url == ''){
        alert('请选择商品或者填写外链');
        return false;
    }
}

function goods_search(){
var tempUrl = "<?php echo U('Goods/goods/search_goods?prom_id=0') ?>";    
    var goodsid = "";
    var thumb="";
    art.dialog.open(tempUrl, {
        title: '设置商品的规格',
        background: '#ddd',
        opacity: 0.3,
        width: '875px',
        title: '选择商品',
        okVal:'确认所选商品',
        ok:function(iframeWin, topWin){
            var rs = $(iframeWin.document).find('.ids:checked');
            rs.each(function() {
                var data_id = $(this).attr('data-id');
                var data_name = $(this).attr('data-name');
                goodsid=data_id;
                name = data_name;
            });
            $('input[name="rgid"]').val(goodsid);
            $('.acti_near').text(name);
            $('input[name=url]').attr('disabled','disabled');
        }
    })
}
</script>
