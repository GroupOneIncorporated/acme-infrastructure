<?php
/**
 * @package lens
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header title-font lens-single-entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>			
		<div class="entry-meta">
			<?php lens_posted_on(); ?>				
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->
	
	<div id="featured-image">
			<?php the_post_thumbnail('full'); ?>
		</div>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'lens' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php lens_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
