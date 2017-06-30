(function ( $ ) {
    $.fn.togglePassword = function( options ) {
        var s = $.extend( $.fn.togglePassword.defaults, options ),
        input = $( this );

        $( s.el ).bind( s.ev, function() {
            "password" == $( input ).attr( "type" ) ?
                $( input ).attr( "type", "text" ) :
                $( input ).attr( "type", "password" );
        });
    };
    $.fn.togglePassword.defaults = {
        ev: "click"
    };
}( jQuery ));
$(function(){
				$('.password').togglePassword({
					el: '.password-box img'
				});
				$(".password-box img").click(function(){
					if($(this).attr('src')==='images/icon-31.png'){
						$(".password-box img").attr('src','images/icon-29.png');
					}else{
						$(".password-box img").attr('src','images/icon-31.png');
					}
					
				});
			});