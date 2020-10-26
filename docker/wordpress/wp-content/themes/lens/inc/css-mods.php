<?php
/* 
**   Custom Modifcations in CSS depending on user settings.
*/

function lens_custom_css_mods() {

	echo "<style id='custom-css-mods'>";
	
	//TItle Tagline hidden.
	if ( get_theme_mod('lens_hide_title_tagline') ) :
		echo "#masthead .site-branding #text-title-desc { display: none; }";
	endif;
	
	//If Title and Desc is set to Show Below the Logo
	if (  get_theme_mod('lens_branding_below_logo') ) :	
		echo "#masthead #text-title-desc { display: block; clear: both; } ";
	endif;
	
	
	
	//Exception: IMage transform origin should be left on Left Alignment, i.e. Default
	if ( !get_theme_mod('lens_center_logo') ) :
		echo "#masthead #site-logo img { transform-origin: left; }";
	endif;	
	
	
	//Modify Menu bars, if header image has been set
	if ( get_header_image() ) :
		// echo "#site-navigation { background: ".lens_fade("#f4f4f4", 0.9)."; }";
	endif;
	
	if ( get_theme_mod('lens_himg_darkbg',true ) ) :
		echo "#masthead .layer { background: rgba(0,0,0,0.5); }";
	endif;
	
	if ( get_theme_mod('lens_title_font') ) :
		echo ".title-font, h1, h2, .section-title, #static-bar ul li a { font-family: ".esc_html( get_theme_mod('lens_title_font') )."; }";
	endif;
	
	if ( get_theme_mod('lens_body_font') ) :
		echo "body, .body-font { font-family: ".esc_html( get_theme_mod('lens_body_font') )."; }";
	endif;
	
	if ( get_theme_mod('lens_site_titlecolor') ) :
		echo "#masthead h1.site-title a { color: ".esc_html( get_theme_mod('lens_site_titlecolor', '#FFFFFF') )."; }";
	endif;
	
	
	if ( get_theme_mod('lens_header_desccolor','#c4c4c4') ) :
		echo "#masthead h2.site-description { color: ".esc_html( get_theme_mod('lens_header_desccolor','#FFFFFF') )."; }";
	endif;
	
	//Check Jetpack is active
	if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) )
		echo '.pagination { display: none; }';
	
	if (  get_theme_mod('lens_aboutme_bgimg') ) {
		echo '#aboutme { background: url('.get_theme_mod("lens_aboutme_bgimg").') fixed; background-size: cover; }';
	}
	
	if ( get_theme_mod('lens_custom_css') ) :
		echo  esc_html( get_theme_mod('lens_custom_css') );
	endif;
	
	
	if ( get_theme_mod('lens_logo_resize') ) :
		$val = esc_html( get_theme_mod('lens_logo_resize') )/100;
		echo "#masthead #site-logo img { transform: scale(".$val."); -webkit-transform: scale(".$val."); -moz-transform: scale(".$val."); -ms-transform: scale(".$val."); }";
		endif;

	if(get_theme_mod('lens_aboutme_img') == ''):
		echo "#aboutme .about{ width: 100%}";
		echo "#aboutme .about{ text-align:center; }";
		endif;


	echo "</style>";
}

add_action('wp_head', 'lens_custom_css_mods');