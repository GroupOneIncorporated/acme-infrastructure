<nav id="top-menu">
    <?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
</nav>

<div class="mobilemenu">
    <a href="#menu" class="menu-link">&#9776;</a>
    <nav id="menu" class="panel col title-font" role="navigation">
        <?php
        //Display the Mobile Menu.
        wp_nav_menu( array( 'theme_location' => 'primary',
            'menu-id'        => 'primary') ); ?>
    </nav><!-- #site-navigation -->
</div>