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
             <a href="#">活动管理</a> > 创建活动 > 编辑商品
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
                                            <input type="text" class="text_input" name="name" placeholder='' datatype="*" value="<?php echo $info['name'];?>" /><span class="Validform_checktip ">设置商品品牌名称</span>
                                        </li>
                                        <li>
                                            <strong>关联商品：</strong>
                                            <input type="hidden" name="rgid" value="<?php echo $info['gid'];?>">
                                            <a href="javascript:goods_search()" class="fl chooseBtn1"><img src="<?php echo IMG_PATH; ?>admin/order-50.png"/></a>
                                        </li>                                        
                                        <li>
                                            <strong>网址：</strong>
                                            <input type="text" class="text_input" name="url" placeholder='' datatype="url" ignore="ignore" value="<?php echo $info['url'];?>" /><span class="Validform_checktip">设置品牌链接，请填写http://</span>
                                        </li>
                                        <li style="line-height:24px;">
                                            <strong>商品图片：</strong>
                                                                
                                            <b style="width:256px;">
                                                <input type="file" class="am-hide" id="pickfiles" >
                                                <input type="hidden" id='chengxing' name="path" value="<?php echo $info['path'];?>">
                                                <div id="container">
                                                    <div>
                                                        <?php if(is_numeric($info['path']) && strlen($info['path'])==18):?>
                                                            <img  src="<?php echo IMG_URL.Img_ADDRESS.$info['path'].'?imageView2/2/w/200 ';?>"  id="imgpreview"/>
                                                        <?php elseif(empty($info['path'])): ?>
                                                            <img src=""  id="imgpreview" alt="">
                                                        <?php else: ?>
                                                            <img  src="<?php echo IMG_URL.$info['path'].'?imageView2/2/w/200' ;?>"  id="imgpreview"/>
                                                        <?php endif;?>
                                                    </div>
                                                </div>
                                            </b><span>商品图片</span>
                                        </li>
                                        <li>
                                            <strong>是否添加标签：</strong>
                                            
                                                <?php foreach ($aLab as $k => $v): ?>
                                                    <input type="checkbox" name="tid[]" value="<?php echo $v['id']?>" <?php foreach ($arrT as $va) if ($v['id'] == $va): ?>checked="checked"<?php endif ?>/><?php echo $v['name']?>
                                                <?php endforeach ?>    
                                        </li>
<!--                                         <li>
                                            <strong>是否添加按钮：</strong>
                                            <input type="checkbox" name="pid[]" value="1" <?php if ($arrP[0] == 1): ?> checked="checked"<?php endif ?> />立即购买 
                                            <input type="checkbox" name="pid[]" value="2" <?php if ($arrP[1] == 2): ?> checked="checked"<?php endif ?> />加入购物车
                                            <span class="Validform_checktip"  style="margin-left:225px;">是否添加按钮</span>
                                        </li> -->
                                        <li>
                                            <strong>是否添加促销价：</strong>
                                            <input type="text" class="text_input" name="s_price" placeholder='输入原价，￥3200'  ignore="ignore" value="<?php echo $info['s_price']?>" /> 
                                            <input type="text" class="text_input" name="p_price" placeholder='输入促销价，￥1500' ignore="ignore" value="<?php echo $info['p_price']?>" />                                                                                  
                                        </li>                                       
                                        <li>
                                            <strong>排序：</strong>
                                            <input type="text" class="text_input" name="sort" placeholder=''  datatype="n" value="<?php echo $info['sort'];?>"/><span class="Validform_checktip" >输入数字显示排序，数字越小越靠前数字越大越靠后</span>
                                        </li>
                                    </ul>
                                    <div class="submit">
                                        <input type="hidden" name="id" value="<?php echo $info['id'] ?>" />
                                        <input type="hidden" name="cid" value="<?php echo $cid ?>"/>
                                        <input type="hidden" name="aid" value="<?php echo $id ?>"/>
                                        <input type="hidden" name="pid" value="<?php echo $pid ?>"/>
                                        <input type="submit" class='button_search' value='提交'/>
                                        <a href="<?php echo U('goodsList',array('id'=>"$id",'cid'=>"$cid"))?>">返回</a>
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
<!--关联商品-->
<script type="text/javascript">
var tempUrl = "<?php echo U('Goods/goods/search_goods?prom_id=0') ?>";
function goods_search(){
    var goodsid = "";
    var goodsname="";
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
                var data_shop_price = $(this).attr('data-shop-price');
                var data_goods_number = $(this).attr('data-goods-number');
                goodsid=data_id;
                goodsname = data_name;
                goodshoprice = data_shop_price;
            });
            $('input[name="rgid"]').val(goodsid);
            $('input[name="name"]').val(goodsname);
            $('input[name="s_price"]').val(goodshoprice);
        }
    })
}
function checkForm(){
    var s = $("input[name='tid[]']:checked").length;
    if(s>3){
        alert('不能超过3个标签');
        return false;
    }
}
</script>
