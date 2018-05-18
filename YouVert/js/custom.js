
(function($) {
    // 'use strict';

   

    // Back to Top
    if ( $( '.back-to-top' ).length) {
        var scrollTrigger = 500, // px
            backToTop = function () {
                var scrollTop = $(window).scrollTop();
                if (scrollTop > scrollTrigger) {
                    $('.back-to-top').addClass('show');
                } else {
                    $('.back-to-top').removeClass('show');
                }
            };
        backToTop();
        $(window).on('scroll', function () {
            backToTop();
        });
        $('.back-to-top').on('click', function (e) {
            e.preventDefault();
            $('html,body').animate({
                scrollTop: 0
            }, 800);
        });
    }
	
	$(".cta span").click(function(){
	$(".cta:not(.sent)").addClass("active");
	$("input").focus();
});

$("input").on('input', function(){
			$("button").removeAttr("disabled"); }
);


})(jQuery);

