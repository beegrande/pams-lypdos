<?php
/*
  Plugin Name: pams-lypdos
  Plugin URI: http://pams.dk
  Description: Lightweight, yet powerful documentation system
  Version: 0.3
  Author: Bjarke Nielsen
  Author URI: http://pams.dk
  License: GPL
 */

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

//include_once( plugin_dir_path( __file__) .'options/pams_options_arr.php');
include_once( 'pams_widgets.php' );
include_once( 'pms_lib.php' );
include_once( 'pams_ctrl_documents.php' );
include_once( 'pams_service_catalogue.php' );
include_once( 'pams_definitions.php' );
include_once( 'pams_references.php' );
include_once( 'pams_floating_boxes.php' );
include_once( 'metaboxes/meta_box.php' );
include_once( 'pams-tablesorter/pams-tablesorter.php' );
include_once( 'pams-masonry/pams-masonry.php' );
include_once( 'pams-fotorama/pams-fotorama.php' );
define( 'ACF_LITE', true );
include_once('advanced-custom-fields/acf.php');
include_once( 'ACF_fields.php' );
include_once 'css3lightbox/css3lightbox.php';
//include_once( 'pams_post_revisions' );
define( 'PMS_LYPDOS_VERSION', '3.0.0' );
define( 'PMS_LYPDOS__MINIMUM_WP_VERSION', '3.9' );
define( 'PMS_LYPDOS__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'PMS_LYPDOS__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

function pms_lypdos_activation() {
    
}

register_activation_hook( __FILE__, 'pms_lypdos_activation' );

function pms_lypdos_deactivation() {
    
}

register_deactivation_hook( __FILE__, 'pms_lypdos_deactivation' );

add_action( 'admin_menu', 'pms_lypdos_plugin_settings' );

function pms_lypdos_plugin_settings() {
    //creecho ate new top-level menu
    add_menu_page( 'LYPDOS Settings', 'LYPDOS Settings', 'manage_options', 'pms_lypdos_settings', 'pms_lypdos_display_settings' );
    add_submenu_page( 'pms_lypdos_settings', 'LYPDOS Settings', 'CTRL_DOC settings', 'manage_options', 'pms_ctrldoc_settings', 'pms_ctrldoc_display_settings' );
    add_submenu_page( 'pms_lypdos_settings', 'LYPDOS Settings', 'DEFINITION settings', 'manage_options', 'pms_definition_settings', 'pms_definition_display_settings' );
    add_submenu_page( 'pms_lypdos_settings', 'LYPDOS Settings', 'SERVICE settings', 'manage_options', 'pms_service_settings', 'pms_service_display_settings' );

    //add_menu_page('Page title', 'Top-level menu title', 'manage_options', 'my-top-level-handle', 'my_magic_function');
    //add_submenu_page( 'my-top-level-handle', 'Page title', 'Sub-menu title', 'manage_options', 'my-submenu-handle', 'my_magic_function');
}

function pms_lypdos_display_settings() {
    //Site settings
    $site_title = get_option( 'pms_lypdos_site_title', 'PAMS LYPDOS' );
    $site_description = get_option( 'pms_lypdos_site_description', 'A lightweight, yet powerful documentation system' );
    $demo_mode = (get_option( 'pms_demo_mode' ) == 'enabled') ? 'checked' : '';
    $def_id_classification = get_option( 'pms_lypdos_def_id_classification', 0 );
    $def_id_accountable = get_option( 'pms_lypdos_def_id_accountable', 0 );
    $def_id_responsible = get_option( 'pms_lypdos_def_id_responsible', 0 );
    $activity_header_title = get_option( 'pms_lypdos_activity_header_title', 'Activities' );
    $def_rev_interval = get_option( 'pms_lypdos_def_rev_interval', '1 year' );
    $slider_on_pages = (get_option( 'pms_slider_on_pages' ) == 'enabled') ? 'checked' : '';
    $cyclone_slide_ID = get_option( 'pms_cyclone_slide_ID', '' );
    $print_header = get_option( 'pms_print_header', 'This is printed from PAMS LYPDOS. Please note that a printed version
can be obsolete. Check the online version "Last edited date" to verify that
this one is the current version' );
    $recent_post_boxes_on_frontpage = (get_option( 'pms_recent_post_boxes_on_frontpage' ) == 'enabled') ? 'checked' : '';
    $recent_post_boxes_on_pages = (get_option( 'pms_recent_post_boxes_on_pages' ) == 'enabled') ? 'checked' : '';
    $recent_post_boxes_title = get_option( 'pms_recent_post_boxes_title', 'Recent posts' );
    $html = '<div class="wrap">

            <form method="post" name="options" action="options.php">

            <h2>PAMS LYPDOS settings</h2>' . wp_nonce_field( 'update-options' ) . '
            <table width="100%" cellpadding="10" class="form-table">
                <tr>
                    <td align="left" scope="row" width="350px">
                    <label style="vertical-align:top">Site Title: </label><input  style="float:right" type="text" name="pms_lypdos_site_title" 
                    value="' . $site_title . '" />

                    </td> 
                    <td style="vertical-align:top">
                    </td>
                </tr>
                <tr>
                    <td align="left" scope="row">
                    <label style="vertical-align:top">Site Description: </label><textarea style="float:right" name="pms_lypdos_site_description" style="width:227px;height:50px;">' . $site_description . '</textarea>
                    </td> 
                    <td style="vertical-align:top">
                    </td>
                </tr>
                <tr>
                    <td align="left" scope="row">
                    <label style="vertical-align:top">Demo mode: </label><input style="float:right" type="checkbox"' . $demo_mode . ' name="pms_demo_mode" 
                    value="enabled"/>

                    </td> 
                    <td style="vertical-align:top">
                    </td>
                </tr> 
                <tr>
                    <td align="left" scope="row">
                    <label style="vertical-align:top">Print header: </label><textarea style="float:right" name="pms_print_header" style="width:250px;height:80px;">' . $print_header . '</textarea>
                    </td> 
                    <td style="vertical-align:top">Enter a header text at the top of each controlled document or service description when printing.
                    </td>
                </tr>
                <tr>
                    <td align="left" scope="row">
                    <label style="vertical-align:top">Slider on pages: </label><input style="float:right" type="checkbox" ' . $slider_on_pages . ' name="pms_slider_on_pages" 
                    value="enabled"/>
                    </td> 
                    <td style="vertical-align:top">If Cyclone Slider plugin is installed, checking this box will show the slider on all pages. Not on Posts, Controlled documents, Services, or Definitions. 
                    </td>
                </tr>                 
                <tr>
                    <td align="left" scope="row">
                    <label style="vertical-align:top">Slideshow ID: </label><input style="float:right" type="text" name="pms_cyclone_slide_ID" 
                    value="' . $cyclone_slide_ID . '" />

                    </td style="vertical-align:top"> 
                    <td>When the slideshow has been defined under slider settings, enter the Slideshow ID here. Please notice, the Cyclone slider plugin must be installed and activated on the checkbox above for this setting to have effect.
                    </td>
                </tr>
                <tr>
                    <td align="left" scope="row">
                    <label style="vertical-align:top">Activity header title: </label><input style="float:right" type="text" name="pms_lypdos_activity_header_title" 
                    value="' . $activity_header_title . '" />

                    </td> 
                    <td style="vertical-align:top">Enter the title for activity flow charts. Default = "Activities".
                    </td>
                </tr>            
                <tr>
                    <td align="left" scope="row">
                    <label style="vertical-align:top">Default revision interval: </label><input style="float:right" type="text" name="pms_lypdos_def_rev_interval" 
                    value="' . $def_rev_interval . '" />

                    </td> 
                    <td style="vertical-align:top">Enter the default revision interval. This setting is overrules by the interval setting on the individual pages. Examples: 1 year, 2 years, 6 months, or 90 days.
                    </td>
                </tr>            
                <tr>
                    <td align="left" scope="row">
                    <label style="vertical-align:top">Show Recent posts on front page: </label><input style="float:right" type="checkbox"' . $recent_post_boxes_on_frontpage . ' name="pms_recent_post_boxes_on_frontpage" 
                    value="enabled"/>

                    </td> 
                    <td style="vertical-align:top">When enabled this will display boxes on the front page below the page content.
                    </td>
                </tr>            
                <tr>
                    <td align="left" scope="row">
                    <label style="vertical-align:top">Show Recent posts on pages: </label><input style="float:right" type="checkbox"' . $recent_post_boxes_on_pages . ' name="pms_recent_post_boxes_on_pages" 
                    value="enabled"/>

                    </td> 
                    <td style="vertical-align:top">When enabled this will display boxes on pages below the page content. Recent Boxes will not show on Posts, Documents, Services, Definitions.
                    </td>
                </tr>            
                <tr>
                    <td align="left" scope="row">
                    <label style="vertical-align:top">Recent posts title: </label><input style="float:right" type="text" name="pms_recent_post_boxes_title" 
                    value="' . $recent_post_boxes_title . '" />

                    </td> 
                    <td style="vertical-align:top">Enter the title for the Recent post boxes. Default = "Recent posts".
                    </td>
                </tr>            
            </table>
            <h3>Predefined definition posts</h3>
            <table width="100%" cellpadding="10" class="form-table">
                <tr>
                    <td align="left" scope="row" width="350px">
                    <label>Classification: </label><input type="text" name="pms_lypdos_def_id_classification" 
                    value="' . $def_id_classification . '" />

                    </td> 
                    <td>Enter document id for "Classification" explanation. The ID is shown in the definition post itself at top row meta box.
                    </td>
                </tr>
                <tr>
                    <td align="left" scope="row">
                    <label>Accountable: </label><input type="text" name="pms_lypdos_def_id_accountable" 
                    value="' . $def_id_accountable . '" />

                    </td> 
                    <td>Enter document id for "Accountable" explanation. The ID is shown in the definition post itself at top row meta box.
                    </td>
                </tr>
                <tr>
                    <td align="left" scope="row">
                    <label>Responsible: </label><input type="text" name="pms_lypdos_def_id_responsible" 
                    value="' . $def_id_responsible . '" />

                    </td> 
                    <td>Enter document id for "Responsible" explanation. The ID is shown in the definition post itself at top row meta box.
                    </td>
                </tr>
                </table>
            
            <p class="submit">
                <input type="hidden" name="action" value="update" />  
                <input type="hidden" name="page_options" value="pms_lypdos_site_title,pms_lypdos_site_description,pms_demo_mode,pms_lypdos_def_id_classification,pms_lypdos_def_id_accountable,pms_lypdos_def_id_responsible,pms_lypdos_activity_header_title,pms_lypdos_def_rev_interval,pms_slider_on_pages,pms_cyclone_slide_ID,pms_print_header,pms_recent_post_boxes_on_frontpage,pms_recent_post_boxes_on_pages,pms_recent_post_boxes_title" /> 
                <input type="submit" name="Submit" value="Update" />
            </p>
            </form>

        </div>';
    echo $html;
    //echo 'Metabox' . $ctrl_doc_show_metabox;
}

$prefix = 'activity_';

/* $fields = array(
  array( // Text Input
  'label' => 'Text Input', // <label>
  'desc' => 'A description for the field.', // description
  'id' => $prefix . 'text', // field id and name
  'type' => 'text' // type of field
  ),
  array( // Repeatable & Sortable Text inputs
  'label' => 'Repeatable', // <label>
  'desc' => 'A description for the field.', // description
  'id' => $prefix . 'repeatable', // field id and name
  'type' => 'repeatable', // type of field
  'sanitizer' => array( // array of sanitizers with matching kets to next array
  'featured' => 'meta_box_santitize_boolean',
  'title' => 'sanitize_text_field',
  'desc' => 'wp_kses_data'
  ),
  'repeatable_fields' => array( // array of fields to be repeated
  'featured' => array(
  'label' => 'Featured?',
  'id' => 'featured',
  'type' => 'checkbox'
  ),
  array( // Text Input
  'label' => 'Activity name', // <label>
  'desc' => 'Give a name to the activity.', // description
  'id' => $prefix . 'text', // field id and name
  'type' => 'text' // type of field
  ),
  'link' => array(
  'label' => 'Link',
  'id' => 'link',
  'type' => 'text' )
  )
  )
  ); */

$fields = array(
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

### Instantiate the class with all required variables

/**
 * Instantiate the class with all variables to create a meta box
 * var $id string meta box id
 * var $title string title
 * var $fields array fields
 * var $page string|array post type to add meta box to
 * var $js bool including javascript or not
 */
$activity_box = new custom_add_meta_box( 'activity_box', 'Activities', $fields, 'ctrl_doc', true );

/*
 * scripts for jquery scroll down functionality
 */

//add_action( 'wp_enqueue_scripts', 'ui_scripts' );
add_action( 'wp_enqueue_scripts', 'tooltip_scripts' );

function ui_scripts() {
    wp_enqueue_script( 'jquery-ui', plugins_url( 'js/jquery-ui.js', __FILE__ ), array( 'jquery' ) );
}

function tooltip_scripts() {
    wp_enqueue_script( 'jquery-tooltip', plugins_url( 'js/jquery-tooltip.js', __FILE__ ), array( 'jquery' ) );
}

/*
 * scripts for custom meta boxes
 */
if ( is_admin() ) {

    add_action( 'admin_enqueue_scripts', 'enqueue_custom_meta_scripts' );

    function enqueue_custom_meta_scripts() {
        wp_register_style( 'jquery-ui-custom', plugins_url( 'metaboxes/css/jqueryui.css', __FILE__ ) );
        wp_enqueue_style( 'jquery-ui-custom' );
        wp_register_style( 'meta_box_css', plugins_url( 'metaboxes/css/meta_box.css', __FILE__ ) );
        wp_enqueue_style( 'meta_box_css' );

//        wp_register_script( 'custom-meta-js', plugins_url( 'metaboxes/js/custom-meta.js', __FILE__ ), array( "jquery" ) );
//        wp_enqueue_script( 'custom-meta-js' );

        wp_register_script( 'meta-scripts-js', plugins_url( 'metaboxes/js/meta-scripts.js', __FILE__ ), array( "jquery" ) );
        wp_enqueue_script( 'meta-scripts-js' );

        //wp_register_script('slidesjs_core', plugins_url('js/jquery.slides.min.js', __FILE__), array("jquery"));
        //wp_enqueue_script( 'jquery' );
//        wp_enqueue_script( 'jquery-ui-datepicker', array( 'jquery' ) );
//        wp_enqueue_script( 'jquery-ui-slider', array( 'jquery' ) );
    }

}

/*
 * Works for Ctrl_Docs only
 */

class Pams_Ctrl_doc_Walker extends Walker_page {

    function start_el( &$output, $page, $depth, $args, $current_page ) {
//        if ( $depth )
//            $indent = str_repeat( "t", $depth );
//        else
//            $indent = '';
        $pams_excerpt = '';
        extract( $args, EXTR_SKIP );
        $pams_excerpt .= pams_get_ctrl_doc_excerpt_box( $page->ID );
        if ( empty( $pams_excerpt ) )
            $pams_excerpt = 'No preview';
        $output .= $indent . '<li><div class="walker-element"><a href="' . get_permalink( $page->ID ) . '" title="' . esc_attr( wp_strip_all_tags( apply_filters( 'the_title', $page->post_title, $page->ID ) ) ) . '">' . apply_filters( 'the_title', $page->post_title, $page->ID ) . '</a><div class="element-summary">' . $pams_excerpt . '</div></div>';

        ////get_the_excerpt( $page->ID );
        //$description = get_post_meta( $page->ID, 'description', true );
//        if ( !empty( $pams_excerpt ) ) {
//            $output .= '<div class="element-summary">' . $pams_excerpt . '</div>';
//        }
    }

}

/*
 * Works for Services only
 */

class Pams_Service_Walker extends Walker_page {

    function start_el( &$output, $page, $depth, $args, $current_page ) {
//        if ( $depth )
//            $indent = str_repeat( "t", $depth );
//        else
//            $indent = '';
        $pams_excerpt = '';
        extract( $args, EXTR_SKIP );
        //$pams_excerpt .= apply_filters( 'the_excerpt', get_post_field( 'post_excerpt', $page->ID ) );
        $pams_excerpt = get_the_service_excerpt( $page->ID );
        $pams_excerpt = 'No preview';
        $output .= '<li><div class="walker-element"><a href="' . get_permalink( $page->ID ) . '" title="' . esc_attr( wp_strip_all_tags( apply_filters( 'the_title', $page->post_title, $page->ID ) ) ) . '">' . apply_filters( 'the_title', $page->post_title, $page->ID ) . '</a><div class="element-summary">' . $pams_excerpt . '</div></div>';

        ////get_the_excerpt( $page->ID );
        //$description = get_post_meta( $page->ID, 'description', true );
//        if ( !empty( $pams_excerpt ) ) {
//            $output .= '<div class="element-summary">' . $pams_excerpt . '</div>';
//        }
    }

}

function wp_trim_all_excerpt( $text ) {
// Creates an excerpt if needed; and shortens the manual excerpt as well
    global $post;
    $raw_excerpt = $text;
    if ( '' == $text ) {
        $text = get_the_content( '' );
        $text = strip_shortcodes( $text );
        $text = apply_filters( 'the_content', $text );
        $text = str_replace( ']]>', ']]&gt;', $text );
    }
    $add_before = '';
    $ttle = get_the_title( $id );
    $add_before = '<h3>' . $ttle . '</h3>';

//Build excerpt add-on
    if ( 'ctrl_doc' == $post->post_type ) {
        $add_before .= get_ctrldoc_obj_and_prcpl( $post->ID );
    }
    if ( 'service' == $post->post_type ) {
//    $add_after = '<h3>Depending services</h3>';
//    $add_after .= get_depending_services( $post->ID );
    }
    if ( 'definition' == $post->post_type ) {
        //$add_on = 'definition';
    }

    $text = strip_tags( $text );
    $text = $add_before . $text . $add_after;
    $excerpt_length = apply_filters( 'excerpt_length', 55 );
    $excerpt_more = apply_filters( 'excerpt_more', ' ' . '[...]' );
    $text = pams_trim_words( $text, $excerpt_length, $excerpt_more ); //since wp3.3

    return apply_filters( 'wp_trim_excerpt', $text, $raw_excerpt ); //since wp3.3
}

remove_filter( 'get_the_excerpt', 'wp_trim_excerpt' );
add_filter( 'get_the_excerpt', 'wp_trim_all_excerpt' );

/**
 * Trims text to a certain number of words.
 *
 * This function is localized. For languages that count 'words' by the individual
 * character (such as East Asian languages), the $num_words argument will apply
 * to the number of individual characters.
 *
 * @since 3.3.0
 *
 * @param string $text Text to trim.
 * @param int $num_words Number of words. Default 55.
 * @param string $more Optional. What to append if $text needs to be trimmed. Default '&hellip;'.
 * @return string Trimmed text.
 */
function pams_trim_words( $text, $num_words = 55, $more = null ) {
    if ( null === $more )
        $more = __( '&hellip;' );
    $original_text = $text;
    //$text = wp_strip_all_tags( $text );
    /* translators: If your word count is based on single characters (East Asian characters),
      enter 'characters'. Otherwise, enter 'words'. Do not translate into your own language. */
    if ( 'characters' == _x( 'words', 'word count: words or characters?' ) && preg_match( '/^utf\-?8$/i', get_option( 'blog_charset' ) ) ) {
        $text = trim( preg_replace( "/[\n\r\t ]+/", ' ', $text ), ' ' );
        preg_match_all( '/./u', $text, $words_array );
        $words_array = array_slice( $words_array[ 0 ], 0, $num_words + 1 );
        $sep = '';
    } else {
        $words_array = preg_split( "/[\n\r\t ]+/", $text, $num_words + 1, PREG_SPLIT_NO_EMPTY );
        $sep = ' ';
    }
    if ( count( $words_array ) > $num_words ) {
        array_pop( $words_array );
        $text = implode( $sep, $words_array );
        $text = $text . $more;
    } else {
        $text = implode( $sep, $words_array );
    }
    /**
     * Filter the text content after words have been trimmed.
     *
     * @since 3.3.0
     *
     * @param string $text          The trimmed text.
     * @param int    $num_words     The number of words to trim the text to. Default 5.
     * @param string $more          An optional string to append to the end of the trimmed text, e.g. &hellip;.
     * @param string $original_text The text before it was trimmed.
     */
    return apply_filters( 'pams_trim_words', $text, $num_words, $more, $original_text );
}

/*
 * Used to get_the_excerpt outside the loop
 */
function pams_get_excerpt_by_id( $id ) {

// Creates an excerpt if needed; and shortens the manual excerpt as well

    $the_post = get_post( $id );

    $text = $the_post->post_excerpt;
    if ( '' == $text ) {
        $text = $the_post->post_content;
        $text = strip_shortcodes( $text );
        //$text = apply_filters( 'the_content', $text );
        $text = str_replace( ']]>', ']]&gt;', $text );
    }
    $add_before = '';
//    $ttle = get_the_title();
//    $add_before = '<h3>' . $ttle . '</h3>';
//Build excerpt add-on
    if ( 'ctrl_doc' == $post->post_type ) {
        $add_before .= get_ctrldoc_obj_and_prcpl( $the_post->ID );
    }
    if ( 'service' == $the_post->post_type ) {
//    $add_after = '<h3>Depending services</h3>';
//    $add_after .= get_depending_services( $post->ID );
    }
    if ( 'definition' == $the_post->post_type ) {
        //$add_on = 'definition';
    }

    $text = strip_tags( $text );
    $text = $add_before . $text . $add_after;
    $excerpt_length = apply_filters( 'excerpt_length', 55 );
    $excerpt_more = apply_filters( 'excerpt_more', ' ' . '[...]' );
    $text = pams_trim_words( $text, $excerpt_length, $excerpt_more ); //since wp3.3

    return $text;
//return apply_filters( 'wp_trim_excerpt', $text, $raw_excerpt ); //since wp3.3
}
