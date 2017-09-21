<?php include $this -> admin_tpl('header'); ?>
<div class="content">
    <div class="site">
         <a href="#">运营推广</a> > 活动模板
    </div>
    <span class="line_white"></span>
    <div class="install mt10">
        <dl>
            <dd>
                <div class="ad" style="height:500px;">
                    <ul class="clearfix">
                            <?php foreach ($list as $k=>$vo):?>
                                    <li class="acti_<?php echo $k?>" data-attr="<?php echo $vo['id']?>">
                                        <a><img src="<?php echo $vo['path'] ?>" width="160" height="160" alt="" /></a>
                                        <p><a id="click_activity"><span><?php echo $vo['name'] ?></span></a>
                                        </p>
                                    </li>
                            <?php endforeach;?>                                                              
                    </ul>
                </div>
            </dd>
        </dl>
    </div>
    <?php include $this->admin_tpl('copyright'); ?>
</div>
<div class="activity_input">
    <form action="<?php echo U('ActivityTemp/activityCreate'); ?>" method="post"  id="acti_commit">
    <div class="acti_ac">
        <input type="text"  name="name" value="">
        <input type="hidden" name="t_id" value="">
        <div class="submit" style="padding-left: 28px;">
            <input type="submit" class="button_search" value="提交">
            <input type="reset" class ="button_search" value="取消">
        </div>
    </div>
    </form>
</div>
<script>
var ai = $('.activity_input');

$('.clearfix>li').click(function(e){
    var d = $(this).data('attr');
    ai.find("input[name='t_id']").val(d);
    goods_search();
    
})

var tempUrl = "<?php echo U('ActivityTemp/activityCreate'); ?>";
function goods_search(){
    console.log(art.dialog)
    art.dialog.prompt('请输入模板名称', function(data){
        // data 代表输入数据;
        if(data == ''){
            alert('请填写活动名称');
            return false;
        }
        var s =$('input[name=t_id]').val();
        $.ajax({type:"post",url:tempUrl,data:{name:data,t_id:s},dataType:"json",success:function(a){
            if(a.id != 1){
                window.location.href="<?php echo U('ActivityTemp/activityCreate');?>"+'&id='+a.id
            }else{
                alert('添加失败');
            }            
        }
    })

    }, '模板');
}
</script>