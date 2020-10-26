<?php
/**
 * @package Lens
 */
?>
				
<article id="post-<?php the_ID(); ?>" <?php post_class('col-md-3 col-sm-6 grid photography'); ?>>
	<div class="card">
		<div class="featured-thumb front">
			<?php if (has_post_thumbnail()) : ?>	
				<a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_post_thumbnail('photo-thumb',array(  'alt' => trim(strip_tags( $post->post_title )))); ?></a>
			<?php else: ?>
				<a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><img alt="<?php the_title() ?>" src="<?php echo get_template_directory_uri()."/assets/images/placeholder2.jpg"; ?>"></a>
			<?php endif; ?>
			
			<div class="out-thumb back">
					<header class="entry-header">
						<h3 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
					</header><!-- .entry-header -->
				</div><!--.out-thumb-->
			</div>	
			
		</div><!--.featured-thumb-->
		
		
		
</article><!-- #post-## -->