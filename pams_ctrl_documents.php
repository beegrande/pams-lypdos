<?php
/*
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
function pams_post_ctrldocs() {
    $labels = array(
        'name' => _x( 'Ctrl_Docs', 'post type general name' ),
        'singular_name' => _x( 'Document', 'post type singular name' ),
        'add_new' => _x( 'Add New', 'document' ),
        'add_new_item' => __( 'Add New document' ),
        'edit_item' => __( 'Edit document' ),
        'new_item' => __( 'New document' ),
        'all_items' => __( 'All documents' ),
        'view_item' => __( 'View document' ),
        'search_items' => __( 'Search documents' ),
        'not_found' => __( 'No documents found' ),
        'not_found_in_trash' => __( 'No documents found in the Trash' ),
        'parent_item' => 'Parent document',
        'parent_item_colon' => 'Parent documents:',
        'menu_name' => 'Ctrl_Docs'
    );
    $args = array(
        'labels' => $labels,
        'description' => 'Holds our documents',
        'public' => true,
        'menu_position' => 7,
        'hierarchical' => true,
        'supports' => array( 'title', 'editor', 'excerpt', 'comments', 'revisions', 'page-attributes' ),
        'taxonomies' => array( 'post_tag', 'doctype', 'targetgroup', 'businessunit', 'country', 'category' ),
        'has_archive' => true
    );
    register_post_type( 'ctrl_doc', $args );
}

add_action( 'init', 'pams_post_ctrldocs' );

function get_classification_text( $id ) {
    $fld = get_field( 'classification', $id );
    $def_id_classification = get_option( 'pms_lypdos_def_id_classification', 0 );
    if ( !empty( $fld ) ) {
        if ( is_numeric( $def_id_classification ) ) {
            if ( $def_id_classification != 0 )
                $output = sprintf( '<a href="%s/?p=' . $def_id_classification . '" id="classification-text";>', site_url ( ) );
        } else
            $output = '<div id="classification-text-alert">Did not find classification label!</div>';
//$output .= '<div style="color: #888; text-transform: capitalize; text-align: right; text-height: 0.5em!important; position:absolute; left: -95px; bottom: 3px">Classification:</div>';
        $output .= get_field( 'classification', $id );
        $output .= '</a>';
    } else
        $output = '<span id="classification-text-alert">Missing classification!</span>';
    return $output;
}

function get_classification_row( $id ) {
    $fld = get_field( 'classification', $id );
    $def_id_classification = get_option( 'pms_lypdos_def_id_classification', 0 );
    if ( !empty( $fld ) ) {
        if ( ( $def_id_classification != 0 ) && ( is_numeric( $def_id_classification ) ) ) {
            $output = sprintf( '<a href="%s/?p=' . $def_id_classification . '" id="classification-row";>', site_url() );
        } else
            $output = 'id="classification-row"';
//$output .= '<div style="color: #888; text-transform: capitalize; text-align: right; text-height: 0.5em!important; position:absolute; left: -95px; bottom: 3px">Classification:</div>';
        $output .= get_field( 'classification', $id );
        $output .= '</a>';
    } else
        $output = '<div id="classification-row-alert">Missing classification!</div>';
    return $output;
}

function the_classification_row( $id ) {
    $fld = get_classification_row( $id );
    if ( !empty( $fld ) )
        echo ( $fld );
}

function get_ctrldoc_meta_table( $id ) {
    $post_status = get_post_status( $id );
    if ( $post_status == "publish" )
        $post_status_txt = $post_status;
    else
        $post_status_txt = '<span title="This document is not published. Please contact the document responsible." style="color:red">' . $post_status . '</span>';
    $def_id_accountable = get_option( 'pms_lypdos_def_id_accountable', 0 );
    $def_id_responsible = get_option( 'pms_lypdos_def_id_responsible', 0 );
    $def_id_doc_state = get_option( 'pms_lypdos_def_id_doc_state', 0 );

    $output = '<table class="doctypemeta"><tr>';
    //insert classification row
    $output .= '<td class="doctypemeta">Document id: <strong>' . $id . '</strong></td>';
    $output .= '<td class="doctypemeta">Doc. state: <strong>' . $post_status_txt . '</strong></td>';
    $output .= '<td class="doc_classification"><strong>' . get_classification_text( $id ) . '</strong></td>';
    $output .= '</tr><tr>';
    if ( is_numeric( $def_id_responsible ) && ( $def_id_responsible != 0 ) )
        $output .= sprintf('<td class="doctypemeta"><a href="%s/?p=' . $def_id_responsible . '">Doc. Responsible:</a> <strong>' . get_field( 'document_responsible', $id ) . '</strong></td>', site_url() );
    else
        $output .= '<td class="doctypemeta">Doc. Responsible: <strong>' . get_field( 'document_responsible', $id ) . '</strong></td>';

    if ( is_numeric( $def_id_accountable ) && ( $def_id_accountable != 0 ) )
        $output .= sprintf('<td class="doctypemeta"><a href="%s/?p=' . $def_id_accountable . '">Doc. Accountable:</a> <strong>' . get_field( 'document_accountable', $id ) . '</strong></td>', site_url());
    else
        $output .= '<td class="doctypemeta">Doc. Accountable: <strong>' . get_field( 'document_accountable', $id ) . '</strong></td>';
    $output .= '<td class="doctypemeta">';
    $output .= 'Doc. type: ';
    $before = '<strong>';
    $sep = ', ';
    $after = '</strong>';
    $output .= apply_filters( 'the_targetgroups', get_the_term_list( $id, 'doctype', $before, $sep, $after ), $before, $sep, $after, $id );
    $output .= '</td>';
    $output .= '</tr><tr>';
    $output .= '<td></td>';
    $output .= '<td></td>';
    $output .= '<td class="doctypemeta">';
    $output .= 'Category: <strong>';
    $output .= get_the_category_list( ', ' );
    $output .= '</strong></td>';
    $output .= '</tr></table>';
    return $output;
}

function the_ctrldoc_objective( $id ) {
    $fld = get_field( 'doc_objective', $id );
    if ( $fld ) {
        echo ( '<div class = "doc_objective_box"><p>' );
        echo ( '<b>Objective: </b>' . $fld );
        echo ( '</div>' );
    }
}

function the_ctrldoc_principle( $id ) {
    $fld = get_field( 'doc_principle', $id );
    if ( $fld ) {
        echo ( '<div class = "doc_objective_box"><p>' );
        echo ( '<b>Principle: </b>' . $fld );
        echo ( '</div>' );
    }
}

function the_ctrldoc_obj_and_prcpl( $id ) {
    echo get_ctrldoc_obj_and_prcpl( $id );
}

function get_ctrldoc_obj_and_prcpl( $id ) {
    $fld_obj = get_field( 'doc_objective', $id );
    $fld_prcpl = get_field( 'doc_principle', $id );
    $output = '';
    if ( $fld_obj ) {
        $output .= '<div class = "doc_objective_box"><p>';
        $output .= '<b>Objective: </b>' . $fld_obj;
        if ( !$fld_prcpl ) {
            $output .= '</p></div>';
//echo ( '<div class="clear"></div>' );
        } else
            $output .= '</p>';
    }

    if ( $fld_prcpl ) {
        if ( !$fld_obj ) {
            $output .= '<div class = "doc_objective_box"><p>';
        } else
            $output .= '<p>';
        $output .= '<b>Principle: </b>' . $fld_prcpl;
        $output .= '</div>';
    }

    if ( ($fld_obj) && ($fld_prcpl) ) {
        $output .= '<div class="clear25"></div>';
    }

    return $output;
}

function has_ctrldoc_references( $id ) {
    return ( FALSE != get_field( 'external_references', $id ) );
}

function the_ctrldoc_ext_references_box( $id ) {
    echo get_ctrldoc_ext_references_box( $id );
}

function get_ctrldoc_ext_references_box( $id ) {
    $pst = get_post( $id );
    $retval = '';
    if ( $pst ) {
        $fld = get_field( 'external_references', $pst->ID );
        if ( $fld ) {
            $retval .= '<div class="sub_services_full_box">';
            $retval .= $fld;
            $retval .= '</div>';
        } else
            $retval = '';
    }
    return $retval;
}

/* * *************************************************************************************************** */
// Register Sidebars
/* * *************************************************************************************************** */

add_action( 'widgets_init', 'pams_ctrldoc_register_sidebars' );

function pams_ctrldoc_register_sidebars() {

    register_sidebar( array(
        'name' => __( 'Controlled Doc Sidebar', 'nimbus' ),
        'id' => 'sidebar_ctrl_doc',
        'description' => __( 'Widgets in this area will be displayed in the sidebar for Controlled Documents.', 'nimbus' ),
        'before_widget' => '<div class="sidebar_widget sidebar sidebar_editable widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>'
    ) );

    register_sidebar( array(
        'name' => __( 'Definition Sidebar', 'nimbus' ),
        'id' => 'sidebar_definition',
        'description' => __( 'Widgets in this area will be displayed in the sidebar for Definitions', 'nimbus' ),
        'before_widget' => '<div class="sidebar_widget sidebar sidebar_editable widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>'
    ) );

    register_sidebar( array(
        'name' => __( 'Service Sidebar', 'nimbus' ),
        'id' => 'sidebar_service',
        'description' => __( 'Widgets in this area will be shown in sidebar for Services.', 'nimbus' ),
        'before_widget' => '<div class="footer_widget sidebar sidebar_editable widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>'
    ) );

    register_sidebar( array(
        'name' => __( 'Archive sidebar', 'nimbus' ),
        'id' => 'sidebar_archive',
        'description' => __( 'Widgets in this area will be shown in the sidebar for archive listings.', 'nimbus' ),
        'before_widget' => '<div class="footer_widget sidebar sidebar_editable widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>'
    ) );

    register_sidebar( array(
        'name' => __( 'PAMS default sidebar', 'nimbus' ),
        'id' => 'sidebar_default',
        'description' => __( 'Widgets in this area will be shown in the sidebar if nothing else is selected.', 'nimbus' ),
        'before_widget' => '<div class="footer_widget sidebar sidebar_editable widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>'
    ) );
//
//    register_sidebar(array(
//        'name' => __('Footer Right', 'nimbus'),
//        'id' => 'footer-right',
//        'description' => __('Widgets in this area will be shown in the right footer column.', 'nimbus'),
//        'before_widget' => '<div class="footer_widget sidebar sidebar_editable widget %2$s">',
//        'after_widget' => '</div>',
//        'before_title' => '<h3 class="widgettitle">',
//        'after_title' => '</h3>'
//    ));
//
//    register_sidebar(array(
//        'name' => __('Frontpage Right', 'nimbus'),
//        'id' => 'frontpage-right',
//        'description' => __('Widgets in this area will be shown on the right side of the frontpage.', 'nimbus'),
//        'before_widget' => '<div class="front_right_widget sidebar sidebar_editable widget %2$s">',
//        'after_widget' => '</div>',
//        'before_title' => '<h3 class="widgettitle">',
//        'after_title' => '</h3>'
//    ));
}

/* -----------------------------------------
  Check if a page has any children / subpages
  ----------------------------------------- */

//function has_children($post_id) {
//    $children = get_pages(array ( 'child_of' => $post_id ) );
//    print_r(count($children));
//    print_r($post_id);
//    if (count($children) != 0) {
//        return true;
//    } // Has Children
//    else {
//        return false;
//    } // No children
//}
//function show_page_children_list($id) {
//    global $post;
//    echo ( '<ul style="list-style-type: none">' );
//    $children = get_pages(array ( 'child_of' => $post_id ) );
//    echo $children;
//    echo ( wp_list_pages('child_of=' . $id . '&title_li=&depth=1&echo=0') );
//    echo ( '</ul>' );
//    return $return;
//}

function the_ctrldoc_children_box( $id = '' ) {
    echo get_ctrldoc_children_box( $id );
}

function get_ctrldoc_children_box( $id = '' ) {
    $output = '';
    $sWalker = new Pams_Ctrl_doc_Walker();
    if ( !$id ) {
        //$children = wp_list_pages( 'sort_column=post_name&echo=0&post_type=ctrl_doc&title_li=' );
        $children = wp_list_pages( array( 'post_type' => 'ctrl_doc', 'echo' => 0, 'title_li' => null, 'walker' => $sWalker, 'sort_column' => 'post_name', 'sort_order' => 'ASC' ) );
        if ( $children ) {
            $output .= '<h3>Document index</h3>';
            $output .= '<div id="page_content_editable" class="editable span8">';
            $output .= $children;
            $output .= '</div>';
        }
    } else {
        //$children = wp_list_pages( 'child_of=' . $id . '&echo=0&post_type=ctrl_doc&title_li=' );
        $children = wp_list_pages( array( 'post_type' => 'ctrl_doc', 'echo' => 0, 'title_li' => null, 'walker' => $sWalker, 'sort_column' => 'post_name', 'sort_order' => 'ASC', 'child_of' => $id ) );
        if ( $children ) {
            $output .= '<h3>Child pages</h3>';
            $output .= '<div class="child_page_listing_box">';
            $output .= $children;
            $output .= '</div>';
        }
    }
    return $output;
}

function the_ctrldoc_list_children_with_excerpt( $id ) {
    $args = array(
//'post__not_in' => array($id),
        'post_parent' => $id,
        'post_type' => 'ctrl_doc',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'ignore_sticky_posts' => 1,
        'orderby' => 'title',
        'order' => 'ASC',
    );
    $my_query = null;
    $my_query = new WP_Query( $args );
    if ( $my_query->have_posts() ) {
        while ( $my_query->have_posts() ) : $my_query->the_post();
            ?>
            <p><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></p>
            <?php
            the_excerpt();
        endwhile;
    }
    wp_reset_query();  // Restore global post data stomped by the_post().
}

function show_ctrldoc_list_func( $atts = NULL, $content = '' ) {
//if ( $atts ) extract( shortcode_atts( array( 'title' => '' ), $atts ) );
    the_ctrldoc_children_box( '' );
    /* $args = array(
      'post_type' => 'ctrl_doc',
      'orderby' => 'name',
      'order' => 'ASC',
      //'nopaging' => 'true',
      'post_status' => 'publish',
      'posts_per_page' => -1,
      'ignore_sticky_posts' => 1,
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
      endwhile;
      wp_reset_postdata(); // reset the query */
}

add_shortcode( 'pams_show_ctrldoc_list', 'show_ctrldoc_list_func' );

add_filter( 'default_content', 'custom_editor_content' );

function custom_editor_content( $content ) {
    global $current_screen;
    if ( $current_screen->post_type == 'ctrl_doc' ) {
        $content = ' '
                . '// TEMPLATE FOR CTRL-DOCS'
                . ''
                . ' ';
    } elseif ( $current_screen->post_type == 'service' ) {
        $content = '

                // TEMPLATE FOR SERVICES TBD

            ';
    } elseif ( $current_screen->post_type == 'definition' ) {
        $content = '

                // TEMPLATE FOR DEFINITIONS TBD

            ';
    }
    return $content;
}

function get_stakeholders( $before = '<ul>', $sep1 = '<li>', $sep2 = '</li>', $sep3 = ' | ', $after = '</ul>' ) {
    $values = get_field( 'stakeholders' );
    $retval = '';
    if ( $values ) {
        $retval = $before;

        foreach ( $values as $value ) {
            $retval .= $sep1;
//$retval .= $value[ 'display_name' ];
//$link = get_author_posts_url( $value['ID'] ); //get the url

            $display_name = $value[ 'display_name' ];
            $email = $value[ 'user_email' ];
//$retval .= sprintf( '<a href="%s">%s</a>', $link, $display_name ); //create a link for each author
            $retval .= sprintf( '%s %s (%s)', $display_name, $sep3, $email );
            $retval .= $sep2;
        }

        $retval .= $after;
    }
    return $retval;
}

function the_stakeholders() {
    echo get_stakeholders();
}

function pms_ctrldoc_display_settings() {
//CTRL_DOC settings
    $ctrl_doc_show_stakeholders = (get_option( 'pms_lypdos_ctrl_doc_show_stakeholders' ) == 'enabled') ? 'checked' : '';
    $ctrl_doc_show_clas = (get_option( 'pms_lypdos_ctrl_doc_show_clas' ) == 'enabled') ? 'checked' : '';
    $ctrl_doc_show_child = (get_option( 'pms_lypdos_ctrl_doc_show_child' ) == 'enabled') ? 'checked' : '';
    $ctrl_doc_show_metabox = (get_option( 'pms_lypdos_ctrl_doc_show_metabox' ) == 'enabled') ? 'checked' : '';
    $ctrl_doc_show_revisions = (get_option( 'pms_lypdos_ctrl_doc_show_revisions' ) == 'enabled') ? 'checked' : '';
    $ctrl_doc_show_references = (get_option( 'pms_lypdos_ctrl_doc_show_references' ) == 'enabled') ? 'checked' : '';
    $ctrl_doc_show_activities = (get_option( 'pms_lypdos_ctrl_doc_show_activities' ) == 'enabled') ? 'checked' : '';

//$ctrl_doc_show_rel  = get_option('pms_lypdos_ctrl_doc_show_rel');

    $html = '<div class="wrap">

            <form method="post" name="options" action="options.php">

            <h2>PAMS LYPDOS settings</h2>' . wp_nonce_field( 'update-options' ) . '
            <h3>Controlled documents</h3>
            <table width="100%" cellpadding="10" class="form-table">
                <tr>
                    <td align="left" scope="row" width="200px">
                        <label>Show stakeholders: </label>
                    </td>
                    <td width="50px">
                        <input type="checkbox" ' . $ctrl_doc_show_stakeholders . ' name="pms_lypdos_ctrl_doc_show_stakeholders" value="enabled"/>
                    </td> 
                    <td>Show stakeholders in sidebar if activated.
                    </td>
                </tr>
                <tr>
                    <td align="left" scope="row">
                        <label>Show classification label: </label>
                   </td>
                    <td>
                        <input type="checkbox" ' . $ctrl_doc_show_clas . ' name="pms_lypdos_ctrl_doc_show_clas" value="enabled"/>
                    </td> 
                    <td>
                    </td>
                </tr>
                <tr>
                    <td align="left" scope="row">
                    <label>Show child documents: </label>
                    </td>
                    <td>
                        <input type="checkbox" ' . $ctrl_doc_show_child . ' name="pms_lypdos_ctrl_doc_show_child" value="enabled"/>
                    </td> 
                    <td>
                    </td>
                </tr>            
                <tr>
                    <td align="left" scope="row">
                    <label>Show meta information: </label>
                    </td>
                    <td>
                        <input type="checkbox" ' . $ctrl_doc_show_metabox . ' name="pms_lypdos_ctrl_doc_show_metabox" value="enabled"/>
                    </td> 
                    <td>
                    </td>
                </tr>            
                <tr>
                    <td align="left" scope="row">
                    <label>Show revisions: </label>
                    </td>
                    <td>
                        <input type="checkbox" ' . $ctrl_doc_show_revisions . ' name="pms_lypdos_ctrl_doc_show_revisions" value="enabled" />
                    </td> 
                    <td>
                    </td>
                </tr>            
                <tr>
                    <td align="left" scope="row">
                    <label>Show references: </label>
                    </td>
                    <td>
                        <input type="checkbox" ' . $ctrl_doc_show_references . ' name="pms_lypdos_ctrl_doc_show_references" value="enabled" />
                    </td> 
                    <td>
                    </td>
                </tr>            
                <tr>
                    <td align="left" scope="row">
                    <label>Show activities: </label>
                    </td>
                    <td>
                        <input type="checkbox" ' . $ctrl_doc_show_activities . ' name="pms_lypdos_ctrl_doc_show_activities" value="enabled" />
                    </td>
                    <td>Activities will appear just below the document meta data bar at the top of the document. Alternatively, use shortcode [pams_show_activities] to display activities anywhere in a document.
                    </td>
                </tr>            
                </table>
            <p class="submit">
                <input type="hidden" name="action" value="update" />  
                <input type="hidden" name="page_options" value="pms_lypdos_ctrl_doc_show_stakeholders,pms_lypdos_ctrl_doc_show_clas,pms_lypdos_ctrl_doc_show_child,pms_lypdos_ctrl_doc_show_metabox,pms_lypdos_ctrl_doc_show_revisions,pms_lypdos_ctrl_doc_show_references,pms_lypdos_ctrl_doc_show_activities" /> 
                <input type="submit" name="Submit" value="Update" />
            </p>
            </form>

        </div>';
    echo $html;
//echo 'Metabox' . $ctrl_doc_show_metabox;
}

function the_activities() {
    echo ( get_the_activities() );
}

function get_the_activities( $atts = NULL, $content = '' ) {
    $activity_header_title = get_option( pms_lypdos_activity_header_title, 'Activities' );
    extract( shortcode_atts( array( 'title' => $activity_header_title ), $atts ) );
    global $post;
    $post_meta_data = get_post_custom( $post->ID );

    $custom_repeatable = @unserialize( $post_meta_data[ 'activity_repeatable' ][ 0 ] );
// return false is no actvities are present
    if ( empty( $custom_repeatable[ 0 ][ activity ] ) ) {
        return FALSE;
    }

    $retval = '';
    $retval .= '<h2>' . $title . '</h2>';
    if ( !empty( $content ) ) {
        $retval .= '<p>' . $content . '</p>';
    }
    $retval .= ( '<div class="procedure">' );
    $a_count = 0;
    foreach ( $custom_repeatable as $activity ) {
        $retval .= ( '<div class="activity">' );
        $act_txt_class = 'activity_text';

        if ( $a_count == 0 )
            $act_txt_class = 'activity_text_first';

        if ( empty( $activity[ 'link' ] ) )
            $retval .= sprintf( '<div class="%s">%.40s', $act_txt_class, $activity[ 'activity' ] );
        else {
            $retval .= sprintf( '<div class="%s"><a title="test" href="%s">%.40s</a>', $act_txt_class, $activity[ 'link' ], $activity[ 'activity' ] );
        }

        if ( !empty( $activity[ 'responsible' ] ) ) {
            $retval .= ( '<div class="activity_responsible">' . $activity[ 'responsible' ] . '</div>' );
        }
        $retval .= ( '</div></div>' );
        $a_count++;
    }
    $retval .= ( '</div>' );
    return $retval;
}

function show_the_activities_func( $atts = NULL, $content = '' ) {
    return get_the_activities( $atts, $content );
}

add_shortcode( 'pams_show_activities', 'show_the_activities_func' );

add_filter( 'the_content', 'insert_ctrl_doc_content_special' );

function insert_ctrl_doc_content_special( $content ) {
    global $post;
    $prep_txt = '';
    if ( is_single() && ( $post->post_type == 'ctrl_doc') ) {
        if ( 'enabled' == get_option( 'pms_lypdos_ctrl_doc_show_metabox', 'enabled' ) ) {
            $prep_txt .= get_the_date_bar( $post->ID );
            $prep_txt .= get_ctrldoc_meta_table( $post->ID );
            //$content = $prep_txt . $content;
        }
        if ( 'enabled' == get_option( 'pms_lypdos_ctrl_doc_show_activities', 'enabled' ) ) {
            $prep_txt .= get_the_activities();
        }
        //$content = $prep_txt . $content;

        $content = $prep_txt . get_ctrldoc_obj_and_prcpl( $post->ID ) . $content;
//Show children if any
        if ( 'enabled' == get_option( 'pms_lypdos_ctrl_doc_show_child', 'enabled' ) ) {
            $append_txt = get_ctrldoc_children_box( $post->ID );
            $content .= $append_txt;
        }
//Show references
        if ( 'enabled' == get_option( 'pms_lypdos_ctrl_doc_show_references', 'enabled' ) ) {
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
        if ( 'enabled' == get_option( 'pms_lypdos_ctrl_doc_show_stakeholders', 'enabled' ) ) {
            $append_txt = '<div id="print-only">';
            $append_txt .= '<h3>Stakeholders</h3>';
            $append_txt .= get_stakeholders();
            $append_txt .= '</div>';
            $content .= $append_txt;
        }

//Show tags is any            
        if ( has_tag() ) {
            $append_txt = '<div id="tags_wrap">';
            $append_txt .= get_the_tag_list( 'TAGS: ', ', ', '' );
            $append_txt .= '</div>';
            $content .= $append_txt;
        }

        //echo '</div>';
//Show revisions if setting is TRUE


        if ( 'enabled' == get_option( 'pms_lypdos_ctrl_doc_show_revisions', 'enabled' ) ) {
//            $append_txt = pams_post_revision_title_expanded( $post->ID );
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
