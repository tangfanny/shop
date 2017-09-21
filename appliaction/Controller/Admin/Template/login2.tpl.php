<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title></title>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>admin/login.css" />
<!--[if IE 6]>
<script type="text/javascript" src="<?php echo JS_PATH; ?>DD_belatedPNG.js" ></script>
<script type="text/javascript">
DD_belatedPNG.fix('*');
</script>
<![endif]-->
<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH ?>jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH ?>Validform_v5.3.2_min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH ?>artDialog/artDialog.js?skin=default"></script>
</head>
<style type="text/css">
	#Validform_msg{display: none;}
	.Validform_error {
		background-color: #fffbea;
		border: 1px solid #e9bb89;
	}
</style>
<body>
	<div class="main">
		<div class="login">
			<div class="left">
				
			</div>
			<div class="right">
                    <form action="" method="" name="" id="" class="loginform">
				<p>
					<label>用户名：</label><input type='text' id="username" name="username" class="Inpt" datatype="*3-10|/^[\u4E00-\u9FA5\uf900-\ufa2d]{2,4}$/"/>
				</p>
				<p>
					<label>密&nbsp;&nbsp;&nbsp;码：</label><input type='password' name="userpass"  class="Inpt" datatype="*"/>
				</p>
				<p>
					<label>口&nbsp;&nbsp;&nbsp;令：</label><input type='text' name="code" class="captcha" placeholder="口令" datatype="*"/>
					&nbsp;&nbsp;&nbsp;<button onclick="sentVerifyCode(this)">&nbsp;&nbsp;获 取&nbsp;&nbsp;</button>
				</p>
				<p>
					<label>验证码：</label><input type='text' name="userverify" class="captcha" datatype="/\w{4}/i" errormsg="验证码" />
                    &nbsp;&nbsp;&nbsp;<img src="<?php echo U('verify') ?>" id="verify" alt="验证码" style="cursor: pointer; vertical-align:middle; margin-top:-4px!important;maargin-top:-0px" onclick="this.src='<?php echo U('verify') ?>&_t=' + Math.round(new Date().getTime()/1000)" />
				</p>
				<p>
					<label></label><input type="submit" name="" value="login" class="Btn" style="color:#fff" />
				</p>
				</form>
			</div>
		</div>
	</div>
<script type="text/javascript">
var demo=$(".loginform").Validform({
        tiptype: function(){},
        label:".label",
        showAllError:true,
        ajaxPost:true,
        callback:function(ret){
        	if(ret.status != 1) {
        		$('#verify').trigger('click');
        		art.dialog({width: 320,time: 6,title:'Reminder: 6 seconds after closing',content: ret.info,ok:true});
        	} else {
          		window.location.href=ret.url;
        		return;
        	}
        }
});
if (top.location !== self.location) {
    top.location=self.location;
}
function sentVerifyCode(ev){
		
        var username = $("#username").val();
        if(username==""){return;}
        $.post("<?php echo U('Public/SendCode'); ?>",{
                username:username,
            }, function (data) {
                if(data=1){
                    alert("success !");
                    var time = 60;
                    var btn = ev;
                    $(ev).html(time);
                    $(ev).attr("disabled",true);
                    var s = setInterval(function(){
                        time = time -1;
                        $(ev).html(time);
                        if(time == 0){
                            clearInterval(s);
                            $(ev).removeAttr("disabled").html("获取");
                        }
                    },1000);
                }else{
                    alert('error !');
                }
    });
}
</script>
</body>
</html>