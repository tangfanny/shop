<?php include $this->admin_tpl('header'); ?>
<div class="content">
    <div class="site">
         <a href="#">站点设置</a> > <a href="javascript:location.replace(location.href);">后台管理团队</a>
    </div>
    <span class="line_white"></span>
    <div class="install mt10">
        <dl>
            <dt><a href="<?php echo U('AdminUser/index') ?>">团队列表</a><a href="javascript:void(0)" class="hover">添加团队</a></dt>
            <dd>
                <div class="install mt10">
                    <div class="install mt10">
                        <dl>
                            <form action="<?php echo U('AdminUser/add') ?>" class="addform" method="post">
                                <dd>
                                    <ul class="web">
                                        <li>
                                            <strong>用户名：</strong>
                                            <input type="text" class="text_input" name="name" placeholder='' datatype="/^[A-Za-z0-9]+$/" /><span class="Validform_checktip ">请填写管理员用户名，支持英文和数字
                                            </span>
                                        </li>
                                        <li>
                                            <strong>用户密码：</strong>
                                            <input type="text" class="text_input" name="password" placeholder=''  datatype="*4-10"/><span class="Validform_checktip">请填写管理员后台登录密码，请包涵英文和数字，4-10位</span>
                                        </li>
                                        <li>
                                            <strong>确认密码：</strong>
                                            <input type="text" class="text_input" name="password2" placeholder='' datatype="*" recheck="password"/><span class="Validform_checktip">核对密码，确保两次密码输入正确</span>
                                        </li>
                                        <li>
                                            <strong>邮箱：</strong>
                                            <input type="text" class="text_input" name="email" placeholder=''  datatype="e" ignore="ignore" /><span class="Validform_checktip">填写管理员邮箱，格式为abc@abc.com</span>
                                        </li>
                                        <li>
                                            <strong>手机：</strong>
                                            <input type="text" class="text_input" name="phone" placeholder=''   ignore="ignore" /><span class="Validform_checktip">填写管理员手机，用于登录接收短息</span>
                                        </li>

                                        <li>
                                            <strong>工号：</strong>
                                            <input type="text" class="text_input" name="number" placeholder=''   ignore="ignore" /><span class="Validform_checktip">工号</span>
                                        </li>
                                        <li>
                                            <strong>部门：</strong>
                                            <input type="text" class="text_input" name="department" placeholder=''   ignore="ignore" /><span class="Validform_checktip">部门</span>
                                        </li>
                                        <li>
                                            <strong>性别：</strong>
                                            <select name="sex">
                                                <option value="1">男</option>
                                                <option value="2">女</option>
                                            </select>
                                        </li>
                                        <li>
                                            <strong>生日：</strong>
                                              <input type="text" class="text_input" name="birthday" placeholder=''  id="start"   ignore="ignore" />
                                        </li>
                                        <li>
                                            <strong>身份证：</strong>
                                            <input type="text" class="text_input" name="identity" placeholder=''   ignore="ignore" />
                                        </li>
                                        <li>
                                            <strong>QQ：</strong>
                                            <input type="text" class="text_input" name="qq" placeholder=''   ignore="ignore" />
                                        </li>
                                        <li>
                                            <strong>婚姻情况：</strong>
                                            <select name="marriage">
                                                <option value="0">否</option>
                                                <option value="1">是</option>
                                            </select>
                                        </li>
                                    </ul>
                                    <div class="input1">
                                         <input type="button" class="button_search "  id="btn_sub" value="提交" />
                                    </div>
                                </dd>
                            </form>
                        </dl>
                    </div>
            </dd>
        </dl>
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
                    if (data.status == 0) {
                        art.dialog({width: 320, time: 5, title: '温馨提示(5秒后关闭)', content: data.info, ok: true});
                    }
                    if (data.status == 1) {
                        window.location.href = data.url;
                    }
                }
            });
        });
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