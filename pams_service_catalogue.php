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

function add_service_taxonomies() {
// Add new "ServiceTypes" taxonomy to Services
    register_taxonomy( 'service_type', 'service', array(
// Hierarchical taxonomy (like categories)
        'hierarchical' => true,
        // This array of options controls the labels displayed in the WordPress Admin UI
        'labels' => array(
            'name' => _x( 'ServiceTypes', 'taxonomy general name' ),
            'singular_name' => _x( 'ServiceType', 'taxonomy singular name' ),
            'search_items' => __( 'Search ServiceTypes' ),
            'all_items' => __( 'All ServiceTypes' ),
            'parent_item' => __( 'Parent ServiceType' ),
            'parent_item_colon' => __( 'Parent ServiceType:' ),
            'edit_item' => __( 'Edit ServiceType' ),
            'update_item' => __( 'Update ServiceType' ),
            'add_new_item' => __( 'Add New ServiceType' ),
            'new_item_name' => __( 'New ServiceType Name' ),
            'menu_name' => __( 'ServiceTypes' ),
        ),
        // Control the slugs used for this taxonomy
        'rewrite' => array(
            'slug' => 'servicetypes', // This controls the base slug that will display before each term
            'with_front' => false, // Don't display the category base before "/locations/"
            'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
        ),
    ) );

    register_taxonomy( 'service_category', 'service', array(
// Hierarchical taxonomy (like categories)
        'hierarchical' => true,
        // This array of options controls the labels displayed in the WordPress Admin UI
        'labels' => array(
            'name' => _x( 'ServiceCategories', 'taxonomy general name' ),
            'singular_name' => _x( 'ServiceCategory', 'taxonomy singular name' ),
            'search_items' => __( 'Search ServiceCategories' ),
            'all_items' => __( 'All ServiceCategories' ),
            'parent_item' => __( 'Parent ServiceCategory' ),
            'parent_item_colon' => __( 'Parent ServiceCategory:' ),
            'edit_item' => __( 'Edit ServiceCategory' ),
            'update_item' => __( 'Update ServiceCategory' ),
            'add_new_item' => __( 'Add New ServiceCategory' ),
            'new_item_name' => __( 'New ServiceCategory Name' ),
            'menu_name' => __( 'ServiceCategories' ),
        ),
        // Control the slugs used for this taxonomy
        'rewrite' => array(
            'slug' => 'servicecategories', // This controls the base slug that will display before each term
            'with_front' => false, // Don't display the category base before "/locations/"
            'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
        ),
    ) );
// Add new "TargetGroups" taxonomy to Posts
}

add_action( 'init', 'add_service_taxonomies', 0 );

function pams_post_service() {
    $labels = array(
        'name' => _x( 'Services', 'post type general name' ),
        'singular_name' => _x( 'Service', 'post type singular name' ),
        'add_new' => _x( 'Add New', 'service' ),
        'add_new_item' => __( 'Add New Service' ),
        'edit_item' => __( 'Edit Service' ),
        'new_item' => __( 'New Service' ),
        'all_items' => __( 'All Services' ),
        'view_item' => __( 'View Service' ),
        'search_items' => __( 'Search Services' ),
        'not_found' => __( 'No services found' ),
        'not_found_in_trash' => __( 'No services found in the Trash' ),
        'parent_item_colon' => '',
        'menu_name' => 'Services'
    );
    $args = array(
        'labels' => $labels,
        'description' => 'Holds our service descriptions',
        'public' => true,
        'menu_position' => 5,
        'supports' => array( 'title', 'editor', 'excerpt', 'comments', 'revisions' ),
        'taxonomies' => array( 'post_tag' ),
        'has_archive' => true,
        'hierarchical' => true
    );
    register_post_type( 'service', $args );
}

add_action( 'init', 'pams_post_service' );

function get_service_date_bar( $id ) {
    echo ( 'Published on: ' );
    the_time( get_option( 'date_format' ) );
    echo (' | ');
    if ( $last_id = get_post_meta( get_the_ID(), '_edit_last', true ) ) {
        $last_user = get_userdata( $last_id );
        printf( __( 'Last edited by: %1$s on %2$s at %3$s' ), esc_html( strtoupper( $last_user->display_name ) ), mysql2date( get_option( 'date_format' ), get_post( $id )->post_modified ), mysql2date( get_option( 'time_format' ), get_post( $id )->post_modified ) );
    }
    ?> | <?php
    echo 'Revision interval: ';
    the_field( 'revision_interval' );
    //echo ( '</p>' );
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
function get_the_servicetype_list( $before = '', $sep = '', $after = '', $id = 0 ) {
    return apply_filters( 'the_service_types', get_the_term_list( $id, 'service_type', $before, $sep, $after ), $before, $sep, $after, $id );
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
function the_service_types( $before = null, $sep = ', ', $after = '', $id = 0 ) {
    if ( null === $before )
        $before = __( 'Service types: ' );
    echo get_the_targetgroup_list( $before, $sep, $after, $id );
}

function the_service_header_table( $id ) {
    echo get_service_header_table( $id );
}

function get_service_header_table( $id ) {
    //echo ( '<div class = "doctypemeta">' );
    $output = '';
    $output .= '<table class = "doctypemeta"><tr>';
    $output .= '<td class = "doctypemeta"><b>Document id: </b>' . get_the_ID() . '</td>';
    $output .= '<td class = "doctypemeta"><b>Owner: </b>' . get_field( 'service_owner', $id ) . '</td>';
    $output .= '<td class = "doctypemeta"><b>Tech. responsible: </b>' . get_field( 'technical_responsible', $id ) . '</td>';
    $output .= '</tr>';
    $before = ( '<td class = "doctypemeta"><b>Service type: </b>' );
    $sep = ', ';
    $after = '';
    $output .= apply_filters( 'the_service_types', get_the_term_list( $id, 'service_type', $before, $sep, $after ), $before, $sep, $after, $id );
    $output .= '</td>';
    $before = ( '<td class = "doctypemeta"><b>Category: </b>' );
    $sep = ', ';
    $after = '';
    $output .= apply_filters( 'the_service_types', get_the_term_list( $id, 'service_category', $before, $sep, $after ), $before, $sep, $after, $id );
    $output .= '</td>';
    $output .= '<td class = "doctypemeta"><b>Lifecycle stage: </b>' . get_field( 'lifecycle_stage', $id ) . '</td>';
    $output .= '<tr>';
    $output .= '<td class = "doctypemeta"><b>Service hours: </b>' . get_field( 'service_hours', $id ) . '</td>';
    $output .= '<td colspan="2" class = "doctypemeta"><b>Escalation contact: </b>' . get_field( 'escalation_contact', $id ) . '</td>';
    //$output .= '<td></td>'; //'<td class = "doctypemeta"><b>Lifecycle stage: </b>' . get_field( 'lifecycle_stage', $id ) . '</td>' ;    
    $output .= '</tr></table>';
    return $output;
}

function the_supporting_service_header_table( $id ) {
    echo get_supporting_service_header_table( $id );
}

function get_supporting_service_header_table( $id ) {
    $output = '<table class = "subservice_meta"><tr>';
    $output .= '<td class = "subservice_meta" style="width: 20%"><b>Document id: </b>' . get_post( $id )->ID . '</td>';
    $before = ( '<td class = "subservice_meta"><b>Service type: </b>' );
    $sep = ', ';
    $after = '';
    $output .= apply_filters( 'the_service_types', get_the_term_list( $id, 'service_type', $before, $sep, $after ), $before, $sep, $after, $id );
    $output .= '</td>';
    $before = ( '<td class = "subservice_meta"><b>Category: </b>' );
    $sep = ', ';
    $after = '';
    $output .= apply_filters( 'the_service_types', get_the_term_list( $id, 'service_category', $before, $sep, $after ), $before, $sep, $after, $id );
    $output .= '</td>';
    $output .= '</tr></table>';
    return $output;
}

function the_service_level_table( $id ) {
    echo get_service_level_table( $id );
}

function get_service_level_table( $id ) {
    //echo ( '<div class = "services_meta">' );
    $output = '<table class = "service_level_table">';
    $output .= '<tr><td class = "service_level_table"><b>Service hours: </b>' . get_field( 'service_hours', $id ) . '</td>';
    $output .= '<td class = "service_level_table"> - </td>';
    $output .= '<td class = "service_level_table"> - </td>';
    $output .= '<td class = "service_level_table"> - </td>';
    $output .= '</tr>';
    $output .= '<tr><td class = "service_level_table"><b>Protection levels:</b></td>';
    $output .= '<td class = "service_level_table">Confidentiality: ' . get_field( 'protection_level_c', $id ) . '</td>';
    $output .= '<td class = "service_level_table">Integrity: ' . get_field( 'protection_level_i', $id ) . '</td>';
    $output .= '<td class = "service_level_table">Availability: ' . get_field( 'protection_level_a', $id ) . '</td>';
    $output .= '</tr>';
    $output .= '</table>';
    return $output;
}

function has_supporting_services( $id ) {
    $tst = get_field( 'supporting_services', $id );
    if ( FALSE == $tst )
        return FALSE;
    else
        return TRUE;
}

function the_supporting_services( $id ) {
    $sub_srvs = get_field( 'sub-services', $id );
    if ( $sub_srvs ) {
        echo ('<div class="sub_services_box">');
        echo ('<b>Supporting services:</b>');
        ?>    <ul>
            <?php foreach ( $sub_srvs as $srv ): ?>
                <li>
                    <a href="<?php echo get_permalink( $srv->ID ); ?>">
                        <?php echo get_the_title( $srv->ID ); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php
        echo ('</div>');
    }
}

function the_supporting_services_excerpt( $id ) {
    echo get_supporting_services_excerpt( $id );
}

function get_supporting_services_excerpt( $id ) {
    $sub_srvs = get_field( 'supporting_services', $id );
    if ( $sub_srvs ) {
        $output = '';
        foreach ( $sub_srvs as $srv ):
            $output .= '<div class="sub_services_full_box">';
            $output .= get_supporting_service_header_table( $srv->ID );
            $output .= ' <h4><a href="' . get_permalink( $srv->ID ) . '">';
            $output .= apply_filters( 'get_the_title',  $srv->post_title );
            $output .= '</a></h4>';
            $output .= pams_get_excerpt_by_id( $srv->ID );
            $output .= '</div>';
        endforeach;
    }
    return $output;
}

function bn_show_services_list_func( $atts = NULL, $content = 'Definition text' ) {
    if ( $atts )
        extract( shortcode_atts( array( 'title' => 'default title' ), $atts ) );
    $args = array(
        'post_type' => 'service',
        'orderby' => 'title',
        'order' => 'ASC'
    );
    $custom_query = new WP_Query( $args );
    while ( $custom_query->have_posts() ) : $custom_query->the_post();
        ?>
        <div <?php post_class(); ?>>
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <?php //the_doc_meta_table( the_ID() ) ?>
        </div>

        <?php
        the_excerpt();
    //echo get_post( the_ID() )->post_excerpt;
    //echo ( '</li>' );
    endwhile;
    wp_reset_postdata(); // reset the query
}

add_shortcode( 'bn_show_services_list', 'bn_show_services_list_func' );

function the_service_excerpt( $id ) {
    echo get_service_excerpt( $id );
}

function get_service_excerpt( $id ) {
    return apply_filters( 'the_service_excerpt', get_the_service_excerpt( $id ) );
}

/**
 * Retrieve the service excerpt.
 *
 * @since 0.71
 *
 * @param mixed $deprecated Not used.
 * @return string
 */
function get_the_service_excerpt( $id ) {

    $post = get_post( $id );

    $before = ( '<p style="border: solid 1px; padding:2px; margin-bottom:0px; margin-top:2px"><b>Service type: </b>' );
    $sep = ', ';
    $after = '</p>';
    $stype = apply_filters( 'the_service_types', get_the_term_list( $id, 'service_type', $before, $sep, $after ), $before, $sep, $after, $id );

    $lc_state = get_field( 'lifecycle_stage', $id );

    $excpt = '<div class="excerpt_box">';
    $excpt .= ' <h4><a href="' . get_permalink( $id ) . '">';
    $excpt .= get_the_title( $id );
    $excpt .= '</a></h4>';

    $excpt .= $stype;
    $excpt .= '<p style="border: solid 1px; padding:2px;  margin-bottom:3px; margin-top:2px"><strong>Lifecycle state:</strong> ' . $lc_state . '</p>';
//    if ( !empty( $post->post_excerpt ) )
//        $excpt .= '<div class="excerpt_text">' . wp_strip_all_tags ( $post->post_excerpt ) . '</div>';
    $excpt .= pams_get_excerpt_by_id( $id );

    if ( post_password_required() ) {
        return __( 'There is no excerpt because this is a protected post.' );
    }
    $excpt .= '</div>';
    
    
    return $excpt;
    //return apply_filters( 'get_the_service_excerpt', $excpt );
}

function get_supporting_service_excerpt( $id ) {

    $post = get_post( $id );

//    $before = ( '<p style="border: solid 1px; padding:2px; margin-bottom:0px; margin-top:2px"><b>Service type: </b>' );
//    $sep = ', ';
//    $after = '</p>';
//    $stype = apply_filters( 'the_service_types', get_the_term_list( $id, 'service_type', $before, $sep, $after ), $before, $sep, $after, $id );
//
//    $lc_state = get_field( 'lifecycle_stage', $id );

//    $excpt = '<div>';
//    $excpt .= ' <h4><a href="' . get_permalink( $id ) . '">';
//    $excpt .= get_the_title( $id );
//    $excpt .= '</a></h4>';

//    $excpt .= $stype;
//    $excpt .= '<p style="border: solid 1px; padding:2px;  margin-bottom:3px; margin-top:2px"><strong>Lifecycle state:</strong> ' . $lc_state . '</p>';
    $excpt = '<div class="excerpt_text">' . wp_strip_all_tags ( $post->post_excerpt ) . '</div>';

    if ( post_password_required() ) {
        return __( 'There is no excerpt because this is a protected post.' );
    }
    $excpt .= '</div>';
    return $excpt;
    //return apply_filters( 'get_the_excerpt', $excpt );
}

function get_the_service_index() {
    $s_cats = get_terms( 'service_category', array(
        'hide_empty' => 0,
            ) );
    $s_cat_list = 'Empty list';
    if ( !empty( $s_cats ) && !is_wp_error( $s_cats ) ) {
        $count = count( $s_cats );
        $col_shift = $count / 2;
        $i = 0;
        $s_cat_list = '<h3>Service index by category</h3>';
        $s_cat_list .= '<div id="page_content_editable" class="editable span8 list_two_column_left"><ul>';
        foreach ( $s_cats as $s_cat ) {
            $i++;
            if ( $i > $col_shift ) {
                $s_cat_list .= '</ul></div>';
                $s_cat_list .= '<div id="page_content_editable" class="editable span8 list_two_column_right"><ul>';
                $col_shift = 9999;
            }
            $s_cat_list .= '<li>';
            $s_cat_list .= '<a href="' . get_term_link( $s_cat ) . '" title="' . sprintf( __( 'View all post filed under %s', 'my_localization_domain' ), $s_cat->name ) . '"><strong>' . $s_cat->name . '</strong> (' . $s_cat->count . ')</a>';
            //show service headings
            if ( $s_cat->count > 0 ) {
                $s_cat_list .= '<ul>';
                $args = array( 'posts_per_page' => -1,
                    'post_type' => 'service',
                    'post_status' => 'publish',
                    'orderby' => 'slug',
                    'order' => 'ASC',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'service_category',
                            'field' => 'slug',
                            'terms' => $s_cat->slug )
                    )
                );
                $myposts = get_posts( $args );
                foreach ( $myposts as $pst ) {
                    $s_cat_list .= '<li><div class="walker-element">';
                    $s_cat_list .= '<a href="' . get_the_permalink( $pst->ID ) . '">' . get_the_title( $pst->ID ) . '</a>';
                    $s_cat_list .= '<div class="element-summary">' . get_the_service_excerpt( $pst->ID ) . '</div>';
                    $s_cat_list .= '</div></li>';
                };
//wp_reset_postdata();
                $s_cat_list .= '</ul>';
            }
            $s_cat_list .= '</li>';
        }
        $s_cat_list .= '</ul></div>';
        return $s_cat_list;
        //print_r($s_cats);
    }
}

function the_service_index() {
    apply_filters( 'the_service_index', get_the_service_index() );
}

add_shortcode( 'pams_service_index', 'the_service_index' );

function get_service_children_box( $id = '' ) {
    $output = '';
    $sWalker = new Pams_Service_Walker();
    if ( !$id ) {
        //$children = wp_list_pages( 'sort_column=post_name&echo=0&post_type=ctrl_doc&title_li=' );
        $children = wp_list_pages( array( 'post_type' => 'service', 'echo' => 0, 'title_li' => null, 'walker' => $sWalker, 'sort_column' => 'post_name', 'sort_order' => 'ASC' ) );
        if ( $children ) {
            $output .= '<h3>Service index</h3>';
            $output .= '<div id="page_content_editable" class="editable span8">';
            $output .= $children;
            $output .= '</div>';
        }
    } else {
        //$children = wp_list_pages( 'child_of=' . $id . '&echo=0&post_type=ctrl_doc&title_li=' );
        $children = wp_list_pages( array( 'post_type' => 'service', 'echo' => 0, 'title_li' => null, 'walker' => $sWalker, 'sort_column' => 'post_name', 'sort_order' => 'ASC', 'child_of' => $id ) );
        if ( $children ) {
            $output .= '<h3>Child services</h3>';
            $output .= '<div class="child_page_listing_box">';
            $output .= $children;
            $output .= '</div>';
        }
    }
    return $output;
}

function the_service_children_box() {
    return apply_filters( 'the_service_index', get_the_service_index() );
}

add_shortcode( 'pams_show_service_list', 'the_service_children_box' );

function pms_service_display_settings() {
    //SERVICE settings
    $service_show_subs = (get_option( 'pms_lypdos_service_show_subs' ) == 'enabled') ? 'checked' : '';
    $service_show_metabox = (get_option( 'pms_lypdos_service_show_metabox' ) == 'enabled') ? 'checked' : '';
    $service_show_dependings = (get_option( 'pms_lypdos_service_show_depending_services' ) == 'enabled') ? 'checked' : '';

    $html = '<div class="wrap">

            <form method="post" name="options" action="options.php">

            <h2>SERVICE settings</h2>' . wp_nonce_field( 'update-options' ) . '
            <h3>Services</h3>
            <table width="100%" cellpadding="10" class="form-table">
                <tr>
                    <td align="left" scope="row">
                    <label>Show supporting services: </label><input type="checkbox" ' . $service_show_subs . ' name="pms_lypdos_service_show_subs" 
                    value="enabled" />

                    </td> 
                <tr>
                    <td align="left" scope="row">
                    <label>Show meta information: </label><input type="checkbox" ' . $service_show_metabox . ' name="pms_lypdos_service_show_metabox" 
                    value="enabled"/>

                    </td> 
                </tr>            
                <tr>
                    <td align="left" scope="row">
                    <label>Show depending services: </label><input type="checkbox" ' . $service_show_dependings . ' name="pms_lypdos_service_show_depending_services" 
                    value="enabled"/>

                    </td> 
                </tr>            
                </tr>                
            </table>
            <p class="submit">
                <input type="hidden" name="action" value="update" />  
                <input type="hidden" name="page_options" value="pms_lypdos_service_show_subs,pms_lypdos_service_show_metabox,pms_lypdos_service_show_depending_services" /> 
                <input type="submit" name="Submit" value="Update" />
            </p>
            </form>

        </div>';
    echo $html;
    //echo 'Metabox' . $ctrl_doc_show_metabox;
}

add_filter( 'the_content', 'insert_service_top_meta' );

function insert_service_top_meta( $content ) {
    global $post;
    if ( 'enabled' == get_option( 'pms_lypdos_service_show_metabox', 'enabled' ) ) {
        if ( is_single() && ( $post->post_type == 'service') ) {
            $prep_txt = get_the_date_bar( $post->ID );
//            $prep_txt = '<div id="doc_meta_wrap">';
//            $prep_txt .= ( 'Published on: ' );
//            $prep_txt .= ( get_the_time( get_option( 'date_format' ) ) );
//            $prep_txt .= ( ' | ' );
//            if ( $last_id = get_post_meta( get_the_ID(), '_edit_last', true ) ) {
//                $last_user = get_userdata( $last_id );
//                $prep_txt .= ( sprintf( __( 'Last edited by: %1$s on %2$s at %3$s' ), esc_html( strtoupper( $last_user->display_name ) ), mysql2date( get_option( 'date_format' ), $post->post_modified ), mysql2date( get_option( 'time_format' ), $post->post_modified ) ) );
//            }
//            $prep_txt .= ( ' | ' );
//            $prep_txt .= ( 'Revision interval: ' );
//            $prep_txt .= ( get_field( 'revision_interval' ) );
//            $prep_txt .= ( '</div>' );

            $prep_txt .= get_service_header_table( $post->id );
            $content = $prep_txt . $content;
        }
    }
    if ( 'enabled' == get_option( 'pms_lypdos_service_show_subs', 'enabled' ) ) {
        if ( TRUE == has_supporting_services( $post->ID ) && ( $post->post_type == 'service') ) {
            if ( is_single() ) {
                $append_txt = '<h3 style="margin: 0.5em 0 0 0">Supporting services</h3>';
                $append_txt .= get_supporting_services_excerpt( $post->ID );
                $append_txt .= '<div class="clear"></div>';
                $append_txt .= '<div class="clear"></div>';
                $content .= $append_txt;
            }
        }
    }
    if ( has_tag() ) {
        if ( is_single() && ( $post->POST_TYPE == 'service') ) {
            $append_txt = ( '<div id="tags_wrap">' );
            $append_txt .= ( get_the_tag_list( 'TAGS: ', ', ', '' ) );
            $append_txt .= ( '</div>' );
            $content .= $append_txt;
        }
    }

    return $content;
}

function get_depending_services( $id = '', $s_bar = 'false' ) {
    if ( !$id )
        $id = get_the_ID();
    $sup_srvs = get_posts( array(
        'post_type' => 'service',
        'meta_query' => array(
            array(
                'key' => 'supporting_services', // name of custom field
                'value' => '"' . get_the_ID() . '"', // matches exaclty "123", not just 123. This prevents a match for "1234"
                'compare' => 'LIKE'
            )
        )
            ) );

    $output = '';
    if ( $sup_srvs ):
        if ( $s_bar )
            $output .= '<ul class="sidebar-list">';
        else
            $output .= '<ul>';
        foreach ( $sup_srvs as $srvs ):

            $output .= '<li>';
            $output .= '<a href="' . get_permalink( $srvs->ID ) . '">' . get_the_title( $srvs->ID ) . '</a>';
            $output .= '</li>';
        endforeach;
        $output .= '</ul>';
    else:
        $output = 'No depending services found';
    endif;
    return $output;
}
