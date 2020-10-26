<?php 
$action_status = array('message' => '', 'status' => 'ok');
if ($action_status['message']!='') : ?>
        <div id="message" class="<?php echo ($action_status['status']=='ok' ? 'updated' : $action_status['status']); ?> fade">
            <p><strong><?php echo $action_status['message']; ?></strong></p>
        </div>
<?php endif; ?>
<div id='ngg_page_content'>
    <div id='nextgen_pro_upgrade_page' class="wrap about-wrap">
        <div class="ngg_page_content_header"><img src="<?php  echo(C_Router::get_instance()->get_static_url('photocrati-nextgen_admin#imagely_icon.png')); ?>"><h3><?php esc_html_e($i18n->plus_title); ?></h3>
        </div>

        <div class='ngg_page_content_main'>
            <p class="about-text">
                <?php esc_html_e($i18n->plus_desc_first); ?><br>
                <a href='https://www.imagely.com/wordpress-gallery-plugin/nextgen-pro/?utm_source=ngg&utm_medium=ngguser&utm_campaign=ngpro' target='_blank' class="button-primary"><?php esc_html_e($i18n->plus_button); ?></a><br>
                <span><?php esc_html_e($i18n->video); ?></span>
            </p>
            <div class="feature-section">
                <iframe src="https://www.youtube.com/embed/zmA-b_jiXN0" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>

    </div>
</div>
