$(function(){
	$(".nav").toggle(function(){
		$(this).next(".menu").show();
		
		},function(){
		$(this).next(".menu").hide();
	
	});
	
	
	$(".nav").click(function(){
		
		$(this).next(".menu").trigger();
	
	});
	

	
	$(".zhipei span a").click(function(){
		$(".zhipei span a").removeClass("hover")
		$(this).addClass("hover");
	});
	
	// $(".zhipei p a").click(function(){
	// 	$(this).parents("li").find("p a").removeClass("hover")
	// 	$(this).addClass("hover");
	// });
	
	$(".sai dt span").click(function(){
		
		$(".sai dl").animate({left:"100%"});
		setTimeout(function() {
			$(".sai").hide();
		}, 500)
		
		
		
	});
	
	$(".dldt dt span").click(function(){
		$(".sai").show();
		$(".sai dl").animate({left:"10%"});
		
	});
	
	$(".fuku li").click(function(){
		$(".fuku li em").removeClass("hover");
		$(this).find("em").addClass("hover");
		
	});
	
	// $(".color li p a").click(function(){
	// 	$(this).parents("p").find("a").removeClass("hover");
	// 	$(this).addClass("hover");
		
	// });
	
});
$(function(){
    var tabTitle = ".dldt2 dt strong";
    var tabContent = ".dldt2 dd";
    $(tabTitle + ":first").addClass("hover");
    $(tabContent).not(":first").hide();
    $(tabTitle).unbind("click").bind("click", function(){
        $(this).siblings("strong").removeClass("hover").end().addClass("hover");
        var index = $(tabTitle).index( $(this));
        $(tabContent).eq(index).siblings(tabContent).hide().end().fadeIn(0);
    });
});
/**
 * 设置移动端标题
 * @param {type} string
 * @return mixed
 */
function setTitle(string) {
    $("h2#title").text(string);
}

function goback() {
	if(referer != -1) {
		window.location.href= referer; 
	} else {
		history.go(-1);
	}
}

function empty(v){ 
	switch (typeof v){ 
		case 'undefined' : return true; 
		case 'string' : if(trim(v).length == 0) return true; break;
		case 'boolean' : if(!v) return true; break;
		case 'number' : if(0 === v) return true; break;
		case 'object' : if(null === v) return true; 
		if(undefined !== v.length && v.length==0) return true; 
		for(var k in v){return false;} return true; 
			break; 
	}
	return false; 
}

function redirect (url) {
	window.location.href = url;
}
