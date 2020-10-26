jQuery(function () {
        jQuery.stellar({
            horizontalScrolling: false,
            verticalOffset: 0
        });
    });
    
jQuery(document).ready( function() {
	
	var elem =  jQuery('#infinite-handle').detach();
	jQuery('#main').append(elem);


    jQuery('.menu-link').bigSlide(
        {
            easyClose:true,
            'side': 'left',
            'speed': '550',
            'menuWidth': '50%',
        }
    );
});  

// Handle new items appended by infinite scroll
jQuery(document).on('post-load', function() {
	setInterval( function() {
			var elem =  jQuery('#infinite-handle').detach();
			jQuery('#main').append(elem);
		}, 0 );
});

jQuery(window).load(function() {
    jQuery('#nivoSlider').nivoSlider({
        prevText: "<i class='fa fa-chevron-circle-left'></i>",
        nextText: "<i class='fa fa-chevron-circle-right'></i>",
        pauseTime: 5000,
        beforeChange: function() {
	    jQuery('.slider-wrapper .nivo-caption').animate({
													opacity: 0,
													},500,'linear');
        },
        afterChange: function() {
	        jQuery('.slider-wrapper .nivo-caption').animate({
													opacity: 1,
													},500,'linear');
        },
        animSpeed: 700,
        
    });
});  
