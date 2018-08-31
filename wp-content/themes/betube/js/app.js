jQuery.noConflict();
//jQuery(document).foundation();
jQuery(document).ready(function(jQuery){
    "use strict";
    
    //login register click
    jQuery(".loginReg").on("click", function(e){
        e.preventDefault();
        jQuery(this).next().slideToggle();
        jQuery(this).toggleClass("active");
    });

	//toggle social share and embed
    jQuery(".social-toggle").on('click', function (e) {
        e.preventDefault();
       jQuery("#socialShare").toggle();
    });
    //toggle embed code
    jQuery(".embed-code").on('click', function (e) {
        e.preventDefault();
        jQuery("#embedVideo").toggle();
    });
	
    //search bar
    jQuery(".betubeSearch").on("click", function(){
        if(jQuery(this).children().hasClass("fa-search")){
            jQuery(this).children().removeClass("fa-search");
            jQuery(this).children().addClass("fa-times");
        }else{
            jQuery(this).children().removeClass("fa-times");
            jQuery(this).children().addClass("fa-search");
        }
        jQuery(this).toggleClass("search-active");
        jQuery("#betube-bar").slideToggle();

    });
	
	//assign height to tag according digits
    jQuery('.height').each(function () {
        var classStr = jQuery(this).attr('class'),
            fh = classStr.substr( classStr.lastIndexOf('-') + 1);
        jQuery(this).css('height', fh);
    });

    //grid system
    jQuery(".grid-system > a").on("click", function(event){
        event.preventDefault();
        var selector = jQuery(this).parent().parent().next().find('div.item');
        var classStr = jQuery(selector).attr('class'),
            lastClass = classStr.substr( classStr.lastIndexOf(' ') + 1);
        jQuery(selector)
        // Remove last class
            .removeClass(lastClass)
            // Put back .item class + the clicked elements class with the added prefix "group-item-".
            .addClass('item group-item-' + jQuery(this).attr('class') );
		jQuery('.grid-default').find('.post').matchHeight();
        jQuery('.grid-medium').find('.post').matchHeight();
        jQuery('.list').find('.post').matchHeight();
    });
	//match height
    jQuery('.group-item-grid-default').find('.post').matchHeight();
	jQuery('.beetube__matchheight').matchHeight();

    //add active class on grid menu
    jQuery(".grid-system > a").on('click', function(){
		
        if(jQuery(this).hasClass("current")!== true)
        {
            jQuery('.grid-system > a').removeClass("current");
            jQuery(this) .addClass("current");
        }
		
    });

    //back to top
    var backtotop = '#back-to-top';
    if (jQuery(backtotop).length) {
        var scrollTrigger = 100, // px
            backToTop = function () {
                var scrollTop = jQuery(window).scrollTop();
                if (scrollTop > scrollTrigger) {
                    jQuery(backtotop).addClass('show');
                } else {
                    jQuery(backtotop).removeClass('show');
                }
            };
        backToTop();
        jQuery(window).on('scroll', function () {
            backToTop();
        });
        jQuery('#back-to-top').on('click', function (e) {
            e.preventDefault();
            jQuery('html,body').animate({
                scrollTop: 0
            }, 700);
        });
    }
    //newsTicker
    jQuery('#newsBar').inewsticker({
        speed       : 2500,
        effect      : 'fade',
        dir         : 'ltr',
        font_size   : 13,
        color       : '#fff',
        font_family : 'arial',
        delay_after : 1000
    });

    //show more and less
    jQuery('.showmore_one').showMore({
        speedDown: 300,
        speedUp: 300,
        height: '165px',
        showText: 'Show more',
        hideText: 'Show less'
    });

    jQuery(".reply").each(function(){
        if(jQuery(this).parent().next().length > 0){
            jQuery(this).html('Hide replies <i class="fa fa-angle-up"></i>');
        }
    });
    //comments reply hide show
    jQuery(".reply").on('click', function(){
       if(jQuery(this).parent().next().length > 0){
           jQuery(this).parent().nextAll().slideToggle();
           //jQuery(this).html(jQuery(this).text() === 'Hide replies' ? 'Show replies' : 'Hide replies');
           if(jQuery(this).hasClass('hide-reply')){
               jQuery(this).removeClass('hide-reply');
               jQuery(this).html('show replies <i class="fa fa-angle-down"></i>');
           }else {
               jQuery(this).addClass('hide-reply');
               jQuery(this).html('Hide replies <i class="fa fa-angle-up"></i>');
           }
       }
    });

    //register form
    jQuery( "div.social-login" ).mouseenter(function() {
        jQuery("i.arrow-left").addClass("active");
    })
    .mouseleave(function() {
        jQuery("i.arrow-left").removeClass("active");
    });
    jQuery( "div.register-form" ).mouseenter(function() {
            jQuery("i.arrow-right").addClass("active");
        })
        .mouseleave(function() {
            jQuery("i.arrow-right").removeClass("active");
        });
	//Tabber
	jQuery(function () {
      jQuery('.content .tabs a[data-tab]').on('click', function (e) {
        e.preventDefault();
        var tab = jQuery(this).attr('data-tab');
        var tabcontent = jQuery(this).closest(".content").find('.tab-content');
        jQuery(tabcontent).each(function(){
            jQuery(this).hide();
            if(jQuery(this).attr('data-content') == tab) {
                jQuery(this).show();
            }
        });
      });
      
    });	
	//vertical thumb slider
    var thumb = jQuery('.thumb-slider .thumbs').find('.ver-thumbnail');
    jQuery(thumb).on('click', function(){
        var id = jQuery(this).attr('id');
        //alert(id);
        jQuery('.image').eq(0).show();
        jQuery('.image').hide();
        jQuery('.'+id).fadeIn();
    });
    var $par = jQuery('.thumb-slider .thumbs .thumbnails').scrollTop(0);
    jQuery('.thumb-slider .thumbs a').click(function( e ) {
        e.preventDefault();                      // Prevent defautl Anchors behavior
        var n = jQuery(this).hasClass("down") ? "+=200" : "-=200"; // Direction
        $par.animate({scrollTop: n});
    });
	// tabber for radio button on submit page
    jQuery('.trigger').on('click', function(e){
        jQuery('.radio-video-links > div').hide();
        jQuery('.trigger input[type="radio"]').each(function(index)
        {
            if(jQuery(this).is(':checked'))
            {
                jQuery('.radio-video-links > div:eq(' + index + ')').show();
            }
        });
    });
	//Video Scroll
	var betubePop = '.betube-pop-video';
	jQuery('.close-betube-pop').on('click', function(){
		jQuery(betubePop).addClass('betube-pop-off');
		jQuery(betubePop).removeClass('single-video-pop');
		jQuery('.close-betube-pop').hide();
	});
	jQuery(window).on('scroll', function() {
		if(jQuery('div').hasClass('betube-pop-video')){
			var offsetTop = jQuery(betubePop).position().top;		
		//var offsetTop = jQuery(betubePop).position().top;
			var divHeight = jQuery(betubePop).height();
			var offsetTopAdd = offsetTop + divHeight;
			if(jQuery(this).scrollTop() >= offsetTopAdd){
				if(jQuery(betubePop).hasClass('betube-pop-off')){
					jQuery(betubePop).removeClass('single-video-pop');
					jQuery('.close-betube-pop').hide();
				}else{
					jQuery(betubePop).addClass('single-video-pop');
					jQuery('.close-betube-pop').show();
				}
			}else{
				jQuery(betubePop).removeClass('single-video-pop');
				jQuery('.close-betube-pop').hide();
			}
		}
	});
	//End Video Scroll
	//add class to parent when sideBar bg exists
    if(jQuery('div').hasClass('sidebarBg')){
        jQuery('.sidebarBg').parent().addClass('sidebar-dark');
    };
	
	jQuery('.group-item-grid-default').find('.post').matchHeight();
	//Profile background Uploading Images//
	function readProfileBGURL(){
        var $input = jQuery(this);
        if (this.files && this.files[0]){
            var reader = new FileReader();
            reader.onload = function(e){               
				var imgURL = e.target.result;				
				jQuery('.topProfile-inner').css("background-image", "url(" + imgURL +")");
            };
            reader.readAsDataURL(this.files[0]);
        }
    }
	jQuery(document).on('change', "#topfileupload", readProfileBGURL); 
	//Profile background Uploading Images//
	//Profile Picture upload//
	function readProfileIMG(){
        var $input = jQuery(this);
        if (this.files && this.files[0]){
            var reader = new FileReader();
            reader.onload = function(e){               
				var imgURL = e.target.result;				
				jQuery('.profile-author-img').children('.author-avatar').attr('src', e.target.result);
            };
            reader.readAsDataURL(this.files[0]);
        }
    }
	jQuery(document).on('change', "#imgfileupload", readProfileIMG); 
	//Profile Picture upload//	

});
// BeTube Loader
jQuery(window).load(function(){	
    // fade out the loading animation
	jQuery("#betubeloader-animation").fadeOut();
    // fade out the preloader animation container 
	jQuery("#betubeloader-container").delay(1000).fadeOut("slow");
});
jQuery(window).on('load', function () {
    jQuery(".betube_mag__carousel_post, .betube_mag__carousel_post_recent").each(function () {
        var myOwl = jQuery(this);
        var owlNum = myOwl.children('.item').length;
        var currentIndex = myOwl.children('div.active').index();
		var datatext = jQuery('.num_carousel_post').data('sep');
        myOwl.next().children('.num_carousel_post').html(''+currentIndex+' '+ datatext +' '+owlNum+'');

        myOwl.on('changed.owl.carousel', function(event) {
			var datatext = jQuery('.num_carousel_post').data('sep');
            var currentItem = event.item.index;			
            var nowItem = currentItem + 1;
            myOwl.next().children('.num_carousel_post').html(''+nowItem+' '+ datatext +' '+owlNum+'');
        });

        myOwl.next().children(".custom__button_carousel_prev").on('click', function (e) {
            e.preventDefault();
            jQuery(this).parent().prev().trigger('prev.owl.carousel');
        });

        myOwl.next().children(".custom__button_carousel_next").on('click', function (e) {
            e.preventDefault();
            jQuery(this).parent().prev().trigger('next.owl.carousel');
        });
    });

    jQuery('.betube_mag__carousel').each(function () {

        jQuery(".prev_mag_carousel").on('click', function (e) {
            e.preventDefault();
            jQuery(this).parent().parent().next().trigger('prev.owl.carousel');
        });

        jQuery(".next_mag_carousel").on('click', function (e) {
            e.preventDefault();
            jQuery(this).parent().parent().next().trigger('next.owl.carousel');
        });
    });



    //Premium carousel
    jQuery('.owl-carousel').each(function(){
        var owl = jQuery(this);
        jQuery(".prev").on('click', function () {
            jQuery(this).parent().parent().parent().parent().next().trigger('prev.owl.carousel');
        });

        jQuery(".next").on('click', function () {
            jQuery(this).parent().parent().parent().parent().next().trigger('next.owl.carousel');
        });
        var loopLength = owl.data('car-length');
        var divLength = jQuery(this).find("div.item").length;
        if(divLength > loopLength){
            owl.owlCarousel({
                dots : owl.data("dots"),
				rtl: owl.data("right"),
                rewind: owl.data("rewind"),
                items: owl.data("items"),
                slideBy : owl.data("slideby"),
                center : owl.data("center"),
                loop : owl.data("loop"),
                margin : owl.data("margin"),
                nav : owl.data("nav"),
                autoplay : owl.data("autoplay"),
                autoplayTimeout : owl.data("autoplay-timeout"),
                autoWidth:owl.data("auto-width"),
                autoHeight:owl.data("auto-Height"),
                merge: owl.data("merge"),
                responsive:{
                    0:{
                        items:owl.data("responsive-small"),
                        nav:false
                    },
                    600:{
                        items:owl.data("responsive-medium"),
                        nav:false
                    },
                    1000:{
                        items:owl.data("responsive-large"),
                        nav:false
                    },
                    1900:{
                        items:owl.data("responsive-xlarge"),
                        nav:false
                    }
                }
            });

        }else{
            owl.owlCarousel({
                dots : false,
                items: owl.data("items"),
                loop: false,
                margin: owl.data("margin"),
                autoplay:false,
                autoplayHoverPause:true,
                responsiveClass:true,
                autoWidth:owl.data("auto-width"),
                autoHeight:owl.data("auto-Height"),
            });
        }
    });


    jQuery('.carousel_mag').each(function(){
        var owl = jQuery(this);
        jQuery("ul#mytabs").on("change.zf.tabs", function() {
            owl.trigger('destroy.owl.carousel');
            // After destory, the markup is still not the same with the initial.
            // The differences are:
            //   1. The initial content was wrapped by a 'div.owl-stage-outer';
            //   2. The '.owl-carousel' itself has an '.owl-loaded' class attached;
            //   We have to remove that before the new initialization.
            owl.html(owl.find('.owl-stage-outer').html()).removeClass('owl-loaded');

            owl.owlCarousel({
                dots : owl.data("dots"),
                items: owl.data("items"),
                slideBy : owl.data("slideby"),
                center : owl.data("center"),
                loop : owl.data("loop"),
                margin : owl.data("margin"),
                nav : owl.data("nav"),
                autoplay : owl.data("autoplay"),
                autoplayTimeout : owl.data("autoplay-timeout"),
                autoWidth:owl.data("auto-width"),
                autoHeight:owl.data("auto-Height"),
                merge: owl.data("merge"),
                responsive:{
                    0:{
                        items:owl.data("responsive-small"),
                        nav:false
                    },
                    600:{
                        items:owl.data("responsive-medium"),
                        nav:false
                    },
                    1000:{
                        items:owl.data("responsive-large"),
                        nav:false
                    },
                    1900:{
                        items:owl.data("responsive-xlarge"),
                        nav:false
                    }
                }
            });
        });

    });
});