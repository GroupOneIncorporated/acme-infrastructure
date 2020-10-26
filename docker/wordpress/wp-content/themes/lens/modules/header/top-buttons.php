<div id="top-buttons">
    <?php if ( get_theme_mod('lens_btn_title1') ) : ?>
        <a href="<?php echo esc_url( get_theme_mod('lens_btn_url1') ); ?>"><button><i class="fa fa-<?php echo esc_html(get_theme_mod('lens_btn_icon1')); ?>"></i><?php echo esc_html( get_theme_mod('lens_btn_title1') ); ?></button></a>
    <?php endif; ?>
    <?php if ( get_theme_mod('lens_btn_title2') ) : ?>
        <a href="<?php echo esc_url( get_theme_mod('lens_btn_url2') ); ?>"><button><i class="fa fa-<?php echo esc_html(get_theme_mod('lens_btn_icon2')); ?>"></i><?php echo esc_html( get_theme_mod('lens_btn_title2') ); ?></button></a>
    <?php endif; ?>
</div>
