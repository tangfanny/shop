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
        <a href="#">运营推广</a> > <a href="<?php echo U('lists')?>">品牌排行榜管理</a> > 编辑排行榜信息
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
                    <form action="<?php echo U('BrandRank/edit')?>"  method="post" class="editform" autocomplete="off">
                        <dd>
                            <ul class="web">
                                <input type="hidden" class="text_input" name="id"  value="<?php echo $id ?>"  />
                                <input type="hidden" class="text_input" name="brand_name"  value="<?php echo $name['b_name'] ?>"/>
                                <li>
                                    <strong>显示销量：</strong>
                                    <input type="text" class="text_input" name="display_sale"  value="<?php echo $day_data['display_sale'] ?>"  datatype="*"/><span style="padding-left: 80px;" >显示销量</span>
                                </li>
                                <li>
                                    <strong>销量日增率：</strong>
                                    <input type="text" class="text_input" name="sale_rate"  value="<?php echo $edit_data['sale_rate'] ?>"  datatype="n1-3"/><span style="padding-left: 80px;" >销量日增率</span>
                                </li>
                                <li>
                                    <strong>销量增长起始时间：</strong>
                                    <input type="text" class="time_input" name="sale_start_time" id="start"  value="<?php echo isset($edit_data["sale_start_time"])?date('Y-m-d H:i:s', $edit_data["sale_start_time"]):date('Y-m-d H:i:s',NOW_TIME)?>" style="width:225px;margin-right: 50px;" />
                                    <span style="padding-left: 80px;" >设置销量增长起始生效的时间，格式 yyyy-mm-dd，留空为不限制起始时间</span>
                                </li>
                                <li>
                                    <strong>销量增长结束时间：</strong>
                                    <input type="text" class="time_input" name="sale_end_time"  id="end" value="<?php echo isset($edit_data["sale_end_time"])?date('Y-m-d H:i:s', $edit_data["sale_end_time"]):date('Y-m-d H:i:s',time()+30*86400)?>" style="width:225px;margin-right: 50px;"/>
                                    <span style="padding-left: 80px;" >设置销量增长结束生效的时间，格式 yyyy-mm-dd，留空为不限制起始时间</span>
                                </li>
                                <li>
                                    <strong>显示人气：</strong>
                                    <input type="text" class="text_input" name="display_hit"  value="<?php echo $day_data['display_hit'] ?>"  /><span style="padding-left: 80px;" >显示人气</span>
                                </li>
                                <li>
                                    <strong>人气日增率：</strong>
                                    <input type="text" class="text_input" name="hit_rate"  value="<?php echo $edit_data['hit_rate'] ?>"  datatype="n1-3"/><span style="padding-left: 80px;" >人气日增率</span>
                                </li>
                                <li>
                                    <strong>人气增长起始时间：</strong>
                                    <input type="text" class="time_input" name="hit_start_time"  id="start1" value="<?php echo isset($edit_data["hit_start_time"])?date('Y-m-d H:i:s', $edit_data["hit_start_time"]):date('Y-m-d H:i:s',NOW_TIME)?>" style="width:225px;margin-right: 50px;" /><span style="padding-left: 80px;" >设置人气增长起始生效的时间，格式 yyyy-mm-dd，留空为不限制起始时间</span>
                                </li>
                                <li>
                                    <strong>人气增长结束时间：</strong>
                                    <input type="text" class="time_input" name="hit_end_time"  id="end1" value="<?php echo isset($edit_data["hit_end_time"])?date('Y-m-d H:i:s', $edit_data["hit_end_time"]):date('Y-m-d H:i:s',time()+30*86400)?>" style="width:225px;margin-right: 50px;" /><span style="padding-left: 80px;" >设置人气增长起始生效的时间，格式 yyyy-mm-dd，留空为不限制起始时间</span>
                                </li>
                            </ul>
                            <div class="submit">
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
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>Editor/themes/default/default.css">
<script type="text/javascript" src="<?php echo JS_PATH; ?>Editor/kindeditor-min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>Editor/lang/zh_CN.js"></script>
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
            istime: true,
            istoday: true,
            choose: function(datas){
                start.max = datas; //结束日选好后，重置开始日的最大日期
            }
        };
        laydate(start);
        laydate(end);
    });
    $(function() {
        var start = {
            elem: '#start1',
            format: 'YYYY-MM-DD hh:mm:ss',
            festival: true, //显示节日
            istime: true,
            istoday: true,
            choose: function(datas){ //选择日期完毕的回调
                return datas;
            }
        };
        var end = {
            elem: '#end1',
            format: 'YYYY-MM-DD hh:mm:ss',
            festival: true, //显示节日
            istime: true,
            istoday: true,
            choose: function(datas){
                start.max = datas; //结束日选好后，重置开始日的最大日期
            }
        };
        laydate(start);
        laydate(end);
    });
    //表单验证
    var demo = $(".editform").Validform({
        btnSubmit: "#btn_sub",
        tiptype: 3,
        ajaxPost: true,
        showAllError: false,
        callback: function(data) {
            $("#Validform_msg").hide();
            if (data.status == "0") {
                art.dialog({width: 320, time: 5, title: '温馨提示(5秒后关闭)', content: data.info, ok: true});
            }
            if (data.status == "1") {
                window.location.href = '<?php echo U('lists') ?>';
            }
        }
    });
</script>
