<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

wp_enqueue_script( 'pams-masonry', plugins_url( 'pams-lypdos/pams-masonry/js/masonry.pkgd.min.js' ), array( 'jquery' ) );
wp_enqueue_script( 'pams-masonry-script', plugins_url( 'pams-lypdos/pams-masonry/js/imagesloaded.pkgd.min.js' ) );
wp_enqueue_style( 'pams-masonry-custom', plugins_url( 'pams-lypdos/pams-masonry/css/masonry.css' ) );
wp_enqueue_script( 'pams-masonry-script', plugins_url( 'pams-lypdos/pams-masonry/js/masonry-script.js' ) );

function pams_show_images() {
    $query_images_args = array(
        'post_type' => 'attachment', 'post_mime_type' => 'image', 'post_status' => 'inherit', 'posts_per_page' => -1,
    );

    $query_images = new WP_Query( $query_images_args );

    $output = '';

    $output = '<div class="floating-image-wrapper">';
    foreach ( $query_images->posts as $image ) {
        $this_image = wp_get_attachment_image( $image->ID, 'floating_box_thumb' );
        $output .= '<div class="image-box">';
        $output .= '<a href="' . wp_get_attachment_url( $image->ID ) . '">' . $this_image . '</a>';
        $output .= '</div>';
    }
    $output .= '</div>';
    return $output;
}
