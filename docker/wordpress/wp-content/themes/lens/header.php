<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package lens
 */
?>

<?php get_template_part('modules/header/head'); ?>


<body <?php body_class(); ?>>

<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'lens' ); ?></a>

	<?php get_template_part('modules/header/jumbosearch'); ?>
	<?php get_template_part('modules/header/top-bar'); ?>
	<?php get_template_part('modules/header/masthead'); ?>
	<?php get_template_part('slider', 'nivo'); ?>
	<?php get_template_part('showcase'); ?>
	<?php get_template_part('aboutme'); ?>
	
	<div class="mega-container" >
			
		<div id="content" class="site-content container">