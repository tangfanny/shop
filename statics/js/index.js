/// <reference path="jquery.js" />
//回到顶部
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
        $(".mainwrap>h2").each(function(k,v)
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
