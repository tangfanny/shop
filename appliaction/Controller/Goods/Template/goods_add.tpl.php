<?php include $this -> admin_tpl("header"); ?>
    <!-- 内容区 -->
      <style>
    #Validform_msg {
    display: none
    }
    img {
        cursor: pointer;
    }
    .editor .ke-toolbar span,
    .editor .ke-statusbar span {
        padding: 0px;
    }
    .editor .ke-toolbar .ke-outline {
        border: 1px solid #F0F0EE;
        cursor: pointer;
        display: block;
        float: left;
        font-size: 0;
        line-height: 0;
        margin: 1px;
        overflow: hidden;
        padding: 1px 2px;
    }
    .imgWrap div {
        border: 1px solid #3B72A5;
        cursor: pointer;
        float: left;
        margin-left: 26px;
        margin-top: 20px;
        position: relative;
    }
    .imgWrap div span {
        color: #FFFFFF;
        display: none;
        padding: 0 5px;
        position: absolute;
    }
    .setdef {
        background: none repeat scroll 0 0 #F48C3A;
        bottom: 0;
        line-height: 18px;
        height: 18px;
        position: absolute;
        right: 0;
        padding: 0 5px;
        display: none;
        z-index: 9999;
        color: #FFFFFF;
    }
    .setdel:hover{
        color: #4A65F1;
    }

    .setdel {
        cursor:pointer;
        background: none repeat scroll 0 0 #3b72a5;
        top: 134px;
        color: #FFFFFF;
        display: none;
        height: 18px;
        line-height: 18px;
        padding: 0 5px;
        position: absolute;
        right: 40px;
        z-index: 9999;
    }
    table.areaBox th {
        background: #e8f5fc;
        border-bottom: 1px solid #e8f5fc;
    }
    table.areaBox {
        border-left: 1px solid #e8f5fc;
        border-right: 1px solid #e8f5fc;
        border-top: 1px solid #e8f5fc;
        margin: 10px auto;
        width: 720px;
    }
table.areaBox td {
    border-bottom: 1px solid #e8f5fc;
}
.add_area,
    table.areaBox {
    width: 98%;
}
.sel-dh-gs-ad{
    width: 256px;
    height: 26px;
    line-height: 24px;
    color: #333;
    border: 1px solid #ccc;
    margin-right: 47px;
}
.c1{float: left;margin: 2px 0 0 10px}
#category{
    float: left;
    padding: 2px 0;
    width: 304px;
}
#category label{
    float: left;
    margin:3px 5px 3px 0;
}
</style>
        <div class="site">
            <a href="#">商品管理</a> >
            <a href="javascript:location.replace(location.href);">
                <?php if($_list['id']):?>
                    编辑商品
                <?php else:?>
                    添加商品
                <?php endif;?>
            </a>
        </div>
        <span class="line_white"></span>
    <div class="install tabs mt10">
        <dl>
            <dt><a href="javascript:" class="hover">基本信息</a>
               <a href="javascript:">商品规格</a>
               <a href="javascript:">商品属性</a>
               <a href="javascript:">详细描述</a>
               <a href="javascript:">商品图册</a>
               <!--<a href="javascript:">商品证书</a>-->
             </dt>
            <form method="post" action="<?php echo $posturl; ?>" name="goodsForm" class="goodsForm" >
                <input  type="hidden" name="addflag" value="<?php  echo $addflag;?>"/>
                <input type="hidden" name="ids" value="<?php echo $_list["ids"];?>"/>
              
                <dd>
                    <ul class="web">
                        <li>
                            <strong>商品名称：</strong>
                            <input type="text" value="<?php echo $_list['name']; ?>" class="text_input" datatype="*" nullmsg="请输入商品名称！" name="name"  /><span>填写商品名称</span>
                        </li>
                        <li>
                            <strong>商品副标题：</strong>
                             <textarea name="sub_title" style="margin-right: 52px;">
<?php echo $_list['sub_title']; ?></textarea><p class="p">可填写产品特性，优惠活动等等，字数不超过30字，非必填.</p>
                        </li>
                        <li>
                        <strong>商品分类：</strong>
                        <div class="fenlei">
                            <div class="fentt clearfix">
                                <h3 class="fl">所选<br />分类</h3>
                                <div class="sl fl">
                                    <?php foreach ($category as $key => $value): ?>
                                        <div><?php echo $value['name'] ?><em><img src="<?php echo IMG_PATH; ?>admin/ico_close1.png"></em><input type="hidden" value="<?php echo $value['id']; ?>" name="cat_ids[]"></div>
                                    <?php endforeach ?>
                                </div>
                                <div class="flts fr">
                                        <span style="color:red;font-weight: bold;">※选择商品所属分类，一个商品只能对应一个分类，选择多个分类导致商品关联不上，后果自负。</span>
                                </div>
                            </div>
                            <div class="fendd clearfix">
                                <div class="root">
                                </div>
                                <div class="bgef">
                                </div>
                                <div class="bgef">
                                </div>
                                <div class="bgef">
                                </div>
                            </div>
                        </div>
                        <div class=" xtishi">
                            <div class="fl">小提示：所选分类应为最后一级子分类。双击可选中该分类或点击按钮确定选择</div>
                            <div class="submit fr">
                                <a href="javascript:" id="jiafen">选择当前分类</a>
                            </div>
                        </div>
                    </li>
                     <li style="line-height:24px;">
                            <strong>商品图片：</strong>
                         <div class="upload_select">
                            <input type="file" class="am-hide" id="pickfiles0"  >
                            <input type="hidden" class="upload_url" name="thumb" value="<?php echo $_list['thumb']; ?>">
                            <div id="container">                         </div>
                            <div class="preview_container">
                             <?php if(is_numeric($_list['thumb']) && strlen($_list['thumb'])==18):?>
                                        <img  src="<?php echo IMG_URL.Img_ADDRESS.$_list['thumb'].'?imageView2/2/w/200 ';?>/admin/1" id="imgpreview" class="preview"/>
                                    <?php elseif(empty($_list['thumb'])): ?>
                                        <img src="" id="imgpreview" class="preview" alt="">
                                    <?php else: ?>
                                        <img   class="preview" src="<?php echo IMG_URL.$_list['thumb'].'?imageView2/2/w/200' ;?>/admin/1" id="imgpreview"/>
                                    <?php endif;?>
                            </div>
                        </div>
                            <span style="margin-left: 140px;">商品在前台显示的微缩图片</span>
                        </li>
                        <li style="line-height:24px;">
                            <strong>产品说明书：</strong>
                            <div class="upload_select">
                            <input type="file" class="am-hide" id="pickfiles1" >
                            <input type="hidden" class="upload_url" name="explain" value="<?php echo $_list['explain']; ?>">
                            <div id="container"></div>
                                <div>
                                    <?php if(is_numeric($_list['explain']) && strlen($_list['explain'])==18):?>
                                        <img  src="<?php echo IMG_URL.Img_ADDRESS.$_list['explain'];?>" class="preview" id="imgpreview"/>
                                    <?php elseif(empty($_list['explain'])): ?>
                                        <img src="" id="imgpreview1" class="preview" alt="">
                                    <?php else: ?>
                                        <img  src="<?php echo IMG_URL.$_list['explain'] ;?>" class="preview" id="imgpreview"/>
                                    <?php endif;?>
                                </div>
                            </div>
                         <span style="margin-left: 140px;">上传产品说明书,支持JPG、PNG、PDF格式，大小不得超过10M，可上传压缩包。</span>
                     </li>
                     <li>
                        <strong>商品标签：</strong>
                        <select name="label_id" class="select" style="margin-right: 48px;">
                            <option value="0">请选择</option>
                            <?php foreach ($this->label as $key => $value): ?>
                                <option value="<?php echo $value['id']; ?>"
<?php if ($value['id'] == $_list['label_id']): ?>selected<?php endif ?>><?php echo $value['name']; ?></option>
                            <?php endforeach ?>
                        </select>
                        <span>为商品选择标签</span>
                    </li>
                     <li>
                        <strong>商品品牌：</strong>
                         <select name="brand_id" id="brand_id" class="select" style="margin-right: 48px;" onChange="javascript:c();">
                            <option value="0">请选择</option>
                            <?php foreach ($this->brand as $key => $value): ?>
                                <option value="<?php echo $value['id']; ?>"
                                <?php if ($value['id'] == $_list['brand_id']): ?>selected = "selected"<?php endif ?>><?php echo $value['name']; ?></option>
                            <?php endforeach ?>
                        </select><span>为商品选择所属品牌，便于用户按照品牌进行查找</span>
                    </li>
<script type="text/javascript">
<?php if (isset($_list['id'])) { ?>
    $(document).ready(function(){
        c();
    });
<?php } ?>
  function c(){
    var brand_id = $("#brand_id option:selected").val();
    var url ="<?php echo U('Certificate/getCertByBrand');?>";
    var goods_id = "<?php echo $_list['id']; ?>";
    var selec = "";
        $.ajax({
            type:"post",
            url:url,
            data:{'brand_id':brand_id,'goods_id':goods_id},
            success: function(data){
              $("#category").empty();
              var json = eval(data);
              for(var i = 0;i<json.length;i++){
                $("#category").append("<label><input type='checkbox' "+json[i]["flag"]+" name='certificate_id[]' value="+json[i]["id"]+">"+"&nbsp;"+json[i]["certificate_name"]+"<label>");
              }
            },
        });
  }
</script>
                        <li>
                            <strong>选择证书：</strong>
                             <div id="category">
                             </div>
                             <span>商品资质证书（可以多选）</span>
                        </li>
                        <li>
                            <strong>是否上架销售：</strong>
                            <b style="margin-right: 44px;">
                                <label><input type="radio" name="status" value="1" <?php if (isset($_list['status']) && $_list['status'] == 1): ?>
                                    checked
                                <?php else: ?>
                                    checked
                                <?php endif ?>/> 是 </label>
                                <label><input type="radio" name="status" value="0" <?php if (isset($_list['status']) && $_list['status'] == 0): ?>
                                    checked
                                <?php endif ?>/> 否 </label>
                            </b>
                            <span style="margin-left:1px">设置当前商品是否上架销售，默认为是，如选择否，将不在前台显示该商品</span>
                        </li>
                        
                        <!--是否分期字段-->
                        
                        <li>
                            <strong>是否分期销售：</strong>
                            <b style="margin-right: 44px;">
                                <label><input type="radio" name="status_staging" value="1" <?php if (isset($_list['status_staging']) && $_list['status_staging'] == 1): ?>
                                    checked
                                <?php else: ?>
                                    checked
                                <?php endif ?>/> 是 </label>
                                <label><input type="radio" name="status_staging" value="0" <?php if (isset($_list['status_staging']) && $_list['status_staging'] == 0): ?>
                                    checked
                                <?php endif ?>/> 否 </label>
                            </b>
                            <span style="margin-left:1px">设置当前商品是否允许分期销售，默认为否，如选择是，将在前台显示分期数据</span>
                        </li>
                        
                         <li>
                            <strong>是否支持试用：</strong>
                            <b style="margin-right: 44px;">
                                <label>
                                <input type="radio" name="on_trial" value="1" <?php if (isset($_list['on_trial']) && $_list['on_trial'] == 1): ?>
                                    checked
                                <?php else: ?>
                                    checked
                                <?php endif ?>/> 是
                                </label>
                                <label>
                                    <input type="radio" name="on_trial" value="0" <?php if (isset($_list['on_trial']) && $_list['on_trial'] == 0): ?>
                                    checked
                                <?php endif ?>/> 否 </label>
                            </b>
                            <span style="margin-left:1px">设置当前商品是否允许试用，默认为否，如选择是，将在前台显示试用按钮</span>
                        </li>
                        
                        <li>
                            <strong>试用规则：</strong>
                            <textarea name="on_trial_text" style="margin-right: 52px;width:400px;height:100px;" wrap="physical" >
<?php if  (empty($_list['on_trial_text'])): ?>1、申请人试用人必须为威客平台注册用户；<br/>

2、您提交的试用申请，我们会在三天内进行处理，请随时保持手机信号畅通；<br/>

3、试用设备如果申请人数较多，会顺延您试用申请的时间；<?php else: ?>
    <?php echo $_list['on_trial_text'];?>
<?php endif ?></textarea>
                            <span style="margin-left:1px">试用规则</span>
                        </li>
                        
                        <!--是否分期结束-->
                        
                        <li>
                            <strong>商品状态：</strong>
                            <b style="margin-right: 44px;">
                                <label>
                                    <input type="checkbox" <?php if ($_list['is_sales']): ?>
                                        checked
                                    <?php endif ?> name="is_sales"> 促销
                                </label>
                                <label>
                                    <input type="checkbox" <?php if ($_list['is_hot']): ?>
                                        checked
                                    <?php endif ?> name="is_hot"> 热卖
                                </label>
                                <label>
                                    <input type="checkbox" <?php if ($_list['is_new']): ?>
                                        checked
                                    <?php endif ?> name="is_new"> 新品
                                </label>
                                 <label>
                                    <input type="checkbox" <?php if ($_list['recommend_app']): ?>
                                        checked
                                    <?php endif ?> name="recommend_app"> 推荐_APP
                                </label>
                                 <label>
                                    <input type="checkbox" <?php if ($_list['selected']): ?>
                                        checked
                                    <?php endif ?> name="selected"> 精选
                                </label>
                            </b>
                            <span style="margin-left:1px">设置商品状态属性，可进行多选</span>
                        </li>
                        <li>
                            <strong>排序：</strong>
                            <input type="text" class="text_input" name="sort" placeholder=''  datatype="n" value="<?php echo  $_list['sort']==''?100:$_list['sort'];?>" /><span class="Validform_checktip">输入数字显示排序，数字越小越靠前数字越大越靠后</span>
                        </li>
                        <li>
                            <strong>评级打分：</strong>
                            <input type="text" class="text_input" name="level" placeholder=''  datatype="n" value="<?php echo  $_list['level']==''?10:$_list['level'];?>" /><span class="Validform_checktip">根据平台测评该产品的性能和用户评论等等为商品打分，10分为满分，可打0~10分，前端满级5颗星，每半颗代表1分</span>
                        </li>
                        <li>
                            <strong>商品销量排行：</strong>
                            <input type="text" class="text_input" name="buy_num" placeholder=''  datatype="n" value="<?php echo  $_list['buy_num']==''||$_list['buy_num']==0?1000:$_list['buy_num'];?>" /><span class="Validform_checktip">统计每件商品的销量，订单完成即记为销量加1,添加商品默认为1000</span>
                        </li>
                        <li>
                            <strong>商品关键词：</strong>
                            <input type="text" value="<?php echo $_list['keyword']; ?>" name="keyword" class="text_input" /><span style="margin-left:-2px">用于在前台、后台筛选商品，多个关键词用空格分开，同时作为商品的Meta Keyword，有利于搜索引擎优化</span>
                        </li>
                        <li>
                            <strong>商品描述：</strong>
                            <textarea name="brief" style="margin-right: 52px;">
<?php echo $_list['brief']; ?></textarea><p class="p">为商品编辑内容描述，同时作为商品的Meta Description，有利于搜索引擎优化</p>
                        </li>
                    </ul>
                </dd>
                <dd>
                    <ul class="web p1">
                        <li>
                            <strong>规格数据：</strong>
                            <dl class="blue_table mt10">
                                <dt style="height:42px; background: none repeat scroll 0 0 #E8F5FC;"><img src="<?php echo IMG_PATH; ?>admin/spec_add.png" onclick="selSpec()" style="padding:10px;float:left">
                                <span class="add" style="float:left;line-height: 44px;">点击添加商品规格可为不同规格的商品指定不同的库存和和价格，方便用户选择购买</span>
                                <span class="delete_checked_goods" onclick="delChecked()">多选删除</span>
                                <span class="change_all_goods">批量修改</span>
                                <img src="<?php echo IMG_PATH; ?>admin/input_8.png" onclick="delAll()" style="padding:10px;float:right">
                                </dt>
                                <div>
                                    <table class="border_table">
                                        <thead id="goodsBaseHead"></thead>
                                        <!--商品标题模板-->
                                        <script id="goodsHeadTemplate" type='text/html'>
                                        <tr>
                                        <th><label id="select_all"><input type="checkbox" /> 全选</label></th>
                                            <th> 商品条码 </th>
                                            <th>商品货号</th>
                        <%var isProduct = true;%>
                        <% var specheadArrayList = templateData %>
                        <%for (var item in specheadArrayList){%>
                        <th> <%=specheadArrayList[item]['name']%></th>


                                            <%}%>
                                            <th>库存</th>
                                            <th> 市场价格 </th>
                                            <th>威客价格</th>
                                            <th> 成本价格 </th>
                                            <%if (isProduct == true) { %>
                                                <th> 操作 </th>
                                            <%}%>
                                        </tr>
                                        </script>
                                        <tbody id="goodsBaseBody"></tbody>
                                        <!--商品内容模板-->
                                        <script id="goodsRowTemplate" type="text/html">
                                            <%var i=0;%>
                                            <%for(var item in templateData){%>
                                            <%item = templateData[item] %>
                                            <tr class='td_c1'>
                                                <td><input type="checkbox" name="checked_id" value="<%=i%>"/></td>
                                                <td><input class="small" name="_goods_barcode[<%=i%>]"  nullmsg="请输入商品条码！" type="text" value="<%=item['products_barcode'] %>" /></td>
                                                <td><input class="small" name="_goods_sn[<%=i%>]"  nullmsg="请输入商品货号！" type="text" value="<%=item['products_sn']?item['products_sn']:item['goods_sn'] %>" /></td>
                                                <%var isProduct = true;%>
                                                <%var specArrayList = item['spec_array']%>
                                                <%if (specArrayList){%>
                                                <%for(var result in specArrayList){%>
                                                <%result = specArrayList[result]%>
                                            <input type='hidden' name="_spec_array[<%=i%>][]" value='{"id":"<%=result.id%>","name":"<%=result.name%>","value":"<%=result.value%>"}' />
                                            <%isProduct = true;%>
                                            <td>
                                                <%=result['value']%>
                                            </td>
                                            <%}%>
                                            <%}%>
                                            
                                      
                                             
                                            <td><input class="tiny" name="_goods_number[<%=i%>]" nullmsg="请输入商品存存！" type="text" datatype="num" value="<%=item['goods_number']?item['goods_number']:100%>" /></td>
                                            <td>
<!--                                                <input type='hidden' name="_groupPrice[<%=i%>]" value="<%=item['groupPrice']%>" />-->
                                                <input class="tiny" name="_shop_price[<%=i%>]" type="text" datatype="num" nullmsg="请输入商品销售价！" value="<%=item['shop_price']?item['shop_price']:'0.00'%>" />
                                                <!--<button class="btn" type="button" onclick="memberPrice(this);"><span class="add <%if(item['groupPrice']){%>orange<%}%>">会员价格</span></button>-->
                                            </td>
                                            <td><input class="tiny" name="_market_price[<%=i%>]" nullmsg="请输入商品市场价！" type="text" datatype="num" value="<%=item['market_price']?item['market_price']:'0.00'%>" /></td>
                                            <td><input class="tiny" name="_cost_price[<%=i%>]" type="text" datatype="num" nullmsg="请输入商品成本价！" empty value="<%=item['cost_price']?item['cost_price']:'0.00'%>" /></td>
<!--                                            <td><input class="tiny" name="_weight[<%=i%>]" type="text" datatype="*,n" nullmsg="请输入商品重量！" empty value="<%=item['weight']%>" /></td>-->
                                            
                                            <%if(isProduct == true){%>
                                               
                                            <td>

                                                <input name="_products_ids[<%=i%>]" type="hidden" value="<%=item['id'] %>" /><a href="javascript:void(0)" onclick="delProduct(this);">删除</a>
                                           
                                            </td>
                                            <%}%>
                                            </tr>
                                            <%i++;%>
                                            <%}%> 
                                        </script>
                                    </table>
                                </div>
                            </dl>
                        </li>    
                    </ul>
                </dd>
                <dd>
                    <ul class="web">
                        <div class="install ">
                        <li>
                            <strong>库存警告：</strong>
                            <input type="text" class="text_input" value="<?php echo isset($_list['warn_number'])?$_list['warn_number']:2 ?>" name="warn_number"><span>填写商品库存警告数，当库存小于等于警告数，系统就会提醒此商品为库存警告商品，系统默认为2</span>
                        </li>
                        <li>
                            <strong>商品积分：</strong>
                            <input type="text" class="text_input" value="<?php echo isset($_list['give_integral'])?$_list['give_integral']:-1?>" name="give_integral" ><span>设置此商品每消费1元可以获得多少积分，默认为-1，即按照系统设置的积分换算比例，设为0则此商品不参与积分</span>
                        </li>
                        <li>
                        <strong>商品属性</strong>
                        
                        <select name="model" id="model">
                            <option value="0">请选择</option>
                            <?php foreach($this->model as $k=>$v):?>
                                <option value="<?php echo $v['id']?>" ><?php echo $v['name']?></option>
                            <?php endforeach;?>
                        </select>
                        <input value="<?php echo($_list['model'])?>" type="hidden" name="hiddenmodel" id="hiddenmodel"/>
                        <span>设置商品的类型属性，属性信息会在商品详情页显示，并且可以筛选本件商品，建议选择</span>
                    </li>
                    <li>
                        <strong>商品规格</strong>
                        <select name="model1" id="model1" class="sel-dh-gs-ad">
                            <option value="0">请选择</option>
                            <option value="-1">清空全部属性</option>
                            <?php foreach($product as $k=>$v):?>
                                <option value="<?php echo $v['id']?>" ><?php echo $v['spec_array'][0]['name'].'->'.$v['spec_array'][0]['value']?></option>
                            <?php endforeach;?>
                        </select>
                        <span>设置商品的规格属性，属性信息会在商品详情页显示，并且可以筛选本件商品，建议选择</span>
                    </li>
                    <li>
                            <strong>服务厂商</strong>
                            <select name="server" id="server" class="sel-dh-gs-ad">
                                <option value="0">请选择</option>
                                <?php foreach ($server as $k=>$v):?>
                                    <option value="<?php echo $v['id']?>" ><?php echo $v['name']?></option>
                                <?php endforeach;?>
                            </select>
                            <span>设置商品的服务厂商</span>
                             <script type="text/javascript">
                                 $(function() {
                                    $("#server").change(function(){
                                        var server_id = $("#server option:selected").val();
                                        var product_id =$("#model1 option:selected").val();
                                        var url = "<?php echo U('goods/getserver')?>";
                                        $.post(url, {"serverid":server_id,"product_id":product_id}, function(data){
                                            var serverlist = eval(data);
                                            var html="<table class='areaBox'>";    
                                            if(serverlist!=null){
                                              for(var i=0;i<serverlist.length;i++){
                                                   html+="<tr>"+
                                                        "<th style='width:130px'>"+serverlist[i]["name"]+"</th>"+
                                                         "<td>"+
                                                          "<input type='text' class='text_input c1' name='money[]' value='"+serverlist[i]["val"]+"'>"+
                                                           "<input type='hidden' name='vendor_yeas[]' value='"+serverlist[i]["name"]+"'>"+
                                                           "<input type='hidden' name='vendor_sort[]' value='"+(i+1)+"'>"
                                                         "</td>"+
                                                        "</tr>"+
                                                        "";
                                              }
                                            }
                                             html+="</table>";
                                             $("#serverspan").html(html);
                                        }); 
                                       
                                    });
                                 });
                             </script>
                        </li>
                        
                        </div>
                        <div id="serverspan" class="add_area model_box"></div> 
                            
                        <div class="add_area model_box" style="display: none;">
                                                    
                        <table class="areaBox" id="modelBaseBody">
                            <!--模型-->
                            <script id="modelRowTemplate" type="text/html">
                                <!--属性-->
                                <%for(var i in templateData['attrinfo']){%>
                                <%item = templateData['attrinfo'][i]%>                               
                                                                
                                <tr>
                                    <th style="width:90px;"><%=item['name']%></th>
                                    <td>
                                        <%if(item['type'] == 1){inputtype='radio'}else if(item['type'] == 2){inputtype='checkbox'}else if(item['type'] == 3){inputtype='text'} %>
                                        <%var detailData = item['value'].split(",")%>
                                        <%for(var ii in detailData){%>
                                        <%ditem = detailData[ii]%>
                                                                                <%var ck=""%>
                                        <div class="add_area_div">
                                            <li>
                                        <label >
                                            <%var attrData = item['selvalue']%>
                                            <%for(var ai in attrData){%>
                                                <%aitem = attrData[ai]%>
                                                <%textvalue = attrData[ai]%>
                                                <%if (aitem == ditem){%>
                                                    <%var ck="checked"%>
                                                    <%break%>
                                                <%}else{%>
                                                    <%var ck=""%>
                                                <%}%>
                                            <%}%>
                                            <%if(item['type'] == 3){%>
                                                <input type="<%=inputtype%>" class='text_input' style='width:150px;' name="_model[<%=item['id']%>][]" value="<%=textvalue%>" title="<%=ditem%>" >   
                                            <%}else{%>
                                                <input type="<%=inputtype%>" name="_model[<%=item['id']%>][]" value="<%=ditem%>" title="<%=ditem%>" <%=ck%> ><span class="red_s"><%=ditem%></span>
                                            <%}%>
                                        </label>
                                        </li>
                                        </div>
                                        <%}%>
                                    </td>
                                </tr>
                                <%}%>
                            </script>
                                                        
                                                        
                                                        
                        </table>
                                                    
                        </div>
                    </ul>
                </dd>
                <dd>
                   <div class="edit_box">
                       <strong class="edit">您正在编辑当前商品详细信息，默认所见即所得模式，您也可以点击HTML源码切换到代码模式进行编辑。</strong>
                       <div class="editor edit"><?php echo form::editor('content');?></div>
                      <div><script id="am-container" name="descript" type="text/plain" style="width:1024px;height:450px;"><?php echo  $_list['descript'];?></script></div>
                   </div>
                </dd>
                <dd>
                   <?php   if (empty($_list['pics'])): ?>
                       <div class="upload_more" style="margin-top: 20px;">
                           <span >多图上传</span>
                           <input type="file" class="am-hide" id="pickfiles2"  style="color:#f1f1f1;">
                           <div id="container"></div>
                           <div id="scan" >
                           </div>
                           <div id="hid">
                           </div>
                       </div>
                 <?php else:?>
                       <div class="upload_more" style="margin-top: 20px;">
                           <span >多图上传</span>
                           <input type="file" class="am-hide" id="pickfiles3" style="color:#f1f1f1; ">
                           <div id="container"></div>
                           <div id="scan" >
                               <?php   if (!empty($_list['pics'])): ?>
                                   <?php foreach ($_list['pics'] as $k=>$v):?>
                                       <img data-id='<?php echo $v ;?>' id="photos<?php echo explode('.',$v)[0];?>" onclick='delete_img("<?php echo explode('.',$v)[0];?>")'  class='preview' src='<?php echo IMG_URL.$v ;?>' />
                           <?php endforeach;?>
                           <?php endif ?>
                           </div>
                           <div id="hid">
                               <?php   if (!empty($_list['pics'])): ?>
                                   <?php foreach ($_list['pics'] as $k=>$v):?>
                                       <input data-id='<?php echo $v ;?>' type='hidden' name='goodsphoto[]' id='hid-val' value='<?php echo $v ;?>' />
                                   <?php endforeach;?>
                               <?php endif ?>
                           </div>

                       </div>
                 <?php endif?>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>style.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>webuploader.css" />
    <script type="text/javascript" src="<?php echo JS_PATH;?>image-upload/webuploader.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH;?>image-upload/upload.js"></script>
                </dd>
                <div class="submit">
                    <?php if($_list['id']):?>
                    <input type="hidden" name="id" value="<?php echo $_list['id']; ?>" />
                    <?php endif;?>
                    <input type="submit" class='button_search' value='提交'/>
                    <?php if($_SERVER['REQUEST_URI'] != U('goods/goods/add')):?>
                      <a href="<?php echo U('lists')?>">返回</a>
                    <?php endif;?>
                </div>
                <input type="hidden" name="del_products_all" value="no">
            </form>
        </dl>
    </div>
    <!--批量编辑商品信息弹窗-->
<div id="batcheditGoods" class="BatchEditingMoney">
    <ul>
        <li class="w85"><strong>库存</strong></li>
        <li class="w85"><strong>销售价格</strong></li>
        <li class="w85"><strong>市场价格</strong></li>
        <li class="w85"><strong>成本价格</strong></li>
    </ul>
    <ul>
        <li class="w85"><input type="text" name="_goods_number_change" value="+0" /></li>
        <li class="w85"><input type="text" name="_shop_price_change" value="+0.00" /></li>
        <li class="w85"><input type="text" name="_market_price_change" value="+0.00" /></li>
        <li class="w85"><input type="text" name="_cost_price_change" value="+0.00" /></li>
    </ul>
    <p>小提示：此处修改的值将对所有商品值进行加减修改如:+10 -5<br>库存必须是整数  价格可带两位小数</p>
</div>
    <?php include $this->admin_tpl('copyright'); ?>
    <!--选择框-->
    <script src="<?php echo JS_PATH; ?>jquery.goods_add_category.js"></script>
    <!--模板-->
    <script type="text/javascript" src="<?php echo JS_PATH; ?>artTemplate/artTemplate.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH; ?>artTemplate/artTemplate-plugin.js"></script>
    <!--编辑器开始-->
    <script type="text/javascript" src="<?php echo JS_PATH; ?>admin/goods_cat.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH; ?>admin/goods_spec.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH; ?>admin/goods_model.js"></script>
    <script type="text/javascript" src="<?php echo __QINIU__;?>plupload/js/plupload.full.min.js"></script>
    <script type="text/javascript" src="<?php echo __QINIU__;?>plupload/js/i18n/zh_CN.js"></script>
    <script type="text/javascript" src="<?php echo __QINIU__;?>ui.js"></script>
    <script type="text/javascript" src="<?php echo __QINIU__;?>qiniu.js"></script>
    <script type="text/javascript" src="<?php echo __QINIU__;?>highlight.js"></script>
    <script type="text/javascript" src="<?php echo __QINIU__;?>uploadUtils.js"></script>
<!--    <script type="text/javascript" src="--><?php //echo __QINIU__;?><!--main-upload.js"></script>-->
    <script>
        var uploadBtns = $(".upload_select");
        initUploads(uploadBtns);

        var upload_more = $(".upload_more");
        initUploadMore(upload_more);
    </script>
        <script>
        var selectedItem = <?php echo $_list['selectedItem'] ? $_list['selectedItem'] : '[]'; ?> ;
        var tempUrl = "<?php echo U('Goods/Goods/search_spec');?>";
        var getmodelurl = "<?php echo U('Goods/ProductModel/ajax_get_model')?>";
        var getmodelinfourl = "<?php echo U('Goods/ProductModel/ajax_get_model_info?goods_id='.$_list['id'].'')?>";
                var getmodelinfoproductsurl = "<?php echo U('Goods/ProductModel/ajax_get_model_info_products?goods_id='.$_list['id'].'')?>";
        var IMG_PATH = "<?php echo IMG_PATH;?>";
        //百度编辑器
        var ue = UE.getEditor('am-container');
        /**
         *初始化
         */
        $(function() {
            //默认高亮
            $(window.document).find(".z_side").removeClass("hover");
            $(window.document).find(".n11").attr("width","1000px;");
            //切换
            var tabTitle = ".tabs dt a";
            var tabContent = ".tabs dd";
            $(tabTitle + ":first").addClass("hover");
            $(tabContent).not(":first").hide();
            $(tabTitle).unbind("click").bind("click", function() {
                $(this).siblings("a").removeClass("hover").end().addClass("hover");
                var index = $(tabTitle).index($(this));
                $(tabContent).eq(index).siblings(tabContent).hide().end().fadeIn(0);
            });
            //初始化分类选择
            JsonCategory = <?php echo json_encode($this -> tree) ?> ;
            nb_category(0, '.root');
            
            //初始化模型
            <?php if($_list['model']):?>
                $('#model').val('<?php echo $_list['model']?>').change();
                //选中值
                var selmodel = <?php echo json_encode($selmode)?>;              
            <?php endif;?>        
        });
        $(function(){
            var tabTitle = ".tabs dt a";
            var tabContent = ".tabs dd";
            $(tabTitle+":last").one("click",function(){
        $.getScript("<?php echo JS_PATH;?>image-upload/upload.js");
        });
        })
        //默认货号
        var defaultProductNo = "<?php echo C('site_numprefix').time().rand(10,99)?>";
        $(function() {
            initProductTable();
            //存在商品信息
            <?php   if (isset($_list)): ?>
                var goods = <?php echo json_encode($_list) ?> ;
                var goodsRowHtml = template('goodsRowTemplate', {'templateData': [goods]});
                $('#goodsBaseBody').html(goodsRowHtml);
                $('[name="_goods_barcode[0]"]').val(goods.barcode);
                $('[name="_goods_sn[0]"]').val(goods.sn);
                $('[name="_goods_number[0]"]').val(goods.goods_number);
 
                $('[name="_shop_price[0]"]').val(goods.shop_price);
                $('[name="_market_price[0]"]').val(goods.market_price);
                $('[name="_cost_price[0]"]').val(goods.cost_price); 
            <?php   else : ?>
                $('[name="_goods_sn[0]"]').val(defaultProductNo);
            <?php endif ?>
            //存在货品信息,进行数据填充
            <?php if (isset($product)): ?>
                var spec_array = <?php echo json_encode($product[0]['spec_array']) ?> ;
                var product = <?php echo json_encode($product) ?> ;
                var goodsHeadHtml = template('goodsHeadTemplate', {'templateData': spec_array});
                $('#goodsBaseHead').html(goodsHeadHtml);
                var goodsRowHtml = template('goodsRowTemplate', {'templateData': product});
                $('#goodsBaseBody').html(goodsRowHtml); 
            <?php endif ?>
        });
        //初始化货品表格
        function initProductTable() {
            //默认产生一条商品标题空挡
            var goodsHeadHtml = template('goodsHeadTemplate', {'templateData': []});

            $('#goodsBaseHead').html(goodsHeadHtml);
            //默认产生一条商品空挡
            var goodsRowHtml = template('goodsRowTemplate', {'templateData': [[]]});
            $('#goodsBaseBody').html(goodsRowHtml);
        }
        // 表单 验证
        $(function() {
            $.Tipmsg.r = null;
            var demo = $(".goodsForm").Validform({
                btnSubmit: "#btn_sub",
                btnReset: ".btn_reset",
                label: ".label",
                showAllError: false,
                //ajaxPost: true,
                tiptype: function(msg, o, ctrl) {
                    var e = o.obj.context.name;
                    if (e.length > 1) {
                        if (e == 'name') {
                            $(".tabs dt a").eq(0).click();
                        } else {
                            $(".tabs dt a").eq(1).click();
                        }
                    }
                    // if (o.type==3){
                    //     art.dialog({id:'tip',width: 320, time: 5, title: '温馨提示(5秒后关闭)', content: msg, ok: true});
                    // }
                },
                beforeCheck: function(curform) {
                    var cat_ids = $("input[name='cat_ids[]']");
                    if (cat_ids.length == 0) {
                        $(".tabs dt a").eq(0).click();
                        alert('请选择商品分类');
                        return false;
                    }
                    editor.sync("#content");
                },
                callback: function(data) {
                    $("#Validform_msg").hide();
                    if (data.status == 0) {
                        art.dialog({
                            id: 'tip',
                            width: 320,
                            time: 5,
                            title: '温馨提示(5秒后关闭)',
                            content: data.info,
                            ok: true
                        });
                    }
                    if (data.status == 1) {
                        window.location.href = data.url;
                    }
                }
            });
        });
        //批量修改信息
        $('.change_all_goods').click(function(){
            art.dialog({
                padding: '0px ',
                id: 'BatchEditingMoney',
                background: '#ddd',
                opacity: 0.3,
                title: '批量编辑商品信息',
                content: document.getElementById('batcheditGoods'),
                ok:function() {
                    _goods_number_change    = $('[name="_goods_number_change"]').val();
                    _shop_price_change      = $('[name="_shop_price_change"]').val();
                    _market_price_change    = $('[name="_market_price_change"]').val();
                    _cost_price_change      = $('[name="_cost_price_change"]').val();
                    var num_reg = /^[-\+]?\d*$/;
                    var price_reg = /^[-\+]?\d+(\.\d{2})?$/;
                    if(!(num_reg.test(_goods_number_change)) || !(price_reg.test(_shop_price_change)) || !(price_reg.test(_market_price_change)) || !(price_reg.test(_cost_price_change))){
                        alert('请输入正确的数字!');
                        return false;
                    }
                    //库存
                    $('#goodsBaseBody [name^="_goods_number"]').each(function(index,data){
                        num = parseInt($(this).val()) + parseInt(_goods_number_change);
                        num = num < 0 ? 0 : num;
                        $(this).val(num);
                    })
                    //销售价
                    $('#goodsBaseBody [name^="_shop_price"]').each(function(index,data){
                        num = Number($(this).val()) + Number(_shop_price_change);
                        num = num < 0 ? 0 : num;
                        $(this).val(num.toFixed(2));
                    })
                    //市场价
                    $('#goodsBaseBody [name^="_market_price"]').each(function(index,data){
                        num = Number($(this).val()) + Number(_market_price_change);
                        num = num < 0 ? 0 : num;
                        $(this).val(num.toFixed(2));
                    })
                    //成本
                    $('#goodsBaseBody [name^="_cost_price"]').each(function(index,data){
                        num = Number($(this).val()) + Number(_cost_price_change);
                        num = num < 0 ? 0 : num;
                        $(this).val(num.toFixed(2));
                    })
                    $('[name="_goods_number_change"]').val('+0');
                    $('[name="_shop_price_change"]').val('+0.00');
                    $('[name="_market_price_change"]').val('+0.00');
                    $('[name="_cost_price_change"]').val('+0.00');
                    return true;
                },
                cancel:true
            });
        });
        // 全选
        $(window).load(function(){
            $('#select_all').on('click',"input",function() {
                if ($(this).is(':checked') == true) {
                    $("input[name='checked_id']").each(function() {
                        $(this).attr("checked",true);
                    });
                }else{
                    $("input[name='checked_id']").each(function() {
                        $(this).attr("checked",false);
                    });
                }
            });
            $("input[name='checked_id']").click(function() {
                if($(this).attr("checked")){
                    $(this).attr("checked","true");
                }else{
                    $(this).removeAttr("checked");
                }
                var num= 0;
                $("input[name='checked_id']").each(function() {
                    if($(this).attr("checked")){
                        num++;
                    }
                });
                if(num==$("input[name='checked_id']").length){
                    $('#select_all').children('input').attr("checked","true");
                }else{
                    $('#select_all').children('input').removeAttr("checked");
                }
            });
        });
</script>
</body>
</html>
