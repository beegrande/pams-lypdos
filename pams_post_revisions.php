<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function pmr_fields( $fields ) {

	$fields['document_owner'] = 'document_owner';
	return $fields;

}

function pmr_field( $value, $field ) {

	global $revision;
	return get_metadata( 'ctrl_doc', $revision->ID, $field, true );

}

function pmr_restore_revision( $post_id, $revision_id ) {

	$post     = get_post( $post_id );
	$revision = get_post( $revision_id );
	$meta     = get_metadata( 'ctrl_doc', $revision->ID, 'foo', true );

	if ( false === $meta )
		delete_post_meta( $post_id, 'document_owner' );
	else
		update_post_meta( $post_id, 'document_owner', $meta );

}

function pmr_save_post( $post_id, $post ) {

	if ( $parent_id = wp_is_post_revision( $post_id ) ) {

		$parent = get_post( $parent_id );
		$meta = get_post_meta( $parent->ID, 'document_owner', true );

		if ( false !== $meta )
			add_metadata( 'ctrl_doc', $post_id, 'document_owner', $meta );

	}

}

add_filter( '_wp_post_revision_field_ctrl_doc', 'pmr_field', 10, 2 );
add_action( 'save_post',                        'pmr_save_post', 10, 2 );
add_action( 'wp_restore_post_revision',         'pmr_restore_revision', 10, 2 );
add_filter( '_wp_post_revision_fields',         'pmr_fields' );


/**
 * Retrieve formatted date timestamp of a revision (linked to that revisions's page).
 *
 * @since 3.6.0
 *
 * @param int|object $revision Revision ID or revision object.
 * @param bool $link Optional, default is true. Link to revisions's page?
 * @return string gravatar, user, i18n formatted datetimestamp or localized 'Current Revision'.
 */
function pams_post_revision_title_expanded( $revision, $link = false ) {
    if ( !$revision = get_post( $revision ) )
        return $revision;

    if ( !in_array( $revision->post_type, array( 'post', 'page', 'revision' ) ) )
        return false;

    $author = get_the_author_meta( 'display_name', $revision->post_author );
    /* translators: revision date format, see http://php.net/date */
    $datef = _x( 'j F, Y @ G:i:s', 'revision date format' );

    //$gravatar = get_avatar( $revision->post_author, 24 );

    $date = date_i18n( $datef, strtotime( $revision->post_modified ) );
    if ( $link && current_user_can( 'edit_post', $revision->ID ) && $link = get_edit_post_link( $revision->ID ) )
        $date = "<a href='$link'>$date</a>";

    $revision_date = sprintf(
            /* translators: post revision title: 1: author avatar, 2: author name, 3: time ago, 4: date */
            _x( '%1$s %2$s ago (%3$s)', 'post revision title' ), $author, human_time_diff( strtotime( $revision->post_modified ), current_time( 'timestamp' ) ), $date
    );

    $autosavef = __( '%1$s [Autosave]' );
    $currentf = __( '%1$s [Current Revision]' );

    if ( !wp_is_post_revision( $revision ) )
        $revision_date = sprintf( $currentf, $revision_date );
    elseif ( wp_is_post_autosave( $revision ) )
        $revision_date = sprintf( $autosavef, $revision_date );

    return $revision_date;
}

/**
 * Display list of a post's revisions.
 *
 * Can output either a UL with edit links or a TABLE with diff interface, and
 * restore action links.
 *
 * @since 2.6.0
 *
 * @param int|WP_Post $post_id Optional. Post ID or WP_Post object. Default is global $post.
 * @param string      $type    'all' (default), 'revision' or 'autosave'
 * @return null
 */
function pams_get_list_post_revisions( $post_id = 0, $type = 'all' ) {
    if ( !$post = get_post( $post_id ) )
        return '';

    // $args array with (parent, format, right, left, type) deprecated since 3.6
    if ( is_array( $type ) ) {
        $type = !empty( $type[ 'type' ] ) ? $type[ 'type' ] : $type;
        _deprecated_argument( __FUNCTION__, '3.6' );
    }

    if ( !$revisions = wp_get_post_revisions( $post->ID ) )
        return;

    $rows = '';
    foreach ( $revisions as $revision ) {
        if ( !current_user_can( 'read_post', $revision->ID ) )
            continue;

        $is_autosave = wp_is_post_autosave( $revision );
        if ( ( 'revision' === $type && $is_autosave ) || ( 'autosave' === $type && !$is_autosave ) )
            continue;

        $rows .= "\t<li>" . pams_post_revision_title_expanded( $revision ) . "</li>\n";
    }

    $output = "<ul class='post-revisions'>\n";
    $output .= $rows;
    $output = "</ul>";
    return $output;
}
