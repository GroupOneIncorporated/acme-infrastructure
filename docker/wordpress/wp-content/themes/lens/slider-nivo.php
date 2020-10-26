<?php
/* The Template to Render the Slider
*
*/

//Define all Variables.
if ( get_theme_mod('lens_main_slider_enable' ) && is_home() ) : 

	$count_x = $count = get_theme_mod('lens_main_slider_count');

		
		?>
			<div class="container">
				<div class="slider-wrapper theme-default">
			            <div id="nivoSlider" class="nivoSlider">
			            <?php
			            for ( $i = 1; $i <= $count; $i++ ) :
	
							$url = esc_url ( get_theme_mod('lens_slide_url'.$i) );
							$img = esc_url ( get_theme_mod('lens_slide_img'.$i) );
							 
							
							?>
							
				            <a href="<?php echo $url; ?>"><img src="<?php echo $img ?>" data-thumb="<?php echo $img ?>" title="#caption_<?php echo $i ?>" /></a>
				            
			             <?php endfor; ?>
			               
			            </div>
			            
			            <?php
			            for ( $i = 1; $i <= $count_x; $i++ ) :
	
							$title = esc_html( get_theme_mod('lens_slide_title'.$i) );
							$desc = esc_html( get_theme_mod('lens_slide_desc'.$i) );
							$url = esc_url ( get_theme_mod('lens_slide_url'.$i) );
							
							
							
							?>
							
				            <div id="caption_<?php echo $i ?>" class="nivo-html-caption slidecaption">
				                <a href="<?php echo $url ?>">
				                <?php if ($title) : ?>
					                <div class="slide-title title-font"><?php echo $title ?></div>
					                <div class="slide-desc"><span><?php echo $desc ?></span></div>
					               <?php endif; ?> 
				            </div>
			            <?php
			             endfor; ?>
			            
			        </div>
			</div> 
	<?php	
	
endif;	?>	   