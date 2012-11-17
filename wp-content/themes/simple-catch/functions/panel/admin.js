jQuery( document ).ready( function() {
	var selected = 0;
	if( jQuery.cookie( 'simplecatch_ad_tab' ) ) {
		selected = jQuery.cookie( 'simplecatch_ad_tab' );
		jQuery.cookie( 'simplecatch_ad_tab', null );
	}
	
	var tabs = jQuery( '#simplecatch_ad_tabs' ).tabs( { selected: selected } );
	
	jQuery( '#wpbody-content form' ).submit( function() {
		var selected = tabs.tabs( 'option', 'selected' );
		jQuery.cookie( 'simplecatch_ad_tab', selected );
	} );
	
	jQuery( '.sortable' ).sortable( {
		handle: 'label',
		update: function( event, ui ) {
			var index = 1;
			var attrname = jQuery( this ).find( 'input:first' ).attr( 'name' );
			var attrbase = attrname.substring( 0, attrname.indexOf( '][' ) + 1 );
			
			jQuery( this ).find( 'tr' ).each( function() {
				jQuery( this ).find( '.count' ).html( index );
				jQuery( this ).find( 'input' ).attr( 'name', attrbase + '[' + index + ']' );
				index++;
			} );
		}
	} );
} );

// Show Hide Toggle Box
jQuery(document).ready(function($){
	
	$(".option-content").hide();

	$("h3.option-toggle").click(function(){
	$(this).toggleClass("option-active").next().slideToggle("fast");
		return false; 
	});

});
jQuery(document).ready(function ($) {
    setTimeout(function () {
        $(".fade").fadeOut("slow", function () {
            $(".fade").remove();
        });

    }, 2000);
});

jQuery( document ).ready( function() {
	// Colorpicker for Heading
    jQuery('#colorpicker_heading_color').farbtastic('#simplecatch_heading_color');
    
    jQuery('#simplecatch_heading_color').blur( function() {
            jQuery('#colorpicker_heading_color').hide();
    });
    
    jQuery('#simplecatch_heading_color').focus( function() {
            jQuery('#colorpicker_heading_color').show();
    });	
	
	// Colorpicker for Meta Description
    jQuery('#colorpicker_meta_color').farbtastic('#simplecatch_meta_color');
    
    jQuery('#simplecatch_meta_color').blur( function() {
            jQuery('#colorpicker_meta_color').hide();
    });
    
    jQuery('#simplecatch_meta_color').focus( function() {
            jQuery('#colorpicker_meta_color').show();
    });		
								   
	// Colorpicker for Text
    jQuery('#colorpicker_text_color').farbtastic('#simplecatch_text_color');
    
    jQuery('#simplecatch_text_color').blur( function() {
            jQuery('#colorpicker_text_color').hide();
    });
    
    jQuery('#simplecatch_text_color').focus( function() {
            jQuery('#colorpicker_text_color').show();
    });
	// Colorpicker for Link
    jQuery('#colorpicker_link_color').farbtastic('#simplecatch_link_color');
    
    jQuery('#simplecatch_link_color').blur( function() {
            jQuery('#colorpicker_link_color').hide();
    });
    
    jQuery('#simplecatch_link_color').focus( function() {
            jQuery('#colorpicker_link_color').show();
    });	
	
	// Colorpicker for Text
    jQuery('#colorpicker_widget_heading_color').farbtastic('#simplecatch_widget_heading_color');
    
    jQuery('#simplecatch_widget_heading_color').blur( function() {
            jQuery('#colorpicker_widget_heading_color').hide();
    });
    
    jQuery('#simplecatch_widget_heading_color').focus( function() {
            jQuery('#colorpicker_widget_heading_color').show();
    });
	// Colorpicker for Sidebar Widget Text Color
    jQuery('#colorpicker_widget_text_color').farbtastic('#simplecatch_widget_text_color');
    
    jQuery('#simplecatch_widget_text_color').blur( function() {
            jQuery('#colorpicker_widget_text_color').hide();
    });
    
    jQuery('#simplecatch_widget_text_color').focus( function() {
            jQuery('#colorpicker_widget_text_color').show();
    });		
});	