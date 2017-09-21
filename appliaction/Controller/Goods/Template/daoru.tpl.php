<?php include $this->admin_tpl("header"); ?>
<div class="content">
    <style>
        #Validform_msg{display: none}
    </style>
    <div id="top-alert" class="fixed alert alert-error" style="display: none;">
        <button class="close fixed" style="margin-top: 4px;">&times;</button>
        <div class="alert-content">这是内容</div>
    </div>
    <div class="site">
          <a href="#">订单管理</a> > 线下订单导入 > 线下订单导入
    </div>
    <span class="line_white"></span>
    <div class="install mt10">
        <dl>
             <dd>
                <div class="install mt10">
                    <div class="install mt10">
                        <dl>
                            <form action="<?php echo U('OrderDd/save_daoru')?>" class="addform" method="post">
                                <dd>
                                    <ul class="web">
                                        <li>
                                            <strong>用户手机：</strong>
                                            <input type="text" class="text_input" name="mobile" value="" placeholder='' datatype="*"/><span style="padding-left: 52px;" class="Validform_checktip ">填写用户手机号</span>
                                        </li> 
                                         <li>
                                            <strong>订单编号：</strong>
                                            <input type="text" class="text_input" name="order_sn" value="" placeholder='' datatype="*"/><span style="padding-left: 52px;" class="Validform_checktip ">请填写订单编号</span>
                                        </li> 
                                        <li>
                                            <strong>收货人姓名：</strong>
                                            <input type="text" class="text_input" name="accept_name" placeholder=''  value="" /><span class="Validform_checktip" style="margin-left:2px;">填写收货人姓名</span>
                                        </li>
                                        <li>
                                            <strong>邮编：</strong>
                                            <input type="text" class="text_input" name="zipcode"  value="" placeholder=''  datatype="n" value="100" /><span class="Validform_checktip" style="margin-left:2px;">填写邮编</span>
                                        </li>
                                        <li>
                                            <strong>收货人电话：</strong>
                                            <input type="text" class="text_input" name="telphone"  value="" placeholder=''  /><span class="Validform_checktip" style="margin-left:2px;">收货人电话</span>
                                        </li>
                                         <li>
                                            <strong>省：</strong>
                                            <input type="text" class="text_input" name="province"  value="" placeholder=''  /><span class="Validform_checktip" style="margin-left:2px;">省</span>
                                        </li>
                                        <li>
                                            <strong>城市：</strong>
                                            <input type="text" class="text_input" name="city"  value="" placeholder=''  /><span class="Validform_checktip" style="margin-left:2px;">城市</span>
                                        </li>
                                       <li>
                                            <strong>地区：</strong>
                                            <input type="text" class="text_input" name="area"  value="" placeholder=''  /><span class="Validform_checktip" style="margin-left:2px;">地区</span>
                                        </li>
                                        <li>
                                            <strong>详细地址：</strong>
                                            <input type="text" class="text_input" name="address"  value="" placeholder=''  /><span class="Validform_checktip" style="margin-left:2px;">详细地址</span>
                                        </li>
                                        <li>
                                            <strong>订单金额：</strong>
                                            <input type="text" class="text_input" name="payable_amount"  value="" placeholder=''  /><span class="Validform_checktip" style="margin-left:2px;">订单金额</span>
                                        </li>
                                        <li>
                                            <strong>分期百分比：</strong>
                                            <input type="text" class="text_input" name="staging"  value="" placeholder=''  /><span class="Validform_checktip" style="margin-left:2px;">分期百分比，多个已半角逗号进行分割，例如30,50,20</span>
                                        </li>
                                        <li>
                                            <strong>分期金额：</strong>
                                            <input type="text" class="text_input" name="staging_money"  value="" placeholder=''  /><span class="Validform_checktip" style="margin-left:2px;">分期金额，多个已半角逗号进行分割，例如228000.00,304000.00,152000.00,76000.00</span>
                                        </li>
                                        <li>
                                            <strong>订单时间：</strong>
                                            <input type="text" class="text_input" name="cretae_time"  value="" placeholder=''  /><span class="Validform_checktip" style="margin-left:2px;">订单时间，例如2015/10/8 12:40:44</span>
                                        </li>
                                        <li>
                                            <strong>商品名称：</strong>
                                            <textarea name="goods_name" rows="4" cols="20"></textarea><span style="padding-left: 0px;">商品名称多个用小写半角逗号分割，是这样的","不是这样的"，"</span>
                                        </li>  
                                        <li>
                                            <strong>购买数量：</strong>
                                            <input type="text" class="text_input" name="goods_num"  value="" placeholder=''  /><span class="Validform_checktip" style="margin-left:2px;">商品名称多个用小写半角逗号分割，是这样的","不是这样的"，"</span>
                                        </li>
                                        <li>
                                            <strong>商品规格：</strong>
                                            <textarea name="products_sn" rows="4" cols="20"></textarea><span style="padding-left: 0px;">商品规格名称多个用小写半角逗号分割，是这样的","不是这样的"，"具体格式是"NU145689986386-1"</span>
                                        </li>    
                                    </ul>
                                    <div class="submit">
                                        <input type="hidden" name="id" value="<?php echo $data['id'] ?>" />
                                        <input type="hidden" name="old_pid" value="<?php echo $data['parent_id'] ?>" />
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
</div>
<script>
    $(function() {

        var demo = $(".addform").Validform({
            btnSubmit: "#btn_sub",
            btnReset: ".btn_reset",
            tiptype: function(){},
            label: ".label",
            showAllError: false,
            ajaxPost: true,
            callback: function(data) {
                $("#Validform_msg").hide();
                if (data.status == "0") {
                    art.dialog({width: 320, time: 5, title: '温馨提示(5秒后关闭)', content: data.info, ok: true});
                }
                if (data.status == "1") {
                    window.location.href = data.url;
                }
            }
        });
    });
</script>
</body>
</html>