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

/**
 * Add custom taxonomies
 *
 * Additional custom taxonomies can be defined here
 * http://codex.wordpress.org/Function_Reference/register_taxonomy
 */
//include_once( plugin_dir_path( __file__) .'options/pams_options_arr.php');
include_once( 'pams_widgets.php' );

function add_custom_taxonomies() {
// Add new "DocTypes" taxonomy to Posts
    register_taxonomy( 'doctype', 'post', array(
// Hierarchical taxonomy (like categories)
        'hierarchical' => true,
        // This array of options controls the labels displayed in the WordPress Admin UI
        'labels' => array(
            'name' => _x( 'DocTypes', 'taxonomy general name' ),
            'singular_name' => _x( 'DocType', 'taxonomy singular name' ),
            'search_items' => __( 'Search DocTypes' ),
            'all_items' => __( 'All DocTypes' ),
            'parent_item' => __( 'Parent DocType' ),
            'parent_item_colon' => __( 'Parent DocType:' ),
            'edit_item' => __( 'Edit DocType' ),
            'update_item' => __( 'Update DocType' ),
            'add_new_item' => __( 'Add New DocType' ),
            'new_item_name' => __( 'New DocType Name' ),
            'menu_name' => __( 'DocTypes' ),
        ),
        // Control the slugs used for this taxonomy
        'rewrite' => array(
            'slug' => 'doctypes', // This controls the base slug that will display before each term
            'with_front' => false, // Don't display the category base before "/locations/"
            'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
        ),
    ) );
// Add new "TargetGroups" taxonomy to Posts
    register_taxonomy( 'targetgroup', 'post', array(
// Hierarchical taxonomy (like categories)
        'hierarchical' => true,
        // This array of options controls the labels displayed in the WordPress Admin UI
        'labels' => array(
            'name' => _x( 'TargetGroups', 'taxonomy general name' ),
            'singular_name' => _x( 'TargetGroup', 'taxonomy singular name' ),
            'search_items' => __( 'Search TargetGroups' ),
            'all_items' => __( 'All TargetGroups' ),
            'parent_item' => __( 'Parent TargetGroup' ),
            'parent_item_colon' => __( 'Parent TargetGroup:' ),
            'edit_item' => __( 'Edit TargetGroup' ),
            'update_item' => __( 'Update TargetGroup' ),
            'add_new_item' => __( 'Add New TargetGroup' ),
            'new_item_name' => __( 'New TargetGroup Name' ),
            'menu_name' => __( 'TargetGroups' ),
        ),
        // Control the slugs used for this taxonomy
        'rewrite' => array(
            'slug' => 'targetgroups', // This controls the base slug that will display before each term
            'with_front' => false, // Don't display the category base before "/locations/"
            'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
        ),
    ) );

    // Add new "TargetGroups" taxonomy to Posts
    register_taxonomy( 'businessunit', 'post', array(
// Hierarchical taxonomy (like categories)
        'hierarchical' => true,
        // This array of options controls the labels displayed in the WordPress Admin UI
        'labels' => array(
            'name' => _x( 'BusinessUnits', 'taxonomy general name' ),
            'singular_name' => _x( 'BusinessUnit', 'taxonomy singular name' ),
            'search_items' => __( 'Search BusinessUnits' ),
            'all_items' => __( 'All BusinessUnits' ),
            'parent_item' => __( 'Parent BusinessUnit' ),
            'parent_item_colon' => __( 'Parent BusinessUnit:' ),
            'edit_item' => __( 'Edit BusinessUnit' ),
            'update_item' => __( 'Update BusinessUnit' ),
            'add_new_item' => __( 'Add New BusinessUnit' ),
            'new_item_name' => __( 'New BusinessUnit Name' ),
            'menu_name' => __( 'BusinessUnits' ),
        ),
        // Control the slugs used for this taxonomy
        'rewrite' => array(
            'slug' => 'businessunits', // This controls the base slug that will display before each term
            'with_front' => false, // Don't display the category base before "/locations/"
            'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
        ),
    ) );

    register_taxonomy( 'country', 'post', array(
// Hierarchical taxonomy (like categories)
        'hierarchical' => false,
        // This array of options controls the labels displayed in the WordPress Admin UI
        'labels' => array(
            'name' => _x( 'Countries', 'taxonomy general name' ),
            'singular_name' => _x( 'Country', 'taxonomy singular name' ),
            'search_items' => __( 'Search Countries' ),
            'all_items' => __( 'All Countries' ),
            'parent_item' => __( 'Parent Country' ),
            'parent_item_colon' => __( 'Parent Country:' ),
            'edit_item' => __( 'Edit Country' ),
            'update_item' => __( 'Update Country' ),
            'add_new_item' => __( 'Add New Country' ),
            'new_item_name' => __( 'New Country Name' ),
            'menu_name' => __( 'Countries' ),
        ),
        // Control the slugs used for this taxonomy
        'rewrite' => array(
            'slug' => 'countries', // This controls the base slug that will display before each term
            'with_front' => false, // Don't display the category base before "/locations/"
            'hierarchical' => false // This will allow URL's like "/locations/boston/cambridge/"
        ),
    ) );
}

add_action( 'init', 'add_custom_taxonomies', 0 );

function bn_infobox_func( $atts, $content = 'Definition text' ) {

    extract( shortcode_atts( array( 'title' => 'default title' ), $atts ) );

    $content = "<div class='infobox'><div class='infoboxheader'>$title</div>
<div class='infoboxbody'>$content</div></div>";
    return do_shortcode( $content );
}

// end function hello_world()

add_shortcode( 'bn_infobox', 'bn_infobox_func' );

function bn_definitionbox_func( $atts ) {

    extract( shortcode_atts( array(
        'title' => 'See definitions',
        'ids' => '' ), $atts ) );
    //$ids = $atts['ids'];
    $id_list = explode( ',', $ids );
    if ( !$ids ) {
        echo 'Did not find DEFINITION POST';
        return NULL;
    } else {
        if ( is_array( $id_list ) ) {
            foreach ( $id_list as $id ) {
                $bn_title[] = '<a href="' . get_permalink( $id ) . '">' . get_post( $id )->post_title . '</a>';
            }
        } else {
            $bn_title = '<a href="' . get_permalink( $ids ) . '">' . get_post( $ids )->post_title . '</a>';
            //$post_content = get_post( $id )->post_excerpt;
        }
    }

    //echo $post_content;
    //$content = '<p style="font-size: 0.7em" See definition</p>';
    if ( is_array( $bn_title ) ) {
        $content = '<div class="definitionbox"><p style="font-size: 0.9em; padding: 0px 0px 0px 5px; margin-bottom:0px">' . $title . '</p>';
        $content .= '<div class="definitionboxheader">';
        $content .= '<ul class="sidebar-list" style="margin-bottom: 0px;">';
        foreach ( $bn_title as $t ) {
            $content .= '<li style="font-size: 0.9em; line-height: 1.5em">' . $t . '</li>';
        }
        $content .= '</ul>';
        $content .= '</div>';
        $content .= '</div>';
    } else
        $content = '<div class="definitionbox"><p style="font-size: 0.8em; padding: 0px 0px 0px 5px; margin:0px">' . $title . '</p><div class="definitionboxheader">' . $bn_title . '</div></div>';
    //$content .= '<div style="clear: right;"></div>';
    //$content .= '<div class="definitionboxbody">' . $post_content . '</div></div>';
    return do_shortcode( $content );
}

add_shortcode( 'bn_definitionbox', 'bn_definitionbox_func' );

/*
  <!-- BN Custom target groups START -->
 */

/**
 * Retrieve the tags for a post.
 *
 * @since 2.3.0
 * @uses apply_filters() Calls 'get_the_tags' filter on the list of post tags.
 *
 * @param int $id Post ID.
 * @return array|bool Array of tag objects on success, false on failure.
 */
function get_the_targetgroups( $id = 0 ) {
    return apply_filters( 'get_the_targetgroups', get_the_terms( $id, 'targetgroup' ) );
}

/**
 * Retrieve the tags for a post formatted as a string.
 *
 * @since 2.3.0
 * @uses apply_filters() Calls 'the_tags' filter on string list of tags.
 *
 * @param string $before Optional. Before tags.
 * @param string $sep Optional. Between tags.
 * @param string $after Optional. After tags.
 * @param int $id Optional. Post ID. Defaults to the current post.
 * @return string|bool|WP_Error A list of tags on success, false or WP_Error on failure.
 */
function get_the_targetgroup_list( $before = '', $sep = '', $after = '', $id = 0 ) {
    return apply_filters( 'the_targetgroups', get_the_term_list( $id, 'targetgroup', $before, $sep, $after ), $before, $sep, $after, $id );
}

/**
 * Retrieve the tags for a post.
 *
 * @since 2.3.0
 *
 * @param string $before Optional. Before list.
 * @param string $sep Optional. Separate items using this.
 * @param string $after Optional. After list.
 */
function the_targetgroups( $before = null, $sep = ', ', $after = '', $id = 0 ) {
    if ( null === $before )
        $before = __( 'Target groups: ' );
    echo get_the_targetgroup_list( $before, $sep, $after, $id );
}

function bn_targetgroup_list_func( $atts, $content = NULL ) {
    extract( shortcode_atts( array( 'title' => 'Target groups' ), $atts ) );
    extract( shortcode_atts( array( 'taxonomy' => 'targetgroup' ), $atts ) );
    extract( shortcode_atts( array( 'width' => '250px' ), $atts ) );
    extract( shortcode_atts( array( 'height' => '300px' ), $atts ) );
    //echo $taxonomy;
    $terms = get_terms( $taxonomy );
    $ret = '';
    if ( !empty( $terms ) && !is_wp_error( $terms ) ) {
        $ret = ( '<div class = "taxonomy_list" style="width: ' . $width . '; height: ' . $height . '">' );
        $ret .= '<b><span style="font-size:1.2em">' . $title . '</span></b><br>';
        if ( $content )
            $ret .= '<p style="font-size:0.9em">' . $content . '</p>';
        $ret .= "<ul>";
        foreach ( $terms as $term ) {
            $ret .= ( '<li>' );
            $ret .= ( '<a href="' . get_term_link( $term ) . '" title="' . $term->name . '">' . $term->name . '</a>' );
            $ret .= ( '</li>' );
        }
        $ret .= "</ul></div>";
    }
    return $ret;
}

add_shortcode( 'bn_targetgroup_list', 'bn_targetgroup_list_func' );
/* <!-- BN Custom related posts START --> */

function the_related_posts( $before = null, $sep1 = ´´, $sep2 = ', ', $after = '', $post = NULL ) {
    $orig_post = $post;
    global $post;
    $tags = wp_get_post_tags( $post->ID );

    if ( $tags ) {
        $tag_ids = array();
        foreach ( $tags as $individual_tag )
            $tag_ids[] = $individual_tag->term_id;
        $args = array(
            'tag__in' => $tag_ids,
            'post__not_in' => array( $post->ID ),
            'post_type' => array( 'post', 'service', 'definition', 'ctrl_doc' ),
            'posts_per_page' => 15, // Number of related posts to display.
            'ignore_sticky_posts' => 1,
            'orderby' => 'name'
        );

        $my_query = new wp_query( $args );
//                <!--  <ul id="side_nav_children"> -->
        if ( $before )
            echo $before;
        while ( $my_query->have_posts() ) {
            $my_query->the_post();
            echo $sep1;
            ?><a rel="external" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
            <?php
            echo $sep2;
        } echo $after;
    }
//                  $post = $orig_post;
//                  wp_reset_query();
    $post = $orig_post;
    wp_reset_query();
}

/* <!-- BN Custom related posts END--> */

//function get_document_categories_list($before = null, $sep = '', $after = '', $id) {
//    if (null === $before)
//        $before = __('Document categories: ');
//    $out = $before;
//    $out .= wp_list_categories('orderby=name&title_li=');
//    $out .= $after;
//}

function the_doc_objective( $id ) {
    $fld = get_field( 'doc_objective', $id );
    if ( $fld ) {
        echo ( '<div class = "doc_objective_box"><p>' );
        echo ( '<b>Objective: </b>' . $fld );
        echo ( '</div>' );
    }
}

function the_doc_principle( $id ) {
    $fld = get_field( 'doc_principle', $id );
    if ( $fld ) {
        echo ( '<div class = "doc_objective_box"><p>' );
        echo ( '<b>Principle: </b>' . $fld );
        echo ( '</div>' );
    }
}

function the_doc_obj_and_prcpl( $id ) {
    $fld_obj = get_field( 'doc_objective', $id );
    $fld_prcpl = get_field( 'doc_principle', $id );
    if ( $fld_obj ) {
        echo ( '<div class = "doc_objective_box"><p>' );
        echo ( '<b>Objective: </b>' . $fld_obj );
        if ( !$fld_prcpl ) {
            echo ( '</p></div>' );
            //echo ( '<div class="clear"></div>' );
        } else
            echo ( '</p>');
    }

    if ( $fld_prcpl ) {
        if ( !$fld_obj ) {
            echo ( '<div class = "doc_objective_box"><p>' );
        } else
            echo ( '<p>');
        echo ( '<b>Principle: </b>' . $fld_prcpl );
        echo ( '</div>' );
    }

    if ( ($fld_obj) && ($fld_prcpl) ) {
        echo ( '<div class="clear25"></div>' );
    }
}

function has_obj_prncpl( $id ) {
    if ( $do = get_field( 'doc_objective', $id ) || $dp = get_field( 'doc_principle', $id ) ) {
        $ret_val = TRUE;
    } else
        $ret_val = FALSE;
    return $ret_val;
}

function bn_show_posts_list_func( $atts = NULL, $content = 'Definition text' ) {
    extract( shortcode_atts( array( 'title' => 'default title' ), $atts ) );
    $args = array(
        'post_type' => 'post',
        'tax_query' => array(
            array(
                'taxonomy' => 'targetgroup',
                'field' => 'slug',
                'terms' => 'any'
            )
        )
    );
    $custom_query = new WP_Query( $args );
    while ( $custom_query->have_posts() ) : $custom_query->the_post();
        ?>
        <div <?php post_class(); ?>>
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <?php the_doc_meta_table( the_ID() ) ?>
        </div>

        <?php
        if ( has_obj_prncpl( the_ID() ) )
            echo the_bn_post_excerpt( the_ID() );
    endwhile;
    wp_reset_postdata(); // reset the query
}

add_shortcode( 'bn_show_posts_list', 'bn_show_posts_list_func' );

function the_bn_post_excerpt( $id ) {
    $fld_obj = get_field( 'doc_objective', $id );
    $fld_prcpl = get_field( 'doc_principle', $id );
    if ( $fld_obj ) {
        echo ( '<p class = "doc_objective_excerpt">' );
        echo ( '<b>Objective: </b>' . $fld_obj );
        echo ( '</p>');
    }
    if ( $fld_prcpl ) {
        echo ( '<p class = "doc_objective_excerpt">');
        echo ( '<b>Principle: </b>' . $fld_prcpl );
        echo ( '</p>' );
    }
    return NULL;
}

function pams_get_ctrl_doc_excerpt( $id ) {
    $fld_obj = get_field( 'doc_objective', $id );
    $fld_prcpl = get_field( 'doc_principle', $id );
    $output = '';
    if ( $fld_obj ) {
        $output .= ( '<p class = "doc_objective_excerpt">' );
        $output .= ( '<b>Objective: </b>' . $fld_obj );
        $output .= ( '</p>');
    }
    if ( $fld_prcpl ) {
        $output .= ( '<p class = "doc_objective_excerpt">');
        $output .= ( '<b>Principle: </b>' . $fld_prcpl );
        $output .= ( '</p>' );
    }
    return $output;
}

function pams_get_ctrl_doc_excerpt_box( $id ) {
    $ttle = get_the_title( $id );
    $fld_obj = get_field( 'doc_objective', $id );
    $fld_prcpl = get_field( 'doc_principle', $id );
    $output = '<div class="excerpt_box"><div class="excerpt_text">';
    $output .= '<h3>' . $ttle . '</h3>';
    if ( $fld_obj ) {
        $output .= ( '<p class = "doc_objective_excerpt">' );
        $output .= ( '<b>Objective: </b>' . $fld_obj );
        $output .= ( '</p>');
    }
    if ( $fld_prcpl ) {
        $output .= ( '<p class = "doc_objective_excerpt">');
        $output .= ( '<b>Principle: </b>' . $fld_prcpl );
        $output .= ( '</p>' );
    }
    $output .= pams_get_excerpt_by_id( $id );
    //$output .= apply_filters( 'the_excerpt', get_post_field( 'post_excerpt', $id ) );
    $output .= '</div></div>';
    return $output;
}

function get_the_date_bar( $id ) {
    $output = '';
    $output .= '<div id="doc_meta_wrap">';
    $output .= ( 'Published: ' );
    $output .= get_the_time( get_option( 'date_format' ) );
    $output .= (' | ');
    if ( $last_id = get_post_meta( $id, '_edit_last', true ) ) {
        $last_user = get_userdata( $last_id );
        $output .= sprintf( __( 'Last edited by: %1$s on %2$s at %3$s' ), esc_html( strtoupper( $last_user->display_name ) ), mysql2date( get_option( 'date_format' ), get_post( $id )->post_modified ), mysql2date( get_option( 'time_format' ), get_post( $id )->post_modified ) );
    }
    $output .= ' | ';
    $rev_interval = get_post_meta( $id, 'review_interval', true );
    if ( !$rev_interval )
        $rev_interval = '1 year';
    date_sub( $rev_deadline, date_interval_create_from_date_string( $rev_interval ) );
    $doc_date = new DateTime( get_the_modified_date() );
    //$output .= 'Date: ' . get_the_modified_date();
    //   $output .= $doc_date->format('Y-m-d');
    $next_edit = new DateTime( $doc_date->format( 'Y-m-d' ) );
    $today = new DateTime( 'now' );
    date_add( $next_edit, date_interval_create_from_date_string( $rev_interval ) );
    $date_age = $today->diff( $next_edit );
    if ( $next_edit < $today )
        $output .= '<span style="color:#F00">' . 'Revision overdue: ' . $date_age->format( '%R%a days' ) . '</span>';
    else
        $output .= $date_age->format( 'Next revision in %R%a days' );
    $output .= '</div>';
    return $output;
}

function bn_sidebar_drilldown_search( $atts = NULL, $content = '' ) {
    extract( shortcode_atts( array( 'mode' => 'checkboxes' ), $atts ) );
    $args = array( 'mode' => $mode, 'taxonomies' => array(
            'category', 'doctype', 'targetgroup', 'businessunit', 'country', 'service_type' ) );
    echo ( '<div class = "sidebar_widget sidebar sidebar_editable widget widget_search">' );
    #sidebar > div.sidebar_widget.sidebar.sidebar_editable.widget.widget_search
    the_widget( 'Taxonomy_Drill_Down_Widget', $args );
    echo ('</div>');
}

function bn_drilldown_search_func( $atts = NULL, $content = '' ) {
    extract( shortcode_atts( array( 'mode' => 'checkboxes' ), $atts ) );
    $args = array( 'mode' => $mode, 'taxonomies' => array(
            'category', 'doctype', 'targetgroup', 'businessunit', 'country', 'service_type' ) );
    echo ( '<div class = "drilldown_box">' );
    the_widget( 'Taxonomy_Drill_Down_Widget', $args );
    echo ('</div>');
}

add_shortcode( 'drilldown_search', 'bn_drilldown_search_func' );

/* //function pams_search_filter( $query ) {
  //    if ( !is_admin() && $query->is_main_query() ) {
  //        if ( $query->is_search ) {
  //            $meta_args = array(
  //                'relation' => 'OR',
  //                array(
  //                    'key' => 'doc_objective',
  //                    'value' => $query->query_vars['s'],
  //                    'compare' => 'LIKE',
  //                ),
  //                array(
  //                    'key' => 'doc_principle',
  //                    'value' => $query->query_vars['s'],
  //                    'compare' => 'LIKE',
  //                ),
  //            );
  //            echo ($query->query_vars['s']);
  //            $query->set( 'post_type', 'post' ); //array( 'post', 'definition' ) );
  //            $query->set( 'meta_query', $meta_args );
  //        }
  //    }
  //}
  //
  ////add_action( 'pre_get_posts', 'pams_search_filter' );
  // */

/* function search( $where ) {
  if ( is_search() ) {
  global $wpdb, $wp;
  $where = preg_replace("/(wp_posts.post_title (LIKE '%{$wp->query_vars['s']}%’))/i”,
  “$0 OR ($wpdb->postmeta.meta_key = ‘_wpsc_sku’ AND $wpdb->postmeta.meta_value $1)”,
  $where
  );
  add_filter( 'posts_distinct_request ’, ‘search_distinct’);
  add_filter( ‘posts_join_request ’, ‘search_join’);
  }
  return $where;
  }

  function search_join( $join ) {
  global $wpdb;
  return $join .= ” LEFT JOIN $wpdb->postmeta ON ($wpdb->posts.ID = $wpdb->postmeta.post_id) “;
  }

  add_action( ‘posts_where_request ’, ‘search’);

  function search_distinct( $distinct ) {
  $distinct = “DISTINCT”;
  return $distinct;
  } */

/* class MySearchClass {
  function MySearchClass()
  {
  add_action('posts_where_request', array(&$this, 'search'));
  }
  function search($where)
  {
  if (is_search()) {
  global $wpdb, $wp;
  $where = preg_replace(
  "/(wp_posts.post_title (LIKE '%{$wp->query_vars['s']}%'))/i",
  "$0 OR ($wpdb->postmeta.meta_key = '_{$this->tag}' AND $wpdb->postmeta.meta_value $1)",
  $where
  );
  add_filter('posts_join_request', array(&$this, 'search_join'));
  }
  return $where;
  }
  function search_join($join)
  {
  global $wpdb;
  return $join .= " LEFT JOIN $wpdb->postmeta ON ($wpdb->posts.ID = $wpdb->postmeta.post_id) ";
  }
  } */

function has_references( $id ) {
    return ( FALSE != get_field( 'external_references', $id ) );
}

function the_ext_references_box( $id ) {
    $pst = get_post( $id );
    $retval = FALSE;
    if ( $pst ) {
        $retval = TRUE;
        $fld = get_field( 'external_references', $pst->ID );
        if ( $fld ) {
            echo ('<div class="sub_services_full_box">');
            echo ( $fld );
            echo ('</div>');
        } else
            $retval = FALSE;
    }
}

function any_ptype_on_tag( $request ) {
    if ( isset( $request[ 'tag' ] ) )
        $request[ 'post_type' ] = 'any';

    return $request;
}

add_filter( 'request', 'any_ptype_on_tag' );

function any_ptype_on_cate( $request ) {
    if ( isset( $request[ 'cat' ] ) )
        $request[ 'post_type' ] = 'any';

    return $request;
}

add_filter( 'request', 'any_ptype_on_cate' );

/* if ( function_exists( "register_field_group" ) ) {
  register_field_group( array(
  'id' => 'acf_document',
  'title' => 'Document',
  'fields' => array(
  array(
  'key' => 'field_5354c5df3bfad',
  'label' => 'Document Accountable',
  'name' => 'document_accountable',
  'type' => 'textarea',
  'instructions' => 'Document must have a document owner assigned',
  'required' => 1,
  'default_value' => 'not assigned',
  'placeholder' => '',
  'maxlength' => '',
  'rows' => 1,
  'formatting' => 'none',
  ),
  array(
  'key' => 'field_5369e55361ed5',
  'label' => 'Document Responsible',
  'name' => 'document_responsible',
  'type' => 'textarea',
  'instructions' => 'Document must have a document responsible assigned.',
  'required' => 1,
  'default_value' => 'not assigned',
  'placeholder' => '',
  'maxlength' => '',
  'rows' => 1,
  'formatting' => 'none',
  ),
  array(
  'key' => 'field_5358fe0324187',
  'label' => 'doc_objective',
  'name' => 'doc_objective',
  'type' => 'textarea',
  'default_value' => '',
  'placeholder' => '',
  'maxlength' => '',
  'rows' => '',
  'formatting' => 'br',
  ),
  array(
  'key' => 'field_535906ba21067',
  'label' => 'doc_principle',
  'name' => 'doc_principle',
  'type' => 'textarea',
  'default_value' => '',
  'placeholder' => '',
  'maxlength' => '',
  'rows' => '',
  'formatting' => 'br',
  ),
  ),
  'location' => array(
  array(
  array(
  'param' => 'post_type',
  'operator' => '==',
  'value' => 'post',
  'order_no' => 0,
  'group_no' => 0,
  ),
  ),
  array(
  array(
  'param' => 'post_type',
  'operator' => '==',
  'value' => 'ctrl_doc',
  'order_no' => 0,
  'group_no' => 1,
  ),
  ),
  array(
  array(
  'param' => 'post_type',
  'operator' => '==',
  'value' => 'definition',
  'order_no' => 0,
  'group_no' => 2,
  ),
  ),
  ),
  'options' => array(
  'position' => 'acf_after_title',
  'layout' => 'default',
  'hide_on_screen' => array(
  ),
  ),
  'menu_order' => 0,
  ) );
  register_field_group( array(
  'id' => 'acf_external-links',
  'title' => 'External links',
  'fields' => array(
  array(
  'key' => 'field_5369f8876a92c',
  'label' => 'External references',
  'name' => 'external_references',
  'type' => 'textarea',
  'default_value' => '',
  'placeholder' => '',
  'maxlength' => '',
  'rows' => 3,
  'formatting' => 'br',
  ),
  ),
  'location' => array(
  array(
  array(
  'param' => 'post_type',
  'operator' => '==',
  'value' => 'post',
  'order_no' => 0,
  'group_no' => 0,
  ),
  ),
  array(
  array(
  'param' => 'post_type',
  'operator' => '==',
  'value' => 'definition',
  'order_no' => 0,
  'group_no' => 1,
  ),
  ),
  array(
  array(
  'param' => 'post_type',
  'operator' => '==',
  'value' => 'ctrl_doc',
  'order_no' => 0,
  'group_no' => 2,
  ),
  ),
  ),
  'options' => array(
  'position' => 'normal',
  'layout' => 'no_box',
  'hide_on_screen' => array(
  ),
  ),
  'menu_order' => 0,
  ) );
  register_field_group( array(
  'id' => 'acf_services',
  'title' => 'Services',
  'fields' => array(
  array(
  'key' => 'field_53660818ccd4b',
  'label' => 'Supporting services',
  'name' => 'supporting_services',
  'type' => 'relationship',
  'return_format' => 'object',
  'post_type' => array(
  0 => 'service',
  ),
  'taxonomy' => array(
  0 => 'service_type:55',
  1 => 'service_type:57',
  2 => 'service_type:56',
  ),
  'filters' => array(
  0 => 'search',
  1 => 'post_type',
  ),
  'result_elements' => array(
  0 => 'post_type',
  1 => 'post_title',
  ),
  'max' => '',
  ),
  array(
  'key' => 'field_536610168f828',
  'label' => 'Service owner',
  'name' => 'service_owner',
  'type' => 'text',
  'required' => 1,
  'default_value' => 'NoName',
  'placeholder' => '',
  'prepend' => '',
  'append' => '',
  'formatting' => 'none',
  'maxlength' => '',
  ),
  array(
  'key' => 'field_5366107f8f82a',
  'label' => 'Technical responsible',
  'name' => 'technical_responsible',
  'type' => 'text',
  'required' => 1,
  'default_value' => 'NoName',
  'placeholder' => '',
  'prepend' => '',
  'append' => '',
  'formatting' => 'none',
  'maxlength' => '',
  ),
  array(
  'key' => 'field_5367969a749ae',
  'label' => 'Lifecycle stage',
  'name' => 'lifecycle_stage',
  'type' => 'select',
  'instructions' => 'Select lifecycle stage',
  'required' => 1,
  'choices' => array(
  'Defining requirements' => 'Defining requirements',
  'Requirements approved' => 'Requirements approved',
  'Chartered' => 'Chartered',
  'Designing' => 'Designing',
  'Developing' => 'Developing',
  'Testing' => 'Testing',
  'Operational' => 'Operational',
  'Retired' => 'Retired',
  '' => '',
  ),
  'default_value' => '',
  'allow_null' => 0,
  'multiple' => 0,
  ),
  array(
  'key' => 'field_5366378876972',
  'label' => 'Protection level - Confidentiality',
  'name' => 'protection_level_c',
  'type' => 'radio',
  'instructions' => 'Select protection level for CONFIDENTIALITY',
  'choices' => array(
  'PL4' => 'PL4',
  'PL3' => 'PL3',
  'PL2' => 'PL2',
  'PL1' => 'PL1',
  ),
  'other_choice' => 0,
  'save_other_choice' => 0,
  'default_value' => '',
  'layout' => 'horizontal',
  ),
  array(
  'key' => 'field_5366386f76974',
  'label' => 'Protection level - Availability',
  'name' => 'protection_level_a',
  'type' => 'radio',
  'choices' => array(
  'PL4' => 'PL4',
  'PL3' => 'PL3',
  'PL2' => 'PL2',
  'PL1' => 'PL1',
  ),
  'other_choice' => 0,
  'save_other_choice' => 0,
  'default_value' => '',
  'layout' => 'horizontal',
  ),
  array(
  'key' => 'field_5366382f76973',
  'label' => 'Protection level - Integrity',
  'name' => 'protection_level_i',
  'type' => 'radio',
  'choices' => array(
  'PL4' => 'PL4',
  'PL3' => 'PL3',
  'PL2' => 'PL2',
  'PL1' => 'PL1',
  ),
  'other_choice' => 0,
  'save_other_choice' => 0,
  'default_value' => '',
  'layout' => 'horizontal',
  ),
  array(
  'key' => 'field_536638ad76975',
  'label' => 'Service hours',
  'name' => 'service_hours',
  'type' => 'select',
  'required' => 1,
  'choices' => array(
  '24/7' => '24/7',
  '07:00 - 17:00' => '07:00 - 17:00',
  ),
  'default_value' => '07-17',
  'allow_null' => 0,
  'multiple' => 0,
  ),
  ),
  'location' => array(
  array(
  array(
  'param' => 'post_type',
  'operator' => '==',
  'value' => 'service',
  'order_no' => 0,
  'group_no' => 0,
  ),
  ),
  ),
  'options' => array(
  'position' => 'acf_after_title',
  'layout' => 'no_box',
  'hide_on_screen' => array(
  ),
  ),
  'menu_order' => 0,
  ) );
  register_field_group( array(
  'id' => 'acf_revision',
  'title' => 'Revision',
  'fields' => array(
  array(
  'key' => 'field_5354cce8145d4',
  'label' => 'revision interval',
  'name' => 'revision_interval',
  'type' => 'text',
  'required' => 1,
  'default_value' => '1 year',
  'placeholder' => '',
  'prepend' => 'Revision interval:',
  'append' => '',
  'formatting' => 'none',
  'maxlength' => '',
  ),
  ),
  'location' => array(
  array(
  array(
  'param' => 'post_type',
  'operator' => '==',
  'value' => 'post',
  'order_no' => 0,
  'group_no' => 0,
  ),
  ),
  array(
  array(
  'param' => 'post_type',
  'operator' => '==',
  'value' => 'service',
  'order_no' => 0,
  'group_no' => 1,
  ),
  ),
  array(
  array(
  'param' => 'post_type',
  'operator' => '==',
  'value' => 'definition',
  'order_no' => 0,
  'group_no' => 2,
  ),
  ),
  array(
  array(
  'param' => 'post_type',
  'operator' => '==',
  'value' => 'ctrl_doc',
  'order_no' => 0,
  'group_no' => 3,
  ),
  ),
  ),
  'options' => array(
  'position' => 'acf_after_title',
  'layout' => 'no_box',
  'hide_on_screen' => array(
  ),
  ),
  'menu_order' => 4,
  ) );
  }
 */

function pams_style() {
    wp_register_style( 'pams-style', plugins_url( 'pams_style.css', __FILE__ ) );
    wp_enqueue_style( 'pams-style' );
}

add_action( 'wp_enqueue_scripts', 'pams_style' );

function pams_alter_content( $content ) {
    if ( is_single() && !is_archive() && !is_search() ) {
        GLOBAL $post_type;
        GLOBAL $post;
//        $ctrl_doc_options = $PAMS_OPTIONS_ARR[ 'ctrl_doc' ];
        if ( $post_type == 'ctrl_doc' ) {

            $retval = get_template_part( 'content', 'single-ctrl_doc' );
            return $retval;
        }
        if ( $post_type == 'service' ) {

            $retval = get_template_part( 'content', 'single-service' );
            return $retval;
        } else
            return $content;
    } else
        return $content;
}

//add_filter( 'the_content', pams_alter_content );
// Priority of 9 is set so that read more filter function fires AFTER this one.
//add_filter( 'get_the_excerpt', 'pams_excerpt', 9 );
//function pams_excerpt( $excerpt ) {
//    //GLOBAL $post_type;
//    GLOBAL $post;
//
//    // generate new excerpt
//    $excerpt_more = '';
//    if ( !has_excerpt() ) {
//        $new_excerpt = wp_trim_words( wp_trim_excerpt(), 30 );
//    } else
//        $new_excerpt = $excerpt;
//
//    //$excerpt_more = ' <a href="' . get_permalink() . '" rel="nofollow">[Read more]</a>';
//    $excerpt_more = '';
//
//    if ( $post->post_type == 'ctrl_doc' ) {
//        $output = get_ctrldoc_obj_and_prcpl( $post->ID );
//        $output .= $new_excerpt . $excerpt_more;
//    } else
//        $output = $new_excerpt . $excerpt_more;
//
//    return $output;
//}
//
// Add support for Featured Images
if ( function_exists( 'add_theme_support' ) ) {
    add_theme_support( 'post-thumbnails', array( 'post', 'service', 'ctrl_doc', 'definition', 'page' ) );
    add_image_size( 'index-categories', 150, 150, true );
    add_image_size( 'page-single', 640, 0, true );
    add_image_size( 'full_width', 871, 0, true );
}

function InsertFeaturedImage( $content ) {

    global $post;

    $original_content = $content;

    if ( current_theme_supports( 'post-thumbnails' ) ) {

        if ( is_page() ) {
            $content = the_post_thumbnail( 'full-width' );
            $content .= $original_content;
        } else {
            $content = the_post_thumbnail( 'index-categories' );
            $content .= $original_content;
        }
    }
    return $content;
}

add_filter( 'the_content', 'InsertFeaturedImage' );

// Hooks your functions into the correct filters
function pams_add_mce_button() {
    // check user permissions
    if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
        return;
    }
    // check if WYSIWYG is enabled
    if ( 'true' == get_user_option( 'rich_editing' ) ) {
        add_filter( 'mce_external_plugins', 'pams_add_tinymce_plugin' );
        add_filter( 'mce_buttons', 'pams_register_mce_button' );
    }
}

add_action( 'admin_head', 'pams_add_mce_button' );

// Declare script for new button
function pams_add_tinymce_plugin( $plugin_array ) {
    $plugin_array[ 'pams_mce_button_1' ] = plugins_url() . '/pams-lypdos/js/mce-button.js';
    $plugin_array[ 'pams_mce_button_2' ] = plugins_url() . '/pams-lypdos/js/mce-button.js';
    $plugin_array[ 'pams_mce_button_3' ] = plugins_url() . '/pams-lypdos/js/mce-button.js';
    $plugin_array[ 'pams_mce_button_4' ] = plugins_url() . '/pams-lypdos/js/mce-button.js';
    return $plugin_array;
}

// Register new button in the editor
function pams_register_mce_button( $buttons ) {
    array_push( $buttons, 'pams_mce_button_1' );
    array_push( $buttons, 'pams_mce_button_2' );
    array_push( $buttons, 'pams_mce_button_3' );
    array_push( $buttons, 'pams_mce_button_4' );
    return $buttons;
}

function pams_test_func() {
    echo 'plugins_url: ' . plugins_url();
    echo '<hr>';
    echo 'get_template_directory: ' . get_template_directory();
    echo '<hr>';
    echo 'get_template_directory_uri: ' . get_template_directory_uri();
    echo '<hr>';
    echo 'plugin_dir_url: ' . plugin_dir_url( __file__ );
    echo '<hr>';
    echo 'plugin_dir_path: ' . plugin_dir_path( __file__ );
    echo '<hr>';
//    $ctrl_doc_options = $PAMS_OPTIONS_ARR['ctrl_doc'];
//    print_r ( $ctrl_doc_options );
    //echo 'Options: ' . (array) $ctrl_doc_options['show_obj_prcpl'];
    echo '<hr>';
}

add_shortcode( 'pams_test', 'pams_test_func' );

/*
 * Change site description values
 */

function replace_bloginfo( $info, $show ) {
    if ( $show == 'name' ) {
        $info = get_option( 'pms_lypdos_site_title', 'PAMS Lypdos' );
    }
    if ( $show == 'description' ) {
        $info = get_option( 'pms_lypdos_site_description', 'A lightweight, yet powerful documentation system' );
    }
    return $info;
}

add_filter( 'bloginfo', 'replace_bloginfo', 10, 2 );

function get_posts_revision_overdue( $atts, $content = '' ) {
    $def_rev_interval = get_option( pms_lypdos_def_rev_interval, '1 year' );
    $args = array(
        'post_type' => array( 'ctrl_doc', 'service', 'definition' ),
        'orderby' => array( 'type' => 'ASC', 'modified' => 'ASC' ),
        'posts_per_page' => -1,
    );
    $query_result = new WP_Query( $args );
    $output = '';
    //walk throug query
    if ( $query_result->have_posts() ) {
        //$output .= '<h3>Posts overdue</h3>';
        $output .= '<table class="post_listing">';
        $output .= '<tr><th>Title</th><th>Responsible</th><th>Days overdue</th></tr>';
        $dtype_prev = '';
        $count_overdue = 0;
        while ( $query_result->have_posts() ) {
            $query_result->the_post();
            //find overdue posts
            $rev_interval = get_post_meta( get_the_ID(), 'review_interval', true );
            //if demo mode always settings revision interval
            if ( 'enabled' == get_option( 'pms_demo_mode', 'enabled' ) ) {
                $rev_interval = $def_rev_interval;
            } elseif ( !$rev_interval )
                $rev_interval = $def_rev_interval;
            date_sub( $rev_deadline, date_interval_create_from_date_string( $rev_interval ) );
            $doc_date = new DateTime( get_the_modified_date() );
//            $output .= 'Date: ' . get_the_modified_date();
//            $output .= $doc_date->format('Y-m-d');
            $next_edit = new DateTime( $doc_date->format( 'Y-m-d' ) );
            $today = new DateTime( 'now' );
            date_add( $next_edit, date_interval_create_from_date_string( $rev_interval ) );
            $date_age = $today->diff( $next_edit );
            if ( $next_edit < $today ) {
                $count_overdue++;
                //show overdue posts
                $dtype = get_post_type_object( get_post_type() )->labels->singular_name;
                if ( $dtype <> $dtype_prev ) {
                    $output .= '<tr><th colspan="3" style="color:#2c807f">' . $dtype . 's</tr>';
                    $dtype_prev = $dtype;
                }
                $doc_resp = get_field( 'document_responsible' );
                $output .= '<tr><td class="post_listing"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></td>';

                if ( !$doc_resp ) {
                    if ( $count_overdue = 0 )
                        $output .= '<td class="post_listing">CISO</td>';
                    else
                        $output .= '<td class="post_listing_date_alert">Not assigned</td>';
                } else
                    $output .= '<td class="post_listing">' . get_field( 'document_responsible' ) . '</td>';
                $output .= '<td class="post_listing_date_alert" width="18%">' . $date_age->format( '%R%a days' ) . '</td></tr>';
            }
        }
        $output .= '</table>';
        $output .= sprintf( 'Found %d overdue posts.', $count_overdue );
    }
    /* Restore original Post Data */
    //wp_reset_postdata();
    wp_reset_query();
    return $output;
}

function get_posts_older_than( $date, $posttypes ) {
    $args = array(
        'post_type' => array( 'ctrl_doc', 'service', 'definition' ),
        'orderby' => array( 'type' => 'DESC', 'modified' => 'ASC' ),
        'date_query' => array(
            'before' => $date,
            'inclusive' => true,
        ),
        'posts_per_page' => -1,
    );
    $query = new WP_Query( $args );
//    print_r( $query );
    return $query;
}

function posts_older_than( $atts, $content = '' ) {
    $dt = new DateTime( 'now' );
    $newdt = $dt->modify( '-1 year' )->format( 'Y-m-d' );
    extract( shortcode_atts( array( 'date' => $newdt ), $atts ) );
    $query_result = get_posts_older_than( $date );
    if ( $query_result->have_posts() ) {
        $output .= 'Found ' . $query_result->found_posts . ' posts older than ' . $date . '.';
        $output .= '<table class="post_listing">';
        $output .= '<tr><th>Title</th><th>Responsible</th><th>Last edited</th></tr>';
        $dtype_prev = '';
        while ( $query_result->have_posts() ) {
            $query_result->the_post();
            $dtype = get_post_type_object( get_post_type() )->labels->singular_name;
            if ( $dtype <> $dtype_prev ) {
                $output .= '<tr><th colspan="3" style="color:#2c807f">' . $dtype . 's</tr>';
                $dtype_prev = $dtype;
            }
            $output .= '<tr><td class="post_listing">' . get_the_title() . '</td>';
            $output .= '<td class="post_listing">' . get_field( 'document_responsible' ) . '</td>';
//            $output .= '<td class="post_listing">' . $dtype . '</td>';
            $output .= '<td class="post_listing_date_alert" width="18%">' . get_the_date( "Y-m-d" ) . '</td></tr>';
        }
        $output .= '</table>';
    } else {
        $output .= 'No posts found older than ' . $date;
    }
    /* Restore original Post Data */
    //wp_reset_postdata();
    wp_reset_query();
    return $output;
}

function register_shortcodes() {
    add_shortcode( 'display_posts_older_than', 'posts_older_than' );
    add_shortcode( 'display_posts_revision_overdue', 'get_posts_revision_overdue' );
}

add_action( 'init', 'register_shortcodes' );

function register_filters() {
    if ( 'enabled' == get_option( 'pms_demo_mode', 'enabled' ) ) {
        add_filter( 'show_admin_bar', '__return_false' );
    }
}

add_action( 'init', 'register_filters' );
