$(document).ready(function() {

	$('[data-toggle=popover]').popover();

	$('[data-toogle=tooltip]').tooltip();

    $('#show-menu').click(function() {

        $('nav.navbar').removeClass('navbar-hidden-menu');
        $('.navbar-main-menu').hide().fadeIn('fast');

        $('#hide-menu').show();
        $(this).hide();

        return false;
    });

    $('#hide-menu').click(function() {

        $('nav.navbar').addClass('navbar-hidden-menu');

        $('#show-menu').show();
        $(this).hide();

        return false;
    });

    $('.search-toogle').click(function() {
        var $search = $('.navbar-search-dropdown');

        if ($search.hasClass('hidden')) {
            $search.removeClass('hidden');
        } else {
            $search.addClass('hidden');
        }

        return false;
    });

    // ============================================
    // DEMO ONLY
    // ============================================

    $(".home-video").each(function(i,e ){$(e).vide($(e).attr('rel'))});

    $('#subscribe-newsletter-form').submit(function() {

        $.magnificPopup.open({
            type: 'inline',
            items: { src: '#subscribe-successfully' }
        });

        return false;
    });

    $('.search-filter ul > li > a').click(function() {
        $(this).closest('ul').find('li').removeClass('active');
        $(this).closest('li').addClass('active');
    });
    // ============================================
    // SCROLL MENU
    // ============================================
    $(".tab-products .tab-item li a").click(function() {            
        event.preventDefault();
        var target  = $(this).attr("href").split("#");
        $('html, body').animate({
            scrollTop: $("#"+target[1]).offset().top-41
        }, 2000);
    });

    // ============================================
    // SHOW SUBCATEGORY SHOP
    // ============================================
    $(".arrivals-category .category").click(function(){
        $(".sub-category").toggle( "blind", 
            {direction: "right"},500 );
    });   
    $(".ul-subcat li").click(function(){
        $(this).parents(".ul-subcat").find("li").removeClass("active");
        $(this).addClass("active");
    });

    // ============================================
    // ASC OR DESC quanlity
    // ============================================
    $(".quanlity-wrap .fa-angle-up").click(function(){
        var quanlity = parseInt($(this).parents(".quanlity-wrap").find(".quanlity").val());
        $(this).parents(".quanlity-wrap").find(".quanlity").val(quanlity+1);
    });
    $(".quanlity-wrap .fa-angle-down").click(function(){
        var quanlity = parseInt($(this).parents(".quanlity-wrap").find(".quanlity").val());
        if(quanlity<1)
            $(this).parents(".quanlity-wrap").find(".quanlity").val(0);
        else
            $(this).parents(".quanlity-wrap").find(".quanlity").val(quanlity-1);
    });
    $(".quanlity").change(function(){
        var quanlity = $(this).val();
        if(isNaN(quanlity)){
            alert("Quanlity is number");
            $(this).val(0);
        }
        if(quanlity<1)
            $(this).val(0);
    });
    // ============================================
    // SHOW DROPDOWN
    // ============================================
    $(".u-select .fa-angle-down").click(function(){
        $(this).parents(".u-select").find("ul").toggle(100);
    });
     $(".u-select ul li").click(function(){
        var vItem = $(this).text();
        $(this).parents(".u-select").find(".u-value").val(vItem);
        $(this).parents("ul").hide(100);
    });
     $('.active-pro').hover(function(){ 
        $(this).find(".overflow").fadeIn(200); 
    },function(){
        $(this).find(".overflow").fadeOut(200); 
    });

   // MENU NAV
    // ============================================
    $(".menu-nav li").click(function(){
        $(".menu-nav li").removeClass("active");
        $(this).addClass("active");
    });
     // ============================================
    // SHOW ANSWER
    // ============================================
    $(".policies .item-desc li").click(function(){
        var item = $(this);
        $(".policies .item-desc li").removeClass("active");
        $(this).addClass("active");
        if($(this).hasClass("active")==true){
           $(this).find(".answer").toggle("blind",
                {direction:"up"},200);
        }
           // $(this).find("li").hasClass("answer").toggle("blind",
             //       {direction:"up"},200);
        //}
    });
});

