<?php include $this->admin_tpl("header"); ?>
<style type="text/css">
select option{padding: 2px}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>ns_common.css" />
    <!-- 内容区 -->
    <div class="content">
        <div id="top-alert" class="fixed alert alert-error" style="display: none;">
            <button class="close fixed" style="margin-top: 4px;">&times;</button>
            <div class="alert-content">这是内容</div>
        </div>
        <div class="site">
            <a href="#">商品管理</a> > 
            <a href="<?php echo U('lists')?>">资质证书</a>
            >
            <a href="javascript:location.replace(location.href);">添加证书</a>
        </div>
        <span class="line_white"></span>
    <div class="install mt10">
        <dl>
            <dd>
                <div class="install mt10">
                    <div class="install mt10">
                        <dl>
                            <form action="<?php echo U('Certificate/add');?>" class="addform" method="post">
                                <dd>
                                    <ul class="web">
                                        <li>
                                            <strong>商品品牌：</strong>
                                            <select name="brand_id" size="10" class="ns-select" style="height:193px;width:256px;" required="required">
                                                <?php foreach($brand as $vo){ ?>
                                                    <option value="<?php echo $vo['id']?>"><?php echo $vo['name']?></option>
                                                <?php } ?>
                                            </select>
                                            <span>选择品牌</span>
                                        </li>
                                        <li>
                                            <strong>证书类型：</strong>
                                            <select name="certificate_type" class="ns-select">
                                                <option value="1">公司</option>
                                                <option value="2">产品</option>
                                                <option value="3">其他</option>
                                            </select>
                                            <span>选择一项证书类型</span>
                                        </li>
                                        <li style="line-height:24px;">
				                            <strong>证书名称：</strong>
				                            <input type="text" class="text_input" name="certificate_name" required />
                                            填写证书名称
				                        </li>
                                        <li style="line-height:24px;">
                                            <strong>证书图片：</strong>
                                            <input type="file" class="am-hide" id="pickfiles" >
                                            <input type="hidden" id='chengxing' name="certificate_img">
                                            <div id="container">
                                                <img src="" id="imgpreview" alt="">
                                            </div>
                                        </li>
                                        <li>
                                        <dl class="gzzt clearfix mt10">
                                            <dd>
                                                <div class="time fl">
                                                    <strong>开始时间：</strong>
                                                    <input type="text" id="start" name='start_time' value='<?php echo date('Y-m-d H:i:s',NOW_TIME)?>' style='width:130px' />
                                                    <strong>结束时间：</strong>
                                                    <input type="text" id="end" name='end_time' value='<?php echo date('Y-m-d H:i:s', time()+30*86400)?>' style='width:130px' />
                                                    </select>
                                                </div>
                                            </dd>
                                        </dl>
                                        </li>
                                        <li class="submit">
                                            <input type="submit" class='button_search' value='提交'/>
                                            <a href="<?php echo U('lists')?>">返回</a>
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
<!--时间选择-->
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
    <!--编辑器开始-->
<script type="text/javascript" src="<?php echo __QINIU__;?>plupload/js/plupload.full.min.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>plupload/js/i18n/zh_CN.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>ui.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>qiniu.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>highlight.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>main-upload.js"></script>
    <script>
        /**
         *初始化
         */
        $(function(){
            var tabTitle = ".tabs dt a";
            var tabContent = ".tabs dd";
            $(tabTitle+":last").one("click",function(){
                $.getScript("<?php echo JS_PATH;?>image-upload/upload.js");
            });
        })

       
</script>
</body>
</html>