<?php include $this->admin_tpl('header'); ?>
<div class="content">
    <div class="site">
         <a href="#">站点设置</a> > 后台管理团队
    </div>
    <span class="line_white"></span>
    <div class="install mt10">
        <dl>
            <dt><a href="<?php echo U('AdminUser/index') ?>">团队列表</a><a href="javascript:void(0)" class="hover">添加团队</a></dt>
            <dd>
                <div class="install mt10">
                    <div class="install mt10">
                        <dl>
                            <form action="<?php echo U('AdminUser/reuserinfo') ?>" class="addform" method="post">
                                <dd>
                                    <ul class="web">
                                        <li>
                                            <strong>用户名：</strong>
              							    <input type="text" value="<?php echo current($user)["name"];?>" class="text_input" name="user" readonly >
                                      
                                            </span>
                                        </li>
                                
                                        <li>
                                            <strong>邮箱：</strong>
                                            <input type="text" class="text_input" value="<?php echo current($user)["email"];?>" name="email" placeholder=''  datatype="e" ignore="ignore" /><span class="Validform_checktip">填写管理员邮箱，格式为abc@abc.com</span>
                                        </li>
                                   		<li>
                                            <strong>手机：</strong>
                                            <input type="text" class="text_input" value="<?php echo current($user)["phone"];?>" name="phone" placeholder=''   ignore="ignore" /><span class="Validform_checktip">填写管理员手机，用于登录接收短息</span>
                                        </li>

                                        <li>
                                            <strong>工号：</strong>
                                            <input type="text" class="text_input" value="<?php echo current($user)["number"];?>" name="number" placeholder=''   ignore="ignore" /><span class="Validform_checktip">工号</span>
                                        </li>
                                        <li>
                                            <strong>部门：</strong>
                                            <input type="text" class="text_input" value="<?php echo current($user)["department"];?>" name="department" placeholder=''   ignore="ignore" /><span class="Validform_checktip">部门</span>
                                        </li>
                                        <li>
                                            <strong>性别：</strong>
                                            <select name="sex">
                                                
                                                <option value="1" <?php if(current($user)["sex"]==1):?>selected<?php endif;?>>男</option>
                                                <option value="2" <?php if(current($user)["sex"]==2):?>selected<?php endif;?>>女</option>
                                            </select>
                                        </li>
                                        <li>
                                            <strong>生日：</strong>
                                             <input type="text" value="<?php echo isset(current($user)["birthday"])?date('Y-m-d H:i:s', current($user)["birthday"]):date('Y-m-d H:i:s',NOW_TIME)?>" name="birthday" class="time_input" id="start" style="width:225px;margin-right: 50px;">
                                        </li>
                                        <li>
                                            <strong>身份证：</strong>
                                            <input type="text" class="text_input" value="<?php echo current($user)["identity"];?>" name="identity" placeholder=''   ignore="ignore" />
                                        </li>
                                        <li>
                                            <strong>QQ：</strong>
                                            <input type="text" class="text_input"value="<?php echo current($user)["qq"];?>" name="qq" placeholder=''   ignore="ignore" />
                                        </li>
                                        <li>
                                            <strong>婚姻情况：</strong>
                                            <select name="marriage">
                                                <option value="0" <?php if(current($user)["marriage"]==0):?>selected<?php endif;?>>否</option>
                                                <option value="1" <?php if(current($user)["marriage"]==1):?>selected<?php endif;?>>是</option>
                                            </select>
                                        </li>
                                    </ul>
                                    <div class="input1">
                                      	 <input type="hidden" name="id" id="id" value="<?php echo current($user)["id"]?>" />
                                         <input type="submit" class="button_search "  id="btn_sub" value="提交" />
                                    </div>
                                </dd>
                            </form>
                        </dl>
                    </div>
            </dd>
        </dl>
    </div>
    <script>
        /*$(function() {
            var demo = $(".addform").Validform({
                btnSubmit: "#btn_sub",
                btnReset: ".btn_reset",
                tiptype: function(){},
                label: ".label",
                showAllError: false,
                ajaxPost: true,
                callback: function(data) {
                    $("#Validform_msg").hide();
                    if (data.status == 0) {
                        art.dialog({width: 320, time: 5, title: '温馨提示(5秒后关闭)', content: data.info, ok: true});
                    }
                    if (data.status == 1) {
                        window.location.href = data.url;
                    }
                }
            });
        });*/
    </script>
    
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

  <?php include $this->admin_tpl('copyright') ?>