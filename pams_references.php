<?php
/*
  Plugin URI:
  Description:
  Version: 1.0.0
  Author: bjarkenielsen
  Author URI:
*/

/* 
Copyright (C) 2014 bjarkenielsen

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
*/

function pams_post_reference() {
    $labels = array(
        'name' => _x( 'References', 'post type general name' ),
        'singular_name' => _x( 'Reference', 'post type singular name' ),
        'add_new' => _x( 'Add New', 'reference' ),
        'add_new_item' => __( 'Add New Reference' ),
        'edit_item' => __( 'Edit Reference' ),
        'new_item' => __( 'New Reference' ),
        'all_items' => __( 'All References' ),
        'view_item' => __( 'View Reference' ),
        'search_items' => __( 'Search References' ),
        'not_found' => __( 'No references found' ),
        'not_found_in_trash' => __( 'No references found in the Trash' ),
        'parent_item' => 'Parent reference',
        'parent_item_colon' => 'Parent reference:',
        'menu_name' => 'References'
    );
    $args = array(
        'labels' => $labels,
        'description' => 'Holds our references to external sources',
        'public' => true,
        'menu_position' => 7,
        'hierarchical' => true,
        'supports' => array( 'title', 'editor', 'excerpt', 'page-attributes' ),
        'taxonomies' => array( 'post_tag' ),
        'has_archive' => true
    );
    register_post_type( 'reference', $args );
}

add_action( 'init', 'pams_post_reference' );