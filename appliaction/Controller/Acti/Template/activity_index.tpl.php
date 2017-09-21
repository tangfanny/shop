<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE"/>
    <script>
          var userAgentInfo = navigator.userAgent;
          var Agents = ["Android", "iPhone",
                      "SymbianOS", "Windows Phone",
                      "iPad", "iPod"];
          var flag = true;
          for (var v = 0; v < Agents.length; v++) {
              if (userAgentInfo.indexOf(Agents[v]) > 0) {
                  flag = false;
                  break;
              }
          }
          var oCss = document.createElement("link");
          oCss.setAttribute("rel", "stylesheet");
          oCss.setAttribute("type", "text/css");


      if(flag == true){
        oCss.setAttribute("href", "<?php echo PUBLIC_URL; ?>acti/css/index<?php echo $acti['t_id']?>.css");
      }else{
        oCss.setAttribute("href", "<?php echo PUBLIC_URL; ?>acti/css/index_m<?php echo $acti['t_id']?>.css");
        var oMeta = document.createElement('meta');
        oMeta.setAttribute('content','width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no');
        oMeta.setAttribute('name','viewport');
        document.getElementsByTagName('head')[0].appendChild(oMeta);
        var Jjs = document.createElement("script");
        Jjs.setAttribute("type", "text/javascript");
        Jjs.setAttribute("src", "<?php echo PUBLIC_URL; ?>acti/js/config.js");
        document.getElementsByTagName('head')[0].appendChild(Jjs);
          }
       document.getElementsByTagName("head")[0].appendChild(oCss);//绑定
</script>
    <title><?php echo $acti['name']?></title>
    <link href="<?php echo PUBLIC_URL; ?>acti/css/reset.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="http://www.secwk.com/favicon.ico" type="image/x-icon">
    <script type="text/javascript" src="<?php echo PUBLIC_URL; ?>acti/js/jquery.js"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>

  if(flag == false){
        var title="<?php echo $acti['s_title'];?>";
        var desc="<?php echo $acti['s_desc'];?>";
        var link= "<?php echo $acti['url'];?>";
        var imgUrl= "<?php  echo IMG_URL. $acti['s_img'];?>";
          wx.config({
          debug: false,
          appId: '{$signPackage['appId']}',
          timestamp: '{$signPackage['timestamp']}',
          nonceStr: '{$signPackage['nonceStr']}',
          signature: '{$signPackage['signature']}',
          jsApiList: [
            // 所有要调用的 API 都要加到这个列表中
            'onMenuShareTimeline',
            'onMenuShareAppMessage'
          ]
          });
            wx.ready(function () {
                  var shareData = {
                  title: title,
                  desc: desc,
                  link: link,
                  imgUrl: imgUrl
                  };
                  wx.onMenuShareAppMessage(shareData);
                  wx.onMenuShareTimeline(shareData);
                });
            wx.error(function (res) {
                  //alert(res.errMsg);
            });
  }
</script>
<!--<script src="--><?php //echo PUBLIC_URL; ?><!--acti/js/config.js"></script>-->
<style>
  .adv1{margin-bottom:5px;}
  .adv3{margin-bottom:5px;}
  .adv5{margin-bottom:5px;}
  .adv7{margin-bottom:5px;}
  .adv9{margin-bottom:5px;}
  .gotop1{position: fixed;bottom: 10px;right: 10px;z-index: 4;}
</style>
</head>
<body>
    <div id="wrap" style="background: <?php echo $acti['b_c']?>;">
        <a class="banner" href="<?php echo $banner[url]?>">
            <img src="<?php echo IMG_URL.$banner[pic]?>" style="width:100%;">
            <input type="hidden" name="inid" value="<?php echo $id; ?>"/>
        </a>
<?php if($acti['t_id'] == 1):?>
        <div class="mainwrap">
          <div class="zhuti">
            <?php foreach ($ars as $k=>$vo):?>
                    <?php if($vo["img"]!=null):?>
                        <a class="p_s" href="<?php if($vo["img"][0]['url'] != ''){echo $vo["img"][0]['url'];}elseif($vo['img'][0]['url'] == '' && $vo['img']['0']['gid'] == null ){ echo '#';}else{echo '/Goods/Goods/gid/'.$vo["img"][0]['gid'];}?>" style="display:none;"><img src="<?php echo IMG_URL.$vo['img'][0]['path'];?>" class="adv adv<?php echo ($k);?>" id="fly<?php echo $k?>" /></a>
                        <a class="m_s" href=<?php if($vo[img][0][url] != ''){echo $vo[img][0][url];}elseif($vo['img'][0]['url'] == '' && $vo['img']['0']['gid'] == null ){ echo '#';}else{echo "javascript:goGoodsPage('".$vo[img][0][gid]."')";}?> style="display:none;"><img src="<?php echo IMG_URL.$vo['img'][0]['path'];?>" class="adv adv<?php echo ($k);?>" id="fly<?php echo $k?>" /></a>
                    <?php endif;?>

                    <?php if($vo["goods"]!=null):?>
                        <div class="mxd">
                            <?php foreach ($vo['goods'] as $ke=>$v):?>
                                <div class="c1">
                                    <div class="c2">
                                        <a class="p_s" href="<?php if($v['url'] != ''){echo $v['url'];}else{echo '/Goods/Goods/gid/'.$v['gid'];}?>" style="display:none;">
                                          <img src="<?php echo IMG_URL.$v['path']?>"/>
                                        </a>
                                        <a class="m_s" href="<?php if($v['url'] != ''){echo $v['url'];}else{echo "javascript:goGoodsPage('"."$v[gid]"."')";}?>" style="display:none;">
                                          <img src="<?php echo IMG_URL.$v['path']?>"/>
                                        </a>
                                    </div>
                                    <a href="<?php if($v['url'] != ''){echo $v['url'];}else{echo '/Goods/Goods/gid/'.$v['gid'];}?>" class="c3"><?php echo $v['name']?></a>
                                    <del>市场价：¥<?php echo $v['s_price']?></del>
                                    <span class="c4"><span>威客价：</span>¥<?php echo $v['p_price']?></span>
                                    <div class="c5">
                                        <a class="p_s" href="<?php if($v['url'] != ''){echo $v['url'];}else{echo '/Goods/Goods/gid/'.$v['gid'];}?>" style="display:none;">立即购买</a>
                                        <a class="m_s" href=<?php if($v['url'] != ''){echo $v['url'];}else{echo "javascript:goGoodsPage('"."$v[gid]"."')";}?> style="display:none;">立即购买</a>
                                    </div>
                                    <span class="icon"></span>
                                </div>
                            <?php endforeach;?>
                        </div>
                    <?php endif;?>
            <?php endforeach;?>
        </div>
        </div>
        <div id="temp1" class="fj">
            <i></i>
            <div class="c1">
            <?php foreach ($nav as $k=>$vo):?>
                <a href="#fly<?php echo $vo['cid']?>" class="fly<?php echo $vo['cid']?>"><?php echo $vo['name']?></a>
            <?php endforeach;?>
                <p id="gotop"><span></span>回到顶部</p>
                </div>
            <img src="<?php echo PUBLIC_URL; ?>acti/images/img14.png" />
        </div>
            <div class="gotop">返回顶部</div>
    <script>
        if(flag == false){
          $(".m_s").css('display','block');
          $('#temp1').css('display','none');
          var scrollbox=$(".gotop");
          scrollbox.css("display","none");
          $(window).scroll(function()
          {
              var top=document.documentElement.scrollTop||document.body.scrollTop;
              if(top>200)
              {
                  scrollbox.fadeIn(800)
              }
              else
              {
                  scrollbox.fadeOut(800)
              }


          });
          scrollbox.click(function()
          {
              $("html,body").animate({ "scrollTop": 0 },500);
          });
        }else{
          $(".p_s").css('display','block');
          var fj=$(".gotop");
          var scrollbox=$(".gotop p");
          fj.css("display","none");
          // $('.fj').css('display','none');
          $('.gotop').css('display','none');
          var fj=$(".fj");
          var scrollbox=$("#gotop");
          fj.css("display","none");

          /*锚点*/
          var clickevent=false;
          $(".fj .c1>a").click(function()
          {
              clickevent=true;
              $('html,body').animate({ scrollTop: $('#'+this.className).offset().top-20 },800,function()
              {
                  clickevent=false;
              });
              $(".fj .c1>a").removeClass("select");
              $(this).addClass("select");
          })

          var daohang=$(".fj a"),tick
          $(window).scroll(function()
          {
              var top=document.documentElement.scrollTop||document.body.scrollTop;
              if(top>660)
              {
                  fj.fadeIn(800)
              }
              else
              {
                  fj.fadeOut(800)
              }
              if(!clickevent)
              {
                  $(".mainwrap").find('.adv').each(function(k,v)
                  {
                      if(top>$(v).offset().top-30)
                      {
                          daohang.removeClass("select");
                          daohang.eq(k).addClass("select");
                      }
                  });
              }

          });
          var zhiding=$("#gotop");
          zhiding.click(function()
          {
              $("html,body").animate({ "scrollTop": 0 },500);
          });

        }
    </script>

<?php elseif($acti['t_id'] == 2):?>
        <div class="mainwrap">
            <?php foreach ($ars as $k=>$vo):?>
                    <?php if($vo["img"][1] != null):?>
                      <div class="zq zp_c" style="display:none;">
                        <?php foreach ($vo['img'] as $ke=>$v):?>
                            <a href="<?php if($v['url'] != ''){echo $v['url'];}elseif($v['url'] == '' && $v['gid'] == null){echo '#';}else{echo '/Goods/Goods/gid/'.$v['gid'];}?>"><img src="<?php echo IMG_URL.$v['path'];?>" class="adv adv1 <?php if($ke == 2) echo c1?>" id="fly<?php echo $v['cid']?>"/></a>
                        <?php endforeach;?>
                      </div>

                      <div class="zq zm_c" style="display:none;">
                        <?php foreach ($vo['img'] as $ke=>$v):?>
                            <a href=<?php if($v['url'] != ''){echo $v[url];}elseif($v['url'] == '' && $v['gid'] == null){echo '#';}else{echo "javascript:goGoodsPage('"."$v[gid]"."')";}?>><img src="<?php echo IMG_URL.$v['path'];?>" class="adv adv1 <?php if($ke == 1) echo c1?>" id="fly<?php echo $v['cid']?>"/></a>
                        <?php endforeach;?>
                      </div>
                    <?php elseif($vo["img"][0] != null && $vo["img"][1] == null):?>
                        <?php foreach ($vo['img'] as $ke=>$v):?>
                            <a class="p_c" href="<?php if($v['url'] != ''){echo $v['url'];}elseif($v['url'] == '' && $v['gid'] == null){echo '#';}else{echo '/Goods/Goods/gid/'.$v['gid'];}?>" style="display:none;"><img src="<?php echo IMG_URL.$v['path'];?>" class="adv adv1" id="fly<?php echo $v['cid']?>" style="width:100%;"/></a>
                        <?php endforeach;?>

                        <?php foreach ($vo['img'] as $ke=>$v):?>
                            <a class="m_c" href=<?php if($v['url'] != null){echo $v[url];}elseif($v['url'] == '' && $v['gid'] == null){echo '#';}else{echo "javascript:goGoodsPage('"."$v[gid]"."')";}?> style="display:none;"><img src="<?php echo IMG_URL.$v['path'];?>" class="adv adv1" id="fly<?php echo $v['cid']?>" style="width:100%;"/></a>
                        <?php endforeach;?>
                  <?php endif;?>
            <?php if($vo["goods"]!=null):?>
                      <div class="wl" style="display:none;">
                          <?php foreach ($vo['goods'] as $ke=>$v):?>
                              <div class="zj">
                                <div class="c1">
                                  <div class="c2">
                                        <a class="p_s" href="<?php if($v['url'] != ''){echo $v['url'];}else{echo '/Goods/Goods/gid/'.$v['gid'];}?>" style="display:none;">
                                          <img src="<?php echo IMG_URL.$v['path']?>"/>
                                        </a>
                                        <a class="m_s" href=<?php if($v['url'] != null){echo $v[url];}else{echo "javascript:goGoodsPage('"."$v[gid]"."')";}?> style="display:none;">
                                          <img src="<?php echo IMG_URL.$v['path']?>"/>
                                        </a>
                                  </div>
                                  <a href="<?php if($v['url'] != ''){echo $v['url'];}else{echo '/Goods/Goods/gid/'.$v['gid'];}?>" class="c3"><?php echo $v['name']?></a>
                                  <div class="c6">
                                    <?php foreach($v['Tag'] as $key=>$val):?>
                                        <span><?php echo $val['name']?></span>
                                    <?php endforeach;?>
                                  </div>
                                  <div class="c4"><span>威客价：</span>¥<?php echo $v['p_price']?></div>
                                  <div class="c5">
                                        <a class="p_s" href="<?php if($v['url'] != ''){echo $v['url'];}else{echo '/Goods/Goods/gid/'.$v['gid'];}?>" style="display:none;">立即购买</a>
                                        <a class="m_s" href=<?php if($v['url'] != null){echo $v[url];}else{echo "javascript:goGoodsPage('"."$v[gid]"."')";}?> style="display:none;">立即购买</a>
                                  </div>
                                </div>
                              </div>
                          <?php endforeach;?>
                      </div>
                        <div class="part" style="display:none;">
                          <?php foreach ($vo['goods'] as $ke=>$v):?>

                                <div class="c1">
                                  <div class="c2">
                                      <a class="p_s" href="<?php if($v['url'] != ''){echo $v['url'];}else{echo '/Goods/Goods/gid/'.$v['gid'];}?>" style="display:none;">
                                        <img src="<?php echo IMG_URL.$v['path']?>"/>
                                      </a>
                                      <a class="m_s" href=<?php if($v['url'] != null){echo $v[url];}else{echo "javascript:goGoodsPage('"."$v[gid]"."')";}?> style="display:none;">
                                        <img src="<?php echo IMG_URL.$v['path']?>"/>
                                      </a>
                                  </div>
                                  <div class="c3">
                                    <a href="<?php if($v['url'] != ''){echo $v['url'];}else{echo '/Goods/Goods/gid/'.$v['gid'];}?>" class="c4"><?php echo $v['name']?></a>
                                    <div class="c5">
                                    <?php foreach($v['Tag'] as $key=>$val):?>
                                        <span><?php echo $val['name']?></span>
                                    <?php endforeach;?>
                                    </div>
                                    <div class="c6"><span>￥</span><?php echo $v['p_price']?></div>
                                    <div class="c7">
                                        <a class="p_s" href="<?php if($v['url'] != ''){echo $v['url'];}else{echo '/Goods/Goods/gid/'.$v['gid'];}?>" style="display:none;">立即购买</a>
                                        <a class="m_s" href=<?php if($v['url'] != null){echo $v[url];}else{echo "javascript:goGoodsPage('"."$v[gid]"."')";}?> style="display:none;">立即购买</a>
                                    </div>
                                  </div>
                                </div>

                          <?php endforeach;?>
                        </div>
                    <?php endif;?>
            <?php endforeach;?>

        </div>
        <div class="gotop" id="floatop" >
            <img src="<?php echo PUBLIC_URL; ?>acti/images/img16.png" class="c1"/><img src="<?php echo PUBLIC_URL; ?>acti/images/img16.png" class="c2"/>
            <div>
            <?php foreach ($nav as $k=>$vo):?>
                <a href="#fly<?php echo $vo['cid']?>" class="fly<?php echo $vo['cid']?>"><span><?php echo $vo['name']?></span></a>
            <?php endforeach;?>
            <p><span>返回顶部</span></p>
            </div>
        </div>
        <img id="m_top"src="<?php echo PUBLIC_URL; ?>acti/images/img21.png">
    <script>
        if(flag == false){
          $('.part').css('display','block');
          $('.zm_c').css('display','block');
          $('#floatop').css('display','none');
          $(".m_s").css('display','block');
          var scrollbox=$("#m_top");
          scrollbox.css("display","none");
          $(window).scroll(function()
          {
              var top=document.documentElement.scrollTop||document.body.scrollTop;
              if(top>200)
              {
                  scrollbox.fadeIn(800)
              }
              else
              {
                  scrollbox.fadeOut(800)
              }


          });
          scrollbox.click(function()
          {
              $("html,body").animate({ "scrollTop": 0 },500);
          });
        }else{
          $('.zp_c').css('display','block');
          $('.wl').css('display','block');
           //$('.fj').css('display','none');
           $(".p_s").css('display','block');
           $('#m_top').css('display','none');
            var fj=$(".gotop");
            var scrollbox=$(".gotop p");
            fj.css("display","none");

          /*锚点*/
          var clickevent=false;
          $(".gotop div a").click(function()
          {
              clickevent=true;
              $('html,body').animate({ scrollTop: $('#'+this.className).offset().top-20 },800,function()
              {
                  clickevent=false;
              });
              $(".gotop div a").removeClass("select");
              $(this).addClass("select");
          })

          var daohang=$(".gotop div a"),tick
          $(window).scroll(function()
          {
              var top=document.documentElement.scrollTop||document.body.scrollTop;
              if(top>660)
              {
                  fj.fadeIn(800)
              }
              else
              {
                  fj.fadeOut(800)
              }
              if(!clickevent)
              {
                  $(".mainwrap").find('.adv').each(function(k,v)
                  {
                      if(top>$(v).offset().top-30)
                      {
                          daohang.removeClass("select");
                          daohang.eq(k).addClass("select");
                      }
                  });
              }

          });
          var zhiding=$(".gotop p");
          zhiding.click(function()
          {

              $("html,body").animate({ "scrollTop": 0 },500);
          });

        }
    </script>
    <script>
        if(flag == false){
          $('.part').css('display','block');
          $('.zm_c').css('display','block');
        }else{
          $('.zp_c').css('display','block');
          $('.wl').css('display','block');
        }


    </script>
<?php endif;?>

    </div>
</body>
</html>
