/**
 *商品图册 @lcl 2014-11-11 11:46:57
 */
$(function() {
	//选择默认
	$(".filelist li img").live('click', function() {
		$(".filelist li").css("border", "1px solid #3b72a5");
		$(".filelist li").find("span").hide();
		$(this).parent().css("border", "1px solid #f48c3a");
		$(this).parent().find(".setdef").show();
		//排序
		$(this).parent().siblings().attr("order", "100");
		$(this).parent().attr("order", "99");
		var li = $('.filelist li').toArray().sort(function(a, b) {
			return parseInt($(a).attr("order")) - parseInt($(b).attr("order"));
		});
		$('.filelist').html(li);
	});
	//显示删除
	//$("#scan").live({
	//	mouseenter: function() {
	//		document.getElementById("getdel").style.display="block";
	//	},
	//	mouseleave: function() {
	//		document.getElementById("getdel").style.display="none";
	//	}
	//});


});