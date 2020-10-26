<?php
/*
 * The Footer Widget Area
 * @package lens
 */
 ?>
 </div><!--.mega-container-->
 <?php if ( is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') || is_active_sidebar('footer-4') ) : ?>
	 <div id="footer-sidebar" class="widget-area">
	 	<div class="container">
		 	<?php 
				if ( is_active_sidebar( 'footer-1' ) ) : ?>
					<div class="footer-column col-md-3 col-sm-6"> 
						<?php dynamic_sidebar( 'footer-1'); ?> 
					</div> 
				<?php endif;
					
				if ( is_active_sidebar( 'footer-2' ) ) : ?>
					<div class="footer-column col-md-3 col-sm-6"> 
						<?php dynamic_sidebar( 'footer-2'); ?> 
					</div> 
				<?php endif;
		
				if ( is_active_sidebar( 'footer-3' ) ) : ?>
					<div class="footer-column col-md-3 col-sm-6"> <?php
						dynamic_sidebar( 'footer-3'); ?> 
					</div>
				<?php endif; 
				
				if ( is_active_sidebar( 'footer-4' ) ) : ?>
					<div class="footer-column col-md-3 col-sm-6"> <?php
						dynamic_sidebar( 'footer-4'); ?> 
					</div>
				<?php endif; ?>
				
	 	</div>
	 </div>	<!--#footer-sidebar-->	
<?php endif; ?>