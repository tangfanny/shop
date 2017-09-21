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
        活动模板导航编辑/添加
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
                    <form action="<?php echo U('ActivityNav/navUpdate')?>" class="addform" method="post" autocomplete="off">
                        <dd>
                            <ul class="web">
                                <li>
                                    <strong>导航名称：</strong>
                                    <input type="text" class="text_input" name="name"  value="<?php echo $info['name'] ?>"  datatype="*"/><span style="padding-left: 80px;" >填写图片标题</span>
                                </li>
                                <li>
                                    <strong>关联部件：</strong>
                                    <select class="form-control" name="cid" required>
                                        <option value="<?php echo $info['cid'] ?>"><?php echo $info['cid'] ?></option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                    </select>
                                </li>
                                <li>
                                    <strong>链接地址：</strong>
                                    <input type="text" class="text_input" name="url"  value="<?php echo $info['url']  ?>" />
                                    <span class="Validform_checktip" style="margin-left:26px;">输入banner对应链接地址</span>
                                </li>
                                <input type="hidden" name="id" value="<?php echo $info['id']; ?>" />
                            </ul>
                            <div class="submit">
                                <?php if(!empty($info)){ ?>
                                    <input type="hidden" value="edit" name="opt" />
                                    <input type="hidden" value="<?php echo $info['aid'] ?>" name="aid" />
                                    <input type="submit" class="button_search" value="提交"/>
                                    <a href="<?php echo U('navList',array('id'=>$info['aid']))?>">返回</a>
                                <?php }else{ ?>
                                    <input type="hidden" value="add" name="opt" />
                                    <input type="hidden" value="<?php echo $_GET['aid'] ?>" name="aid" />
                                    <input type="hidden" name="aid" value="<?php echo $id ?>"/>
                                    <input type="submit" class="button_search" value="提交"/>
                                    <a href="<?php echo U('navList',array('id'=>$id))?>">返回</a>
                                <?php }; ?>

                            </div>
                        </dd>
                    </form>
            </div>
        </dl>
    </div>
    <?php include $this->admin_tpl('copyright'); ?>
</div>
<script type="text/javascript" src="<?php echo __QINIU__;?>plupload/js/plupload.full.min.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>plupload/js/i18n/zh_CN.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>ui.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>qiniu.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>highlight.js"></script>
<script type="text/javascript" src="<?php echo __QINIU__;?>main-upload.js"></script>
