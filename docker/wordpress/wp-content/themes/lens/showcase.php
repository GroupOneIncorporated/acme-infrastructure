<?php if ( get_theme_mod('lens_main_showcase_enable') && is_front_page() ) : ?>
	<div id="showcase">
	<div class="container">
	<?php if ( get_theme_mod('lens_main_showcase_title')) : ?>
		<div id="showcase-title" class="section-title"><?php echo esc_html( get_theme_mod('lens_main_showcase_title','My Featured Works') ); ?></div>
		<?php endif; ?>
		<?php
		  		for ( $i = 1 ; $i <=3 ; $i++ ) {
						echo "<div class='col-md-4 col-sm-4 col-xs-12 showcase'><figure class='a'><div><a href='".esc_url(get_theme_mod('lens_showcase_url'.$i))."'><img src='".esc_url( get_theme_mod('lens_showcase_img'.$i) )."'><div class='showcase-caption'><div class='showcase-caption-title'>".esc_html( get_theme_mod('lens_showcase_title'.$i) )."</div><div class='showcase-caption-desc'>".esc_html( get_theme_mod('lens_showcase_desc'.$i) )."</div></div></a></div></figure></div>";
				
				}
	       ?>
	 </div>   
	</div><!--.showcase-->
<?php endif; ?> 