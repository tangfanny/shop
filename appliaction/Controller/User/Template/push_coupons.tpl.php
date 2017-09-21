<?php include $this->admin_tpl('header'); ?>
<div class="content">
    <div class="site">
         <a href="#">会员管理</a> > 群发优惠券
    </div>
    <span class="line_white"></span>
    <div class="goods mt10">
    	  <form class="addform" name="addform" action="<?php echo U('PushCoupons/lists'); ?>" method="post" autocomplete="off" submit="javascript:return false">
        <div class="vip_ss">
            <p>
                <strong>搜索会员：</strong>
                <input type="text" name='keyword' placeholder="输入会员邮箱/手机号" class="input" />
                <input type="button" value="查询" class="button_search"/>
            </p>
            <ul>
                <li class='vip_group'>
                    <strong>注册时间：</strong>
                    <a href="javascript:" class="hover" data='7'>最近7天</a>
                    <a href="javascript:" data='30'>最近30天</a>
                    <a href="javascript:" data='90'>最近90天</a>
                    <a href="javascript:" data='180'>最近180天</a>
                    <a href="javascript:" data='365'>最近1年</a>
                    <a href="javascript:" data='0'>自定义</a>
                    <strong id="stimestrong" style="display: none;">起始时间：</strong>
                    <input    type="text" value="<?php echo isset($info["starttime"])?date('Y-m-d H:i:s', $info["starttime"]):date('Y-m-d H:i:s',NOW_TIME)?>" name="starttime" class="time_input" id="start" style="width:200px;margin-right: 50px;display: none;">
                    <strong id="etimestrong" style="display: none;">结束时间：</strong>
                    <input    type="text" value="<?php echo isset($info["endtime"])?date('Y-m-d H:i:s', $info["endtime"]):date('Y-m-d H:i:s', time()+30*86400)?>" name="endtime" class="time_input" id="end" style="width:200px;margin-right: 50px;display: none;">
                    <span style="margin-right:161px;">[选择发放优惠券的会员注册时间]</span>
                </li>
                <li class='vip_order'>
                    <strong>订单数量：</strong>
<!--                    <a href="javascript:" data='0' class="hover">全部</a>
                    <a href="javascript:" data='7'>最近7天</a>
                    <a href="javascript:" data='30'>最近30天</a>
                    <a href="javascript:" data='90'>最近90天</a>
                    <a href="javascript:" data='180'>最近180天</a>
                    <a href="javascript:" data='365'>最近1年</a>-->
                    <select id="ordercount" name="ordercount">
                        <option value="0">请选择</option>
                        <option value="1">大于</option>
                        <option value="2">小于</option>
                        <option value="3">等于</option>
                    </select>
                    <input name="ordercount_sum" value="" id="ordercount_sum" type="text" class="input" placeholder="订单总数量" style="width: 100px;height: 24px;margin-top: 1px;"/>
                    <span style="margin-right:161px;">[选择最近时间段有过消费记录的会员]</span>
                </li>
                 <li class='vip_order'>
                    <strong>订单金额：</strong>
<!--                    <a href="javascript:" data='0' class="hover">全部</a>
                    <a href="javascript:" data='7'>最近7天</a>
                    <a href="javascript:" data='30'>最近30天</a>
                    <a href="javascript:" data='90'>最近90天</a>
                    <a href="javascript:" data='180'>最近180天</a>
                    <a href="javascript:" data='365'>最近1年</a>-->
                    <select id="ordermoyen" name="ordermoyen">
                        <option value="0">请选择</option>
                        <option value="1">大于</option>
                        <option value="2">小于</option>
                        <option value="3">等于</option>
                    </select>
                    <input name="ordermoyen_sum" value="" id="ordermoyen_sum" type="text" class="input" placeholder="订单总金额" style="width: 100px;height: 24px;margin-top: 1px;"/>
                    <span style="margin-right:161px;">[选择最近时间段有过消费记录的会员]</span>
                </li>
            </ul>
        </div>
        <div class="vip_tj mt10 clearfix">
            <strong>会员<br />统计</strong><b>共发放优惠券会员数量：<font class="member_num">0</font></b><span style="margin-right:93px;">请选择发放优惠券的会员条件，系统将计算共发放优惠券数量</span>
            <input type="hidden" datatype="*" name="member_num">
            <input type="hidden" datatype="*" name="member_id">
        </div>
        <div class="vip_fa mt10 clearfix">
            <strong>优惠发放：</strong>
            <ul>
                <li><span>派发优惠券</span><select name="coupons_id">
                            <?php foreach ($coupons_list as $key => $vo): ?>
                          	<?php if($vo['num'] == 0):?>
                          		<optgroup label="<?php echo $vo['name']; ?>(<?php echo $vo['num']; ?>)" /></optgroup>
                          	<?php else:?>
                          		<option value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?>(<?php echo $vo['num']; ?>)</option>
                          	<?php endif;?>
                         <?php endforeach ?>
                    </select>
                </li>
                <li><span>派发数量</span><input type="text" name="push_num" value=" 1" datatype="n" class="input" /></li>
            </ul>
            <p>请先选择优惠券，再选择发放数量，优惠券需要先进入优惠券管理设置</p>
        </div>
        <div class="submit">
            <a href="javascript:void(demo.submitForm(false))">发 送</a><a href="<?php echo U('PushCoupons/lists'); ?>">取 消</a>
        </div>
        </form>
    </div>
      <?php include $this->admin_tpl('copyright'); ?>
</div>
    <script type="text/javascript" src="<?php echo JS_PATH; ?>Editor/kindeditor-min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>Editor/lang/zh_CN.js"></script>
<?php echo jsfile('hddate');?>
	<?php echo jsfile('hdvalid');?>
    <script>
        var demo;
        $(function() {
            //搜索
            $(".button_search").click(function() {
                keyword = $(this).prev().val();
                if (keyword.length == 0) {
                    $(this).prev().focus();
                    alert('搜索内容不能为空');
                    return;
                }
                $.get("<?php echo U('PushCoupons/search_user/?opt=search'); ?>", {"keyword": keyword.toString()}, function(data) {
                    if (data.status == 0) {
                        art.dialog.tips('无法查到此信息');
                        return;
                    } else {
                        //console.log(data);
                        $(".vip_ss > ul").html("<li><strong>会员信息：</strong>会员名："+data.nikename+" 邮箱："+data.email+" 手机："+data.mobile+"</li>");
                        $(".member_num").html("1");$("input[name='member_num']").val(1);$("input[name='member_id']").val(data.id);
                    }
                })
            })
             //会员等级
            $(".vip_group >a,.vip_order >a").click(function(){
                $(this).siblings().removeClass("hover");
                $(this).addClass("hover");
                getmember();
            });
            //商品分类
            $(".category_id").change(function(){
                getmember();
            });
            //品牌列表
            $(".brand_id").change(function(){
                getmember();
            });
           
           //订单数量获取
           $("#ordercount").change(function(){
                getmember();
            });
            //获取订单总数量
            $("#ordercount_sum").blur(function(){
                getmember();
            });
            
             //订单数量获取
           $("#ordermoyen").change(function(){
                getmember();
            });
            //获取订单总数量
            $("#ordermoyen_sum").blur(function(){
                getmember();
            });
            
            //表单验证
            demo = $(".addform").Validform({
                tiptype: function(msg, o, cssctl) {
                    var e = o.obj.context.name;
                    if (e.length > 1 && o.type == 3) {
                        if (e == 'member_num') {
                            alert('没有设置获赠会员！');
                        }
                    }
                },
                showAllError: false
            });
            function getmember(){

            	//取值操作
                var group_id=$(".vip_group >a.hover").attr('data');
                group_id = group_id?group_id:0;
                var order_time=$(".vip_order >a.hover").attr('data');  
                var order_count = $("#ordercount option:selected").val();//订单总数量
                var order_count_num = $("#ordercount_sum").val();//订单购买数量
                var order_moyen = $("#ordermoyen option:selected").val();//订单总金额
                var order_moyen_sum = $("#ordermoyen_sum").val();//点单钱
                if(group_id==0){
                    $("#stimestrong").show();
                    $("#start").show();
                    $("#etimestrong").show();
                    $("#end").show();
                    var start = $("#start").val();
                    var end = $("#end").val();
                }else{
                    $("#stimestrong").hide();
                    $("#start").hide();
                    $("#etimestrong").hide();
                    $("#end").hide();
                }
                order_time = order_time?order_time:0;
                var category=$(".category_id").val();
                category = category?category:0;
                var brand_id=$(".brand_id").val();
                brand_id = brand_id?brand_id:0;
                var url = "<?php echo U('PushCoupons/search_user/?opt=search'); ?>";
                $.get(url, {"order_moyen":order_moyen,"order_moyen_sum":order_moyen_sum,"order_count":order_count,"order_count_num":order_count_num,"group_id": group_id.toString(),"order_time": order_time.toString(),"cat_ids": category.toString(),"brand_id":brand_id.toString(),"start":start,"end":end}, function(data) {
                    if (data.status == 0) {
                        $(".member_num").html(0);$("input[name='member_num']").val("");$("input[name='member_id']").val("")
                        art.dialog.tips('无法查到此信息');
                        return;
                    } else {
                        $(".member_num").html(data.count);$("input[name='member_num']").val(data.count);$("input[name='member_id']").val(data.ids);
                    }
                })
            }
            //打开默认选择所有会员
           $(".vip_group >a:first").trigger("click");
           var start = {
		    elem: '#start',
		    format: 'YYYY-MM-DD hh:mm:ss',
		    //min: laydate.now(), //设定最小日期为当前日期
		    max: '2099-06-16 23:59:59', //最大日期
		    istime: true,
		    istoday: true,
		    choose: function(datas){
		         end.min = datas; //开始日选好后，重置结束日的最小日期
		         end.start = datas; //将结束日的初始值设定为开始日
                         getmember();
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
                        getmember();
		    }
		};
		laydate(start);
		laydate(end);
        })
    </script>

    <!--日期控件-->
