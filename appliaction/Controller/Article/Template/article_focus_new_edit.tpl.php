<?php include $this->admin_tpl("header"); ?>
<div class="content">
    <style>
        #Validform_msg{display: none}
    </style>
    <div id="top-alert" class="fixed alert alert-error" style="display: none;">
        <button class="close fixed" style="margin-top: 4px;">&times;</button>
        <div class="alert-content">内容管理</div>
    </div>
    <div class="site">
        <a href="#">内容管理</a> > 首页幻灯片列表 > 编辑首页幻灯片信息
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
                    <form action="<?php echo U('Article_focus_new_edit/edit')?>" class="addform" method="post" autocomplete="off">
                        <dd>
                            <ul class="web">
                                <li>
                                    <strong>图片地址：</strong>
                                    <input type="text" class="text_input" name="name"  value="<?php echo $info['pic'] ?>"  datatype="*"/><span style="padding-left: 80px;" >填写商品分类名称</span>
                                </li>
                                <li>
                                    <strong>分享图标：</strong>
                                    <input type="radio" name="app_flag" value="<?php echo $info['path'] ?>" "/>
                                    <span class="Validform_checktip" style="margin-left:256px;">选中否，按钮将不在前台中出现，默认为显示</span>
                                </li>
                                <li>
                                    <strong>连接地址：</strong>
                                    <input type="text" class="text_input" name="sort" placeholder=''  datatype="n" value="<?php echo $info['url'] ?>" />
                                    <span class="Validform_checktip" style="margin-left:26px;">输入数字改变按钮显示排序，数字越小越靠前</span>
                                </li>
                                <li>
                                    <strong>图片标题：</strong>
                                    <input type="text" class="time_input" name="create_time"  id="create"  value="<?php echo isset($info["create_time"])?date('Y-m-d H:i:s', $info["create_time"]):date('Y-m-d H:i:s',time()+30*86400)?>" style="width:225px;margin-right: 50px;"/>
                                    <span  style="margin-left:29px;">设置按钮创建的时间，格式 yyyy-mm-dd</span>
                                </li>
                                <li>
                                    <strong>是否显示：</strong>
                                    <input type="radio" name="app_flag" value="<?php echo $info['status'] ?>" onpropertychange="statusChange(this,change);"/>是
                                    <input type="radio" name="app_flag" value="<?php echo $info['status'] ?>"  style="margin-left:20px;" /> 否
                                    <span class="Validform_checktip" style="margin-left:256px;">选中否，按钮将不在前台中出现，默认为显示</span>
                                </li>
                            </ul>
                            <div class="submit">
                                <?php if(!empty($info)){ ?>
                                    <input type="hidden" value="<?php echo $info['id'] ?>" name="id" />
                                    <input type="hidden" value="edit" name="opt" />
                                <?php }else{ ?>
                                    <input type="hidden" value="add" name="opt" />
                                    <input type="hidden" name="app_button_id" value="<?php echo $article_app_button['id'] ?>">
                                <?php }; ?>
                                <input type="submit" class="button_search" value="提交"/>
                                <a href="<?php echo U('lists')?>">返回</a>
                            </div>
                        </dd>
                    </form>
            </div>
        </dl>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>Editor/themes/default/default.css">
<script type="text/javascript" src="<?php echo JS_PATH; ?>Editor/kindeditor-min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>Editor/lang/zh_CN.js"></script>
<!--日期控件-->
<?php echo jsfile('hddate');?>
<?php echo jsfile('hdvalid');?>
<script>
    function  statusChange(status,id){
        if(status.checked){
            id.style.display = 'block';
        }else{
            id.style.display = 'none';
        }
    }
    KindEditor.ready(function(K){
        editor = K.editor({
            uploadJson : '<?php echo U("Admin/Editor/upload?SSID=",'','');?>'+'<?php echo C("SSID");?>',
            fileManagerJson : '<?php echo U("Admin/Editor/file_manage?parentdir=article/",'','');?>',
            extraFileUploadParams: {
                PHPSESSID : '<?php echo session_id() ?>',
                parentdir : 'app_button/'
            },
            allowFileManager: true
        });
        //给按钮添加click事件
        $('.upimg').live('click', function() {
            var self = $(this);
            editor.loadPlugin('image', function() {
                //图片弹窗的基本参数配置
                editor.plugin.imageDialog({
                    imageUrl : self.prev("input").val(), //如果图片路径框内有内容直接赋值于弹出框的图片地址文本框
                    showRemote : false,
                    //点击弹窗内”确定“按钮所执行的逻辑
                    clickFn : function(url, title, width, height, border, align) {
                        self.prev("input").val(url);
                        self.next("span").html("<img src=" + url + " height=30>");
                        editor.hideDialog(); //隐藏弹窗
                    }
                });
            });
        });
        //表单验证
        $(function() {
            var demo = $(".addform").Validform({
                btnSubmit: "#btn_sub",
                btnReset: ".btn_reset",
                ajaxPost:true,
//                tiptype:function(msg, o, cssctl){
//                    var e = o.obj.context.name;
//                    if (e.length > 1 && o.type == 3){
//                        if (e == 'content'){
//                            alert(msg);
//                        }
//                    }
//                },
                showAllError: false
//                label: ".label",
//                showAllError: false,
//                ajaxPost: true,
//                callback: function(data) {
//                    if (data.status == "0") {
//                        art.dialog({width: 320, time: 5, title: '温馨提示(5秒后关闭)', content: data.info, ok: true});
//                    }
//                    if (data.status == "1") {
//                        window.location.href = data.url;
//                    }
//                }
            });
        });
    });
</script>
