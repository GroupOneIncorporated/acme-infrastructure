<header id="masthead" class="site-header" role="banner" data-stellar-background-ratio="0.5">
    <div class="layer">
        <div class="container">
            <div class="site-branding">
                <?php if ( get_theme_mod('lens_logo') != "" ) : ?>
                    <div id="site-logo">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img alt="<?php echo get_bloginfo() ?>" src="<?php echo esc_url( get_theme_mod('lens_logo') ); ?>"></a>
                    </div>
                <?php endif; ?>
                <div id="text-title-desc">
                    <h1 class="site-title title-font"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                    <h2 class="site-description title-font"><?php bloginfo( 'description' ); ?></h2>
                </div>
                <div class="social-icons">
                    <?php get_template_part('modules/social/social', 'sociocon'); ?>
                </div>

            </div>

        </div>




    </div>
</header><!-- #masthead -->
