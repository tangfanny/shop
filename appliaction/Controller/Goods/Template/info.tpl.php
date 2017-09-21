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
          <a href="#">商品管理</a> > 分类列表 > 编辑分类
    </div>
    <span class="line_white"></span>
    <div class="install mt10">
        <dl>
             <dd>
                <div class="install mt10">
                    <div class="install mt10">
                        <dl>
                            <form action="<?php echo U('goods/ServiceGoods/changeStatus')?>" class="addform" method="post">
                                <dd>
                                    <ul class="web">
                                        <li>
                                            <strong>认证会员名：</strong>
                                            <span></span>
                                            <span><?php echo htmlspecialchars($data['name']);?></span>
                                        </li>
                                        <li>
                                            <strong>认证手机号：</strong>
                                            <span></span>
                                            <span><?php echo htmlspecialchars($data['mobile']);?></span>
                                        </li>
                                        <li>
                                            <strong>注册时间：</strong>
                                            <span></span>
                                            <span><?php echo $data['createtime'];?></span>
                                        </li>
                                         <li>
                                            <strong>服务标题：</strong>
                                            <span></span>
                                            <span><?php echo htmlspecialchars($data['title']);?></span>
                                        </li> 
                                         <li>
                                            <strong>服务费用（天）：</strong>
                                            <span></span>
                                            <span><?php echo $data['price'];?></span>
                                        </li> 
                                        <li>
                                            <strong>擅长品类：</strong>
                                            <span></span>
                                            <span>
                                                <?php 
                                                foreach($data['category'] as $cate) {
                                                    if($cate['type'] == 1)
                                                        echo $cate['name'] . ' ';
                                                }
                                                ?>
                                            </span>
                                        </li> 
                                        <li>
                                            <strong>擅长品牌：</strong>
                                            <span></span>
                                            <span>
                                                <?php 
                                                foreach($data['category'] as $cate) {
                                                    if($cate['type'] == 2)
                                                        echo $cate['name'] . ' ';
                                                }
                                                ?>
                                            </span>
                                        </li>
                                        <li>
                                            <strong>经验：</strong>
                                            <span></span>
                                            <span><?php echo htmlspecialchars($data['work_year']);?> 年</span>
                                        </li>
                                        <li>
                                            <strong>简介：</strong>
                                            <span></span>
                                            <span><?php echo htmlspecialchars($data['brief_desc']);?></span>
                                        </li>
                                        <li>
                                            <strong>荣誉证书：</strong>
                                            <span></span>
                                            <div style="padding-left: 100px;">
                                                <?php
                                                foreach ($data['certificate'] as $img['certificate']) {
                                                    ?>
                                                    <?php if(is_numeric($img['certificate']) && strlen($img['certificate'])==18):?>
                                                        <img  src="<?php echo IMG_URL.Img_ADDRESS.$img['certificate'].'?imageView2/2/w/200 ';?>"/>
                                                    <?php elseif(empty($img['certificate'])): ?>
                                                    <?php else: ?>
                                                        <img  src="<?php echo IMG_URL.$img['certificate'].'?imageView2/2/w/200' ;?>"/>
                                                    <?php endif;?>
                                                <?php } ?>
                                            </div>
                                        </li>
                                        <li>
                                            <strong>是否上架：</strong>
                                            <span></span>
                                            <span>
                                                <label><input type="radio" name="status" value="1" <?php echo $data['goods_status'] ? "checked" : ""; ?>/> 是 </label>&nbsp;&nbsp;
                                                <label><input type="radio" name="status" value="0" <?php echo !$data['goods_status'] ? "checked" : ""; ?>/> 否 </label>
                                            </span>
                                        </li>
                                    </ul>
                                    <div class="submit">
                                        <input type="hidden" name="id" value="<?php echo $data['id'] ?>" />
                                        <input type="submit" class="button_search" value="保存"/>
                                        <a href="<?php echo U('index')?>">返回</a>
                                    </div>
                                </dd>
                            </form>  
                        </dl>
                    </div>
            </dd>
        </dl>
    </div>
</div>
</body>
</html>