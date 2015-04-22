<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

wp_enqueue_style( 'pams-fotorama-custom', plugins_url( 'pams-lypdos/pams-fotorama/css/fotorama.css' ) );
wp_enqueue_script( 'pams-fotorama-script', plugins_url( 'pams-lypdos/pams-fotorama/js/fotorama.js', array( 'jquery' ) ) );

function pams_show_fotorama_images() {
    $query_images_args = array(
        'post_type' => 'attachment', 'post_mime_type' => 'image', 'post_status' => 'inherit', 'posts_per_page' => -1,
    );

    $query_images = new WP_Query( $query_images_args );

    $output = '';

    $output = '<div class="fotorama" data-width="860" data-nav="thumbs" data-allowfullscreen="true" data-autoplay="true">';
    foreach ( $query_images->posts as $image ) {
        //$this_image = wp_get_attachment_image( $image->ID, 'floating_box_thumb' );
        //$output .= '<div class="image-box">';
        $output .= '<img src="' . wp_get_attachment_url( $image->ID ) . '">';
        //$output .= '</div>';
    }
    $output .= '</div>';
    return $output;
}

/*
 * Uses fotorama.js plugin to display posts in a flow pattern.
 * Pams_Fotorama_Walker is used to retrieve the posts.
 * Post_type must be hierarchical to make Pams_Fotorama_Walker work.
 * The walker is not able to handle multiple post types.
 */
function pams_get_fotorama_box( $post_type = 'page', $id = '', $box_width = '100%', $box_height = '350px', $num_posts = 10) {
    $output = '';
    $sWalker = new Pams_Fotorama_Walker();
    $args = array(
        'sort_column' => 'post_name', 
        'sort_order' => 'ASC',
        'post_type' => $post_type,
        'post_status' => 'publish',
        'suppress_filters' => true,
        'walker' => $sWalker,
        'echo' => 0,
        'title_li' => null );
    
    if ( !$id ) {
        $children = wp_list_pages( $args );
        if ( $children ) {
            $output .= '<div class="fotorama" data-height="' . $box_height . '" data-arrows="false" data-width="' . $box_width . '" data-autoplay="true">';
            $output .= $children;
            $output .= '</div>';
        }
    } else {
        $children = wp_list_pages( array( 'post_type' => 'ctrl_doc', 'echo' => 0, 'title_li' => null, 'walker' => $sWalker, 'sort_column' => 'post_name', 'sort_order' => 'ASC', 'child_of' => $id ) );
        if ( $children ) {
            $output .= '<div class="fotorama" data-autoplay="true">';
            $output .= $children;
            $output .= '</div>';
        }
    }
    return $output;
}

class Pams_Fotorama_Walker extends Walker_page {

    function start_el( &$output, $page, $depth, $args, $current_page ) {
        $pams_excerpt = '';
        extract( $args, EXTR_SKIP );
        $pams_content .= apply_filters( 'the_content', get_post_field( 'post_content', $page->ID ) );
        //$pams_excerpt = get_the_service_excerpt( $page->ID );
        //$pams_excerpt = 'No preview';
        $output .= '<div><a href="' . get_permalink( $page->ID ) . '">' . apply_filters( 'the_title', $page->post_title, $page->ID ) . '</a>' . $pams_content . '</div>';
    }

}
