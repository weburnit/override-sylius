/*$(document).ready(function(){
	//show sub category
	$(".arrivals-category .category").click(function(){
		$(".sub-category").toggle( "blind", 
                     {direction: "right"},500 );
	});
	//active
	$(".ul-subcat li").click(function(){
		$(this).parents(".ul-subcat").find("li").removeClass("active");
		$(this).addClass("active");
	});

	//WORTH THE MONEY
	$('#work-money').carouFredSel({
		auto: false,
		prev: '#prev2',
		next: '#next2',
		pagination: "#pager2",
		mousewheel: true,
		swipe: {
			onMouse: true,
			onTouch: true
		}
	});

});