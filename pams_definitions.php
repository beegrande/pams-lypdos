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

function pams_post_definition() {
    $labels = array(
        'name' => _x( 'Definitions', 'post type general name' ),
        'singular_name' => _x( 'Definition', 'post type singular name' ),
        'add_new' => _x( 'Add New', 'definition' ),
        'add_new_item' => __( 'Add New Definition' ),
        'edit_item' => __( 'Edit Definition' ),
        'new_item' => __( 'New Definition' ),
        'all_items' => __( 'All Definitions' ),
        'view_item' => __( 'View Definition' ),
        'search_items' => __( 'Search Definitions' ),
        'not_found' => __( 'No definitions found' ),
        'not_found_in_trash' => __( 'No definitions found in the Trash' ),
        'parent_item_colon' => '',
        'menu_name' => 'Definitions'
    );
    $args = array(
        'labels' => $labels,
        'description' => 'Holds our definitions and definition data',
        'public' => true,
        'menu_position' => 5,
        'hierarchical' => true,
        'supports' => array( 'title', 'editor', 'excerpt', 'comments', 'revisions' ),
        'taxonomies' => array( 'post_tag' ),
        'has_archive' => true
    );
    register_post_type( 'definition', $args );
}

add_action( 'init', 'pams_post_definition' );

function bn_show_definitions_list_func( $atts = NULL, $content = 'Definition text' ) {
    extract( shortcode_atts(
                    array(
        'title' => 'default title',
        'shortindex' => 'true' ), $atts ) );
    if ( $shortindex ) {
        the_definition_index( '' );
    } else {
        $args = array(
            'post_type' => 'definition',
            'orderby' => 'name',
            'order' => 'ASC',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'ignore_sticky_posts' => 1,
        );
        $custom_query = new WP_Query( $args );
        while ( $custom_query->have_posts() ) : $custom_query->the_post();
            ?>
            <div <?php post_class(); ?>>
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <?php //the_doc_meta_table( the_ID() )  ?>
            </div>

            <?php
            the_excerpt();
        //echo get_post( the_ID() )->post_excerpt;
        //echo ( '</li>' );
        endwhile;
        wp_reset_postdata(); // reset the query
    }
}

add_shortcode( 'bn_show_definitions_list', 'bn_show_definitions_list_func' );

function the_definition_index( $id = '' ) {
    if ( !$id ) {
        $children = wp_list_pages( 'sort_column=post_name&echo=0&post_type=definition&title_li=' );
        if ( $children ) {
            echo ('<h3>Index</h3>');
            echo ('<div class="child_page_listing_box">');
            //echo ( '<ul>' );
            echo ( $children );
            //echo ( '/<ul>' );
            echo ('</div>');
        }
    } else {
        $children = wp_list_pages( 'child_of=' . $id . '&echo=0&post_type=definition&title_li=' );
        if ( $children ) {
            echo ('<h3>Child definitions</h3>');
            echo ('<div class="child_page_listing_box">');
            //echo ( '<ul>' );
            echo ( $children );
            //echo ( '/<ul>' );
            echo ('</div>');
        }
    }
}

function the_definition_header_table( $id ) {
    echo get_definition_header_table( $id );
}

function get_definition_header_table( $id ) {
    //echo ( '<div class = "doctypemeta">' );
    $doc_resp_object = get_field_object( 'field_539cbd3051619', $id );
    $output = '';
    $output .= '<table class = "doctypemeta"><tr>';
    $output .= '<td class = "doctypemeta"><b>Document id: </b>' . get_the_ID() . '</td>';
    $output .= '<td class = "doctypemeta"><b>' . $doc_resp_object[ 'label' ] . ': </b>' . $doc_resp_object[ 'value' ] . '</td>';
    $output .= '<td></td>';
//    $output .= '</tr>';
//    $before = ( '<td class = "doctypemeta"><b>Service type: </b>' );
//    $sep = ', ';
//    $after = '';
//    $output .= apply_filters( 'the_service_types', get_the_term_list( $id, 'service_type', $before, $sep, $after ), $before, $sep, $after, $id );
//    $output .= '</td>';
//    $before = ( '<td class = "subservice_meta"><b>Category: </b>' );
//    $sep = ', ';
//    $after = '';
//    $output .= apply_filters( 'the_service_types', get_the_term_list( $id, 'service_category', $before, $sep, $after ), $before, $sep, $after, $id );
//    $output .= '</td>';
//    $output .= '<td class = "doctypemeta"><b>Lifecycle stage: </b>' . get_field( 'lifecycle_stage', $id ) . '</td>' ;
    $output .= '</tr></table>';
    return $output;
}

function pms_definition_display_settings() {
    //DEFINITION settings
    $definition_show_metabox = (get_option( 'pms_lypdos_definition_show_metabox' ) == 'enabled') ? 'checked' : '';
    $definition_show_revisions = (get_option( 'pms_lypdos_definition_show_revisions' ) == 'enabled') ? 'checked' : '';
    $definition_show_references = (get_option( 'pms_lypdos_definition_show_references' ) == 'enabled') ? 'checked' : '';


    $html = '<div class="wrap">

            <form method="post" name="options" action="options.php">

            <h2>PAMS LYPDOS settings</h2>' . wp_nonce_field( 'update-options' ) . '
            <h3>Definitions</h3>
            <table width="100%" cellpadding="10" class="form-table">
                <tr>
                    <td align="left" scope="row">
                    <label>Show meta information: </label><input type="checkbox" ' . $definition_show_metabox . ' name="pms_lypdos_definition_show_metabox" 
                    value="enabled"/>

                    </td> 
                </tr>                    
                <tr>
                    <td align="left" scope="row">
                    <label>Show revisions: </label><input type="checkbox" ' . $definition_show_revisions . ' name="pms_lypdos_definition_show_revisions" 
                    value="enabled" />

                    </td> 
                </tr> 
                <tr>
                    <td align="left" scope="row">
                    <label>Show references: </label><input type="checkbox" ' . $definition_show_references . ' name="pms_lypdos_definition_show_references" 
                    value="enabled" />

                    </td> 
                </tr>            
                </table>            
            <p class="submit">
                <input type="hidden" name="action" value="update" />  
                <input type="hidden" name="page_options" value=",pms_lypdos_definition_show_metabox,pms_lypdos_definition_show_revisions,pms_lypdos_definition_show_references" /> 
                <input type="submit" name="Submit" value="Update" />
            </p>
            </form>

        </div>';
    echo $html;
    //echo 'Metabox' . $ctrl_doc_show_metabox;
}

//$prefix = 'definition_';
//
//$fields = array(
//    array( // Text Input
//        'label' => 'Document owner', // <label>
//        'desc' => 'Enter the name of the documet owner.', // description
//        'id' => $prefix . 'document_owner', // field id and name
//        'type' => 'text' // type of field
//    )
//);

/*
 * $fields = array(

  array( // Repeatable & Sortable Text inputs
  'label' => 'Activities', // <label>
  'desc' => 'Input activity names and optionally a link to the activity description.', // description
  'id' => $prefix . 'repeatable', // field id and name
  'type' => 'repeatable', // type of field
  'sanitizer' => array( // array of sanitizers with matching kets to next array
  'featured' => 'meta_box_santitize_boolean',
  'title' => 'sanitize_text_field',
  'desc' => 'wp_kses_data'
  ),
  'repeatable_fields' => array( // array of fields to be repeated
  'title' => array(
  'label' => 'Activity',
  'id' => 'activity',
  'type' => 'text'
  ),
  'link' => array(
  'label' => 'Link',
  'id' => 'link',
  'type' => 'text'
  ),
  'responsible' => array(
  'label' => 'Responsible',
  'id' => 'responsible',
  'type' => 'text'
  )
  )
  )
  );
 */
### Instantiate the class with all required variables

/**
 * Instantiate the class with all variables to create a meta box
 * var $id string meta box id
 * var $title string title
 * var $fields array fields
 * var $page string|array post type to add meta box to
 * var $js bool including javascript or not
 */
//$definition_box = new custom_add_meta_box( 'definition_box', 'Definition meta', $fields, 'definition', true );


add_filter( 'the_content', 'insert_definition_content_special' );

function insert_definition_content_special( $content ) {
    global $post;
    $prep_txt = '';
    if ( is_single() && ( $post->post_type == 'definition') ) {
        if ( 'enabled' == get_option( 'pms_lypdos_definition_show_metabox', 'enabled' ) ) {
            $prep_txt .= get_the_date_bar( $post->ID);
            $prep_txt .= get_definition_header_table( $post->ID );
            //$content = $prep_txt . $content;
        }

        $content = $prep_txt . $content;
//Show children if any
        if ( 'enabled' == get_option( 'pms_lypdos_definition_show_child', 'enabled' ) ) {
            $append_txt = get_ctrldoc_children_box( $post->ID );
            $content .= $append_txt;
        }
//Show references
        if ( 'enabled' == get_option( 'pms_lypdos_definition_show_references', 'enabled' ) ) {
            if ( has_ctrldoc_references( $post->ID ) ) {
                $append_txt = '<h3>References</h3>';
                $append_txt .= get_ctrldoc_ext_references_box( $post->ID );
                $append_txt .= '<div class="clear"></div>';
            } else
                $append_txt = '<div class="clear"></div>';
            $content .= $append_txt;
        } else
            $content .= '<div class="clear"></div>';

//Show stakeholders is setting is TRUE                        
//Show Stakeholders if any
//        if ( 'enabled' == get_option( 'pms_lypdos_ctrl_doc_show_stakeholders', 'enabled' ) ) {
//            $append_txt = '<div id="print-only">';
//            $append_txt .= '<h3>Stakeholders</h3>';
//            $append_txt .= get_stakeholders();
//            $append_txt .= '</div>';
//            $content .= $append_txt;
//        }
//Show tags is any            
        if ( has_tag() ) {
            $append_txt = '<div id="tags_wrap">';
            $append_txt .= get_the_tag_list( 'TAGS: ', ', ', '' );
            $append_txt .= '</div>';
            $content .= $append_txt;
        }

        //echo '</div>';
//Show revisions if setting is TRUE
        if ( 'enabled' == get_option( 'pms_lypdos_definition_show_revisions', 'enabled' ) ) {
            $append_txt = '<hr>';
            if ( current_user_can( 'read' ) ) {
                if ( function_exists( 'the_revision_list_prd' ) ) {
                    $append_txt .= get_revision_list_prd( true );
                }
            }
            if ( current_user_can( 'read' ) ) {
                if ( function_exists( 'the_revision_diffs_prd' ) ) {
                    $append_txt .= get_revision_diffs_prd();
                }
            }
            $content .= $append_txt;
        }
    }
    return $content;
}
