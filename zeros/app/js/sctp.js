$(function() {
        $("#img").on("change",".filepath",function() {
        	var count = $('#img').children('div .imgbox').length;
        	var index = $('#img .imgbox').index($(this).parent().parent())+1;
            var srcs = getObjectURL(this.files[0]);   //获取路径
            var htmlImg='<div class="imgbox empty">'+
                    '<div class="imgnum">'+
                    '<input type="file"  class="filepath" accept="image/*" name="images'+ new Date().getTime() +'"/>'+
                    '<span class="close"><img src="../zeros/app/images/cha.png"/></span>'+
                    '<img src="../zeros/app/images/btn.png" class="img1" />'+
                    '<img src="" class="img2" />'+
                    '</div>'+
                    '</div>';
            if(count == index){
            	$(this).parent().parent().after(htmlImg);
            }
            $(this).nextAll(".img1").hide();   //this指的是input
            $(this).nextAll('.close').show();
            $(this).nextAll('.img2').attr("src",srcs);
            $(this).parent().parent().attr("class","imgbox");
			if($(this).parent().parent().siblings().length>4){
				$(this).parent().parent().next().remove();
			};
            $(".close").on("click",function() {
                $(this).hide();     //this指的是span
                $(this).nextAll(".img2").hide();
                $(this).nextAll(".img1").show();
                if($('.imgbox').length>1){
                    $(this).parent().parent().remove();
                }
                var box_count = $('#img').children().length;
                var empty_count = $('#img').children('div .empty').length;
                if(box_count == 4 && empty_count < 1){
                	$('#img').append(htmlImg);
                }
            })
        })
    })



    function getObjectURL(file) {
        var url = null;
        if (window.createObjectURL != undefined) {
            url = window.createObjectURL(file)
        } else if (window.URL != undefined) {
            url = window.URL.createObjectURL(file)
        } else if (window.webkitURL != undefined) {
            url = window.webkitURL.createObjectURL(file)
        }
        return url
    };
