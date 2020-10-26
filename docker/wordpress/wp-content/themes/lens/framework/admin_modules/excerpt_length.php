<?php
/**
 * Created by PhpStorm.
 * User: Gourav
 * Date: 2/7/2018
 * Time: 3:00 PM
 */

function lens_excerpt_more( $more ) {
    return '...';
}
add_filter('excerpt_more', 'lens_excerpt_more');