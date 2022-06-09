jQuery.noConflict();
jQuery(function($,window,undefined)
{
    'use strict'; 
    var $sidebar   = $(".header-bottom"), 
        $window    = $(window),
        offset     = $sidebar.offset(),
        topPadding = 0;
    if ($sidebar.length)
    {
       var pi_height= 0;
        topPadding = topPadding + parseInt(pi_height);
        $window.scroll(function() 
        {
            if ( $window.scrollTop() > offset.top) 
            {
                $sidebar.addClass('scroll').css({
                    //top: $window.scrollTop() - offset.top + topPadding
                });
            } else {
                $sidebar.removeClass('scroll').css({
                    //top: 0
                });
            }
        });
    } 


    $.fn.reset_all = function () {
        return true;
    };

    $.fn.hash_link = function (hash) {
        if ($(hash).length) {
            if ((hash == '#reviews-tab')) {
                $('.nav-tabs .nav-link.active').removeClass('active');
                $('.tab-content .tab-pane').removeClass('show active');
                $(hash).addClass('active');
                $($(hash).attr('href')).addClass('active').addClass('show');
            }

            $('html, body').animate({
                scrollTop: ($(hash).offset().top - 50)
            }, 1000);
        }
        return true;
    };

    $(window).resize(
        function () {
            $('body').reset_all();
        }
    );

});
jQuery(document).ready(function ($) 
{
    if ($(".custom-file-input").length) {
        $(".custom-file-input").on("change", function() {
          var fileName = $(this).val().split("\\").pop();
          $(this).parents('.custom-file').find(".custom-file-label").addClass("selected").html(fileName);
        });
    }

    $('body').reset_all();
    $('body').hash_link(document.location.hash);

    $('a.hash-link').bind('click', function () {
        $('body').hash_link($(this).attr('href'));
        return false;
    });

    $('button.filter-products').bind('click', function () {
        $('#secondary.woo-sidebar').toggleClass('open');
        return false;
    });
     $('button.close-sidebar').bind('click', function () {
        $('#secondary.woo-sidebar').removeClass('open');
        return false;
    });


    if ($("a.fancy-box-a").length) {
        $("a.fancy-box-a").fancybox({
            'transitionIn': 'elastic',
            'transitionOut': 'elastic',
            'speedIn': 600,
            'speedOut': 200,
            'overlayShow': false
        });
    }

    if ($('.product-images .slides').length) 
    {   
        $('.product-images .slides').slick({
            dots: false,
            arrows: true,
            infinite: true,
            speed: 1000,
            fade:false,
            slidesToShow: 1,
            slidesToScroll: 1,
            adaptiveHeight: true,
            autoplay: true,
            autoplaySpeed: 3000,
            centerMode: false,
            centerPadding: '0',
            nextArrow: $('.product-images .slick-arrow.nextArrow'),
            prevArrow: $('.product-images .slick-arrow.prevArrow'),
        });
        $('.product-images .slides').on('afterChange', animateHeightMultiElemental );
        $('.product-images .slides').on('init', animateHeightMultiElemental );

        var animateHeightMultiElemental = function(event, slick, currentSlide, nextSlide) {
            debugger;
            var _ = slick;
            var targetHeight = 0;
            var $activeSlides;
            if (_.options.adaptiveHeight === true && _.options.vertical === false) {
                $activeSlides = _.$slideTrack.find('.slick-active');
                // Находим наибольшую высоту у показываемых слайдов
                $activeSlides.each(function() {
                    var height = $(this).outerHeight(true);
                    if (targetHeight < height) {
                        targetHeight = height;
                    }
                });
                _.$list.animate({
                    height: targetHeight
                }, _.options.speed);
            }
        }
    }

    if ($('.img-slider .slides').length) 
    {   
        $('.img-slider .slides').slick({
            dots: false,
            arrows: true,
            infinite: false,
            speed: 1000,
            fade:false,
            slidesToShow: 4,
            slidesToScroll: 4,
            adaptiveHeight: false,
            autoplay: false,
            autoplaySpeed: 3000,
            centerMode: false,
            centerPadding: '0',
            nextArrow: $('.img-slider .slick-arrow.nextArrow'),
            prevArrow: $('.img-slider .slick-arrow.prevArrow'),
            
        });
    }


    

    if ($('#home-slider .slides').length) 
    {   
        $('#home-slider .slides').slick({
            dots: false,
            arrows: true,
            infinite: true,
            speed: 3000,
            fade:false,
            slidesToShow: 1,
            slidesToScroll: 1,
            adaptiveHeight: false,
            autoplay: true,
            autoplaySpeed: 3000,
            centerMode: true,
            centerPadding: '0',
            responsive: [{
                breakpoint: 1300,
                settings: {
                    centerPadding: 0
                }
            }],
            nextArrow: $('#home-slider .slick-arrow.nextArrow'),
            prevArrow: $('#home-slider .slick-arrow.prevArrow'),
        });
    }

    if ($('#home-products .slides').length) 
    {   
        $('#home-products .slides').slick({
            dots: false,
            infinite: true,
            arrows: true,
            speed: 2000,
            slidesToShow: 4,
            slidesToScroll: 2,
            autoplay: true,
            autoplaySpeed: 3000,
            nextArrow: $('#home-products .slick-arrow.prevArrow'),
            prevArrow: $('#home-products .slick-arrow.nextArrow'),
            responsive: [{
                breakpoint: 1024,
                settings: {slidesToShow: 3}
            },{
                breakpoint: 768,
                settings: {slidesToShow: 2}
            },{
                breakpoint: 500,
                settings: {slidesToShow: 1}
            }]
        });
    }

    $('select.woo-variation-raw-type-image').bind('change',function(){
       // event.preventDefault();
        //return false;
    });

    $('li.image-variable-item').bind('click',function(e){
        var image= $(this).data('image');
        $('li.image-variable-item').removeClass('selected');
        if(image)
        {
            e.preventDefault();
            var aname= $(this).parent('ul').attr('data-attribute_name');
            var _id=$(this).attr('data-id');
            var ind=$('.swatch-item-'+_id).attr('data-slick-index');
            jQuery('.woocommerce-product-gallery_thumb_image.swatch-item-'+_id+' .d-block')[0].click();;
            $('.img-slider .slides').slick('slickGoTo', ind);
            
            

            // $('.woocommerce-product-gallery__image img.wp-post-image').attr('src',image).attr('data-src','').attr('srcset','');  
            // $('select[name="'+aname+'"].woo-variation-raw-select').val($(this).attr('data-value'));

            // $(this).parents('tr').find('.woo-selected-variation-item-name').html(': '+ $(this).attr('data-title'));
            // $(this).addClass('selected');
            // return false;
        }
    });

    $('.woocommerce-product-gallery_thumb_image a').bind('click',function(){
        var image= $(this).attr('href');
        //alert(image);
        $('.woocommerce-product-gallery__image').attr('data-thumb',image);
        $('.woocommerce-product-gallery__image').find('a').attr('href',image);
        $('.woocommerce-product-gallery__image').find('img.wp-post-image').attr('src',image).attr('data-src','').attr('srcset','').attr('data-large_image','');  
        return false;
    });

    $( "#secondary.sidebar .widget " ).each(function() {
      var id=$(this).attr('id');
      $(this).find('.widget-header').attr('id','h-'+id);
      $(this).find('.collapse').attr('id','b-'+id).attr('aria-labelledby','h-'+id);
      $(this).find('.widget-title').attr('data-target','#b-'+id);
    });

    $('.decrease-qty').bind('click',function()
    {
        var qty=$('.form-control.qty').val();
        if(qty<=1){
            $('.form-control.qty').val(0)
        }else{
            $('.form-control.qty').val(qty-1)
        }
    });

    $('.increase-qty').bind('click',function()
    {
        var qty=$('.form-control.qty').val();
        $('.form-control.qty').val(parseInt(qty)+1);
        
    });

    $("form").on("click", "button.add-to-wishlist", function(){
        var elm=$(this);
        var pid=elm.attr('data-product');
        var ajx_url=wc_add_to_cart_params.ajax_url;
        if(pid && ajx_url)
        {
            var _target=$('.product-info');
            $.ajax({
                url: ajx_url,
                data: {action:'add_to_wishlist', pid:pid},
                method: 'post',
                traditional: false,
                cache: false,
                beforeSend: function(xhr){
                    elm.find('i.fas').addClass('fa-spinner fa-spin');
                },
                success: function(result, status, xhr) {
                    elm.find('i.fas').removeClass('fa-spinner fa-spin');
                    if(result=='true'){
                        elm.removeClass('add-to-wishlist').addClass('remove-wishlist');
                        elm.find('span').html('Remove From Wishlist');

                    }else{

                    }
                },
                error: function(xhr, status, error) {
                    elm.find('i.fas').removeClass('fa-spinner fa-spin');
                },
                complete: function(xhr, status) {                 
                }
            });
        }
        return false;
    });

    $("form").on("click", "button.remove-wishlist", function(){
        var elm=$(this);
        var pid=elm.attr('data-product');
        var ajx_url=wc_add_to_cart_params.ajax_url;
        if(pid && ajx_url)
        {
            var _target=$('.product-info');
            $.ajax({
                url: ajx_url,
                data: {action:'remove_wishlist', pid:pid},
                method: 'post',
                traditional: false,
                cache: false,
                beforeSend: function(xhr){
                    elm.find('i.fas').addClass('fa-spinner fa-spin');
                },
                success: function(result, status, xhr) {
                    elm.find('i.fas').removeClass('fa-spinner fa-spin');
                    if(result=='true'){
                        elm.removeClass('remove-wishlist').addClass('add-to-wishlist');
                        elm.find('span').html('Add to Wishlist');
                    }else{

                    }
                },
                error: function(xhr, status, error) {
                    elm.find('i.fas').removeClass('fa-spinner fa-spin');
                },
                complete: function(xhr, status) {                 
                }
            });
        }
        return false;
    });

});