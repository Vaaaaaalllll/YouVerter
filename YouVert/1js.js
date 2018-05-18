// Design / Dribbble by:
// Oleg Frolov
// URL: https://dribbble.com/shots/3072293-Notify-me

$(".cta span").click(function(){
	$(".cta:not(.sent)").addClass("active");
	$("input").focus();
});

$("input").on('input', function(){
			$("button").removeAttr("disabled"); }
);
