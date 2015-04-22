<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Pams_FloatingBox_Walker extends Walker_page {

    function start_el( &$output, $page, $depth, $args, $current_page ) {
//        if ( $depth )
//            $indent = str_repeat( "t", $depth );
//        else
//            $indent = '';
        $pams_excerpt = '';
        extract( $args, EXTR_SKIP );
        $pams_excerpt .= pams_get_excerpt_by_id( $page->ID );
        if ( empty( $pams_excerpt ) )
            $pams_excerpt = 'No preview';
        $output .= '<li><div class="floating-box"><a href="' . get_permalink( $page->ID ) . '" title="' . esc_attr( wp_strip_all_tags( apply_filters( 'the_title', $page->post_title, $page->ID ) ) ) . '">' . apply_filters( 'the_title', $page->post_title, $page->ID ) . '</a><div class="floating-box-element">' . $pams_excerpt . '</div></div>';
    }

}

/*
 * Builds a floating box post with data from "Recent" post information
 */

function pams_get_floating_box( $box_post, $must_have_img = false ) {
    $output = '';
    $pams_excerpt = pams_get_excerpt_by_id( $box_post[ "ID" ] );
    if ( empty( $pams_excerpt ) )
        $pams_excerpt = 'No preview';
    //get the thumbnail - if any
    if ( has_post_thumbnail( $box_post[ "ID" ] ) ) {
        $has_img = '1';
        $recent_image = get_the_post_thumbnail( $box_post[ "ID" ], array( 180, 120 ) );
    } else {
        $has_img = '0';
        $recent_image = '';
    }
    //$label = get_post_type_object( $recent[ "post_type" ] )->labels->singular_name;
    //$label_short = sprintf( '%3.3s', $label );
    $output .= '<div class="floating-box" data-holds_img="' . $has_img . '">';
    //print_r ($recent->ID);
    $output .= '<div class="floating-box-author">By:' . get_the_author_meta( 'display_name', get_post_field( 'post_author', $box_post[ "ID" ] ) ) . '</div>';
    if ( $has_img ) {
        $output .= '<div class="floating-box-image"><a href="' . get_permalink( $box_post[ "ID" ] ) . '" title="' . $box_post[ "post_title" ] . '">' . $recent_image . '</a></div>';
    }
    $output .= '<h3><a href="' . get_permalink( $box_post[ "ID" ] ) . '">' . ( __( $box_post[ "post_title" ] )) . '</a></h3>';
    $output .= '<div class="floating-box-excerpt" data-holds_img="' . $has_img . '">' . $pams_excerpt . '</div>';
    $output .= '</div>';
    return $output;
}

function pams_get_floating_boxes_recent( $num_posts = 8 ) {
    //$sWalker = new Pams_FloatingBox_Walker();
    $args = array(
        'numberposts' => $num_posts,
        'category' => 0,
        'orderby' => 'modified',
        'order' => 'DESC',
//            'include' => '',
//            'exclude' => '',
        //'post_type' => 'post',
        'post_type' => array( 'ctrl_doc', 'service', 'definition', 'post' ),
        'post_status' => 'publish',
        'suppress_filters' => true );

    $output .= '<div class="floating-box-wrapper">';
    //$output = '<ul>';
    $recent_image = '';
    $recent_posts = wp_get_recent_posts( $args );
    //Find the posts with thumbnails first to improve presentation.
    foreach ( $recent_posts as $recent ) {
        $output .= pams_get_floating_box( $recent, true );
    }

    //Now fint the posts without thumbnails
//    foreach ( $recent_posts as $recent ) {
//        $output .= pams_get_floating_box( $recent, false );
//    }
    //$output .= '</ul>';
    $output .= '</div>';
    return $output;
}

add_action( 'after_setup_theme', 'pams_theme_setup' );

function pams_theme_setup() {
    update_option( 'thumbnail_size_w', 180 );
    update_option( 'thumbnail_size_h', 120 );
    update_option( 'thumbnail_crop', 1 );
    add_image_size( 'floating_box_thumb', 180, 120, true );
}
