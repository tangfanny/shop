<?php include $this -> admin_tpl('header'); ?>
<div class="content">
	 <div class="site">
         <a href="#">内容管理</a> > 添加广告
    </div>
    <script type="text/javascript" src="/statics/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/statics/js/Validform_v5.3.2_min.js"></script>
<script type="text/javascript" src="/statics/js/Validform_Datatype.js"></script>
<script type="text/javascript" src="/statics/js/artDialog/artDialog.js?skin=default"></script>
<script type="text/javascript" src="/statics/js/artDialog/plugins/iframeTools.js" ></script>
    <span class="line_white"></span>
    <div class="install mt10">
        <dl>
            <dt><a href="javascript:void(0)" class="hover">添加广告</a><a href="<?php echo U('Article_adv/lists') ?>">所有广告</a></dt>
            <form class="addform" name="addform" action="<?php echo U('Article_adv/update') ?>" method="post" autocomplete="off">
                <dd>
                    <ul class="webad">
                        <li>
                            <strong>广告标题：</strong>
                            <input type="text" name='title' datatype="*" class="text_inputAd" value='<?php echo $info["title"] ?>' style="margin-right: 50px; color:#3f3f3f"><span>广告标题：为设置的广告制定一个标题，广告标题只为识别辨认不同广告条目之用，并不在广告中显示</span>
                        </li>
                      <!--  <li>
                            <strong>产品分类：</strong>
                            <select name="class_id" style="margin-right: 50px; color:#3f3f3f">
                                <option value="0">--请选择--</option>
                                <?php /*foreach ($categorylist as $k=>$v):*/?>
                                <option value="<?php /*echo $v["id"]*/?>"<?php /*if($v["id"]==$info["class_id"]): */?><?php /*echo "selected"*/?> <?php /*endif;*/?>><?php /*echo $v["name"]*/?></option>
                                <?php /*endforeach;*/?>
                            </select>
                            <span>产品分类：为设置的广告制定一个产品分类，产品分类只为识别辨认不同分类条目之用，并不在广告中显示</span>
                        </li>-->
                        <li>
                            <strong>广告起始时间：</strong>
                            <input type="text" value="<?php echo isset($info["starttime"])?date('Y-m-d H:i:s', $info["starttime"]):date('Y-m-d H:i:s',NOW_TIME)?>" name="starttime" class="time_input" id="start" style="width:225px;margin-right: 50px;">
                            <span>设置广告起始生效的时间，格式 yyyy-mm-dd，留空为不限制起始时间</span>
                        </li>
                        <li>
                            <strong>广告结束时间：</strong>
                            <input type="text" value="<?php echo isset($info["endtime"])?date('Y-m-d H:i:s', $info["endtime"]):date('Y-m-d H:i:s', time()+30*86400)?>" name="endtime" class="time_input" id="end" style="width:225px;margin-right: 50px;">
                            <span>设置广告广告结束的时间，格式 yyyy-mm-dd，留空为不限制结束时间</span>
                        </li>
                        <li>
                            <strong>广告位置：</strong>
                           <input type="text" name='sort' datatype="*" class="text_inputAd" value='<?php echo $info["sort"] ?>' style="margin-right: 50px; color:#3f3f3f"><span>广告位置：为设置的广告位置，具体显示位置，例如1,2,3,4</span>
                        </li>
                        <li>
                            <strong>所属广告位：</strong>
                            <b style="margin-right: 52px;"><?php echo $adv_position['name']?$adv_position['name']:$info['position_name'] ?></b>
                            <span>设置本广告投放的页面，全局是指全站投放，部分广告位不能设置部分投放范围</span>
                        </li>
                        <li>
                            <strong>展现方式：</strong>
                            <b style="margin-right:52px;">
                                <label><input type="radio" name="type" value="1" > 连接 </label>
                                <label><input type="radio" name="type" value="2" > 文字 </label>
                                <label><input type="radio" name="type" value="3" > 代码 </label>
                                <label><input type="radio" name="type" value="4" > 商品 </label>
                            </b>
                            <span>请选择所需的广告展现方式</span>
                        </li>
                        <li>
                                <div id='ad_box'>
                               <div style='display:none'>
                                <strong>图片地址（必填）：</strong>
                                   <span id="app_url_span">
                                            <div class="upload_select">
                                                <input type="file" class="am-hide" id="pickfiles0" >
                                                <input type="hidden" class="upload_url" name="content" value="<?php echo $info['content'];?>">
                                                <div id="container">                                            </div >
                                                <div id="scan">
                                                    <?php if(is_numeric($info['content']) && strlen($info['content'])==18):?>
                                                    <img  src="<?php echo IMG_URL.Img_ADDRESS.$info['content'].'?imageView2/2/w/200 ';?>" class="preview"  id="imgpreview"/>
                                                    <?php elseif(empty($info['content'])): ?>
                                                        <img src="" class="preview" id="imgpreview" alt="">
                                                    <?php else: ?>
                                                    <img  src="<?php echo IMG_URL.$info['content'].'?imageView2/2/w/200' ;?>" class="preview"  id="imgpreview"/>
                                                    <?php endif;?>
                                                </div>
                                            </div>
                                        </span>
                                </div>
                                <div style='display:none'>
                                <strong>文字内容（必填）：</strong>
                                    <input type="text" name="text"  class="text_inputAd" style="margin-right: 50px; color:#3f3f3f" value="<?php if($info["type"]==2) echo $info['content'] ?>" /><span>请输入文字广告的内容</span>
                                </div>
                                <div style='display:none'>
                                <strong>代码内容（必填）：</strong>
                                    <textarea class='textarea' style="margin-right: 50px; color:#3f3f3f" name='code'><?php if($info["type"]==3) echo $info['content'] ?></textarea><span>请输入代码内容</span>
                                </div>
                                       <div style='display:none'>
                                <strong>选择商品：</strong>
                                    <a href="javascript:goods_search()" class="fl chooseBtn1"><img src="<?php echo IMG_PATH; ?>admin/order-50.png"/></a>
                                    <div id="goodsBaseBody">
                                        
                                        <?php if($info["goods_id"]!=0):?>
                                        <input type='hidden' id='goods_name' name='goods_name' value="<?php echo $info["goods_name"];?>">
                                        <input type='hidden' id='goods_id' name='goods_id' value="<?php echo $info["goods_id"];?>">
                                        <?php echo $info["goods_name"];?>
                                        <?php endif;?>
                                    </div>
                                    <ul style="border:none;">
                                    <li style="border:none;">
                                        <span  style="cursor:pointer" >选择APP广告图片</span>
                                        <span id="app_url_span">
                                            <div class="upload_select">
                                            <input type="file" class="am-hide" id="pickfiles1" >
                                            <input type="hidden" class="upload_url" name="app_url" value="<?php echo $info['app_url'];?>">
                                            <div id="container">                                            </div >
                                                <div id="scan">
                                                    <?php if(is_numeric($info['app_url']) && strlen($info['app_url'])==18):?>
                                                    <img  src="<?php echo IMG_URL.Img_ADDRESS.$info['app_url'].'?imageView2/2/w/200 ';?>" class="preview"  id="imgpreview"/>
                                                    <?php elseif(empty($info['app_url'])): ?>
                                                        <img src="" class="preview" id="imgpreview" alt="">
                                                    <?php else: ?>
                                                    <img  src="<?php echo IMG_URL.$info['app_url'].'?imageView2/2/w/200' ;?>" class="preview"  id="imgpreview"/>
                                                    <?php endif;?>
                                                </div>
                                            </div>
                                        </span>
                                    </li>
                                     <li style="border:none;">
                                        <span style="padding-left:20px;cursor:pointer;" >选择PC广告图片</span>
                                        <span id="pc_url_span">
                                                <div class="upload_select">
                                              <input type="file" class="am-hide" id="pickfiles2" >
                                                <input type="hidden" class="upload_url" name="web_url" value="<?php echo $info['web_url'];?>">
                                                <div id="container">                                                </div>
                                                    <div id="scan">
                                                        <?php if(is_numeric($info['web_url']) && strlen($info['web_url'])==18):?>
                                                        <img  src="<?php echo IMG_URL.Img_ADDRESS.$info['web_url'].'?imageView2/2/w/200 ';?>" class="preview" id="imgpreview1"/>
                                                        <?php elseif(empty($info['web_url'])): ?>
                                                            <img src="" class="preview" id="imgpreview1" alt="">
                                                        <?php else: ?>
                                                        <img  src="<?php echo IMG_URL.$info['web_url'].'?imageView2/2/w/200' ;?>" class="preview" id="imgpreview1"/>
                                                        <?php endif;?>
                                                    </div>
                                                </div>
                                        </span>
                                    </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div id='ad_box2'>
                                <div style="display:none" >
                                         <strong>图片链接（必填）：</strong>
                                         <input type="text" name="ilink" style="margin-right: 45px; color:#3f3f3f" class="text_inputAd" value="<?php if($info["type"]==1) echo $info['link'] ?>" /> <span>请输入图片广告指向的url链接地址</span>
                                </div>
                                <div style="display:none" >
                                         <strong>文字链接（必填）：</strong>
                                         <input type="text" name="tlink" style="margin-right: 45px; color:#3f3f3f" class="text_inputAd" value="<?php if($info["type"]==2) echo $info['link'] ?>" /> <span>请输入文字广告指向的url链接地址</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="submit">
                         <?php if(!empty($info)){ ?>
                            <input type="hidden" value="<?php echo $info['id'] ?>" name="id" />
                            <input type="hidden" value="edit" name="opt" />
                    	<?php }else{ ?>
                            <input type="hidden" value="add" name="opt" />
                            <input type="hidden" name="position_id" value="<?php echo $adv_position['id'] ?>">
                        <?php }; ?>
                            <input type="submit" class="button_search" value="提交"/>
							<a href="<?php echo U('lists')?>">返回</a>
                    </div>
                </dd>
            </form>
        </dl>
    </div>
    <?php include $this->admin_tpl('copyright'); ?>
</div>
    <!--编辑器开始-->
<script type="text/javascript" src="<?php echo JS_PATH; ?>artTemplate/artTemplate.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>artTemplate/artTemplate-plugin.js"></script>

<!--关联商品-->
<script type="text/javascript">
var tempUrl = "<?php echo U('Goods/goods/search_goods?prom_id=0') ?>";
function goods_search(){
	idArr = [];
        var goodsid = "";
        var goodsname="";
	$('[name="goods_id[]"]').each(function(){
		idArr.push($(this).val());
	})
	art.dialog.open(tempUrl, {
		title: '设置商品的规格',
		background: '#ddd',
		opacity: 0.3,
		width: '875px',
		title: '选择商品',
		okVal:'确认所选商品',
		ok:function(iframeWin, topWin){
			var rs = $(iframeWin.document).find('.ids:checked');
			goodsArr = [];
			rs.each(function() {
				var data_id = $(this).attr('data-id');
				var data_name = $(this).attr('data-name');
				var data_shop_price = $(this).attr('data-shop-price');
				var data_goods_number = $(this).attr('data-goods-number');
                                goodsid=data_id;
                                goodsname = data_name;
				if($.inArray(data_id, idArr) == -1){
					idArr.push(data_id)
					goodsArr.push({
						'id': data_id,
						'name': data_name,
						'shop_price': data_shop_price,
						'goods_number': data_goods_number
					});
				}
			});
//			var goodsRowHtml = template('goodsRowTemplate', {'templateData': goodsArr});
//                        alert(goodsRowHtml);
                        var  goodsRowHtml = "<input type='hidden' id='goods_name' name='goods_name' value="+goodsname+"><input type='hidden' id='goods_id' name='goods_id' value='"+goodsid+"'>"+goodsname;
			$('#goodsBaseBody').append(goodsRowHtml);
		}
	})
}
/**
 * 清空所选商品
 */
function delAll() {
	if (confirm('是否真要清空?')) {
		$("#goodsBaseBody tr").remove();
	}
}
</script>
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
		    //min: laydate.now(), //设定最小日期为当前日期
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
		    min: laydate.now(),
		    max: '2099-06-16 23:59:59',
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
    <script>
        //单选按钮点击绑定
        $('input:radio[name="type"]').each(
            function(i){
                $(this).click(function(){
                $('#ad_box>div').hide();
                   $('#ad_box>div:eq(' + i + ')').show();
                });
           }
        );
        $('input:radio[name="type"]').each(
            function(i){
                $(this).click(function(){
                $('#ad_box2>div').hide();
                   $('#ad_box2>div:eq(' + i + ')').show();
                });
           }
        );
        $(function() {
        $("#Validform_msg").hide();
        //表单验证
        var demo = $(".addform").Validform({
        btnSubmit: "#btn_sub",
            btnReset: ".btn_reset",
            tiptype:function(msg, o, cssctl){
                var e = o.obj.context.name;
                if (e.length > 1 && o.type == 3){
                    if (e == 'content'){
                        alert(msg);
                    }
                }
            },
            showAllError: false
        });
    });
    </script>
