//$(function(){
//	$(".adress-box img").click(function(){
//		$(".adress-select").toggle();
//	});
//	$(".ad-xx li").click(function(){
//		$(".adress-select").hide();
//		var target = $(this).data('target');
//		$(".adress").val(target);
//	});
//	$(".adress-select li span").click(function(){
//		$(this).next("ul").toggle();
//	});
//});

$(function(){
	$('.adress-box img').click(function (event) {  
                 //取消事件冒泡  
              event.stopPropagation();  
                $(".reg-bg").slideDown();  
             });  
	$(document).click(function(event){
		  		var _con = $('.login-choice');   // 设置目标区域
				  if(!_con.is(event.target) && _con.has(event.target).length === 0){
					$('.reg-bg').slideUp();   //滑动消失
				  }
			});
});


$(function(){
	$(".group p").click(function(){
		var cit=$(".city").find("option:selected").text();
		var vil=$(".village").find("option:selected").text();
		var bui=$(".build").find("option:selected").text();
		var nub=$(".number").find("option:selected").text();
		$(".adress").val(cit+vil+bui+nub);
		$(".reg-bg").slideUp();
	});
});


$(function(){
	$(".tip").click(function(){
		$(".tip-bg").show();
	});
	$(".tip-bg a").click(function(){
		$(".tip-bg").hide();
	});
})
