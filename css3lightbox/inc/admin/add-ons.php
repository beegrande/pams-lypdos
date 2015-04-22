<?php
/**
 * Admin Add-ons
 *
 * @package     css3lightbox Add-on
 * @subpackage  admin/add-ons
 * @copyright   Copyright (c) 2014, Rene Hermenau
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.5
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add-ons
 *
 * Renders the add-ons content.
 *
 * @since 1.1.8
 * @return void
 */
function css3lightbox_add_ons_page() {
	ob_start(); ?>
	<div class="wrap" id="css3-add-ons">
		<h2>
			<?php _e( 'Add Ons for css3lightbox', 'css3lightbox' ); ?>
			&nbsp;&mdash;&nbsp;<a href="http://www.wpmarketplace.net" class="button-primary" title="<?php _e( 'Visit Website', 'wpmarketplace' ); ?>" target="_blank"><?php _e( 'See Details', 'wpmarketplace' ); ?></a>
		</h2>
		<p><?php _e( 'These add-ons extend the functionality of css3lightbox.', 'wpmarketplace' ); ?></p>
		<?php echo css3lightbox_add_ons_get_feed(); ?>
	</div>
	<?php
	echo ob_get_clean();
}

/**
 * Add-ons Get Feed
 *
 * Gets the add-ons page feed.
 *
 * @since 1.1.8
 * @return void
 */
function css3lightbox_add_ons_get_feed() {
	if ( false === ( $cache = get_transient( 'css3lightbox_add_ons_feed' ) ) ) {
		$feed = wp_remote_get( 'http://www.wpmarketplace.net/?feed=addons', array( 'sslverify' => false ) );
		if ( ! is_wp_error( $feed ) ) {
			if ( isset( $feed['body'] ) && strlen( $feed['body'] ) > 0 ) {
				$cache = wp_remote_retrieve_body( $feed );
				set_transient( 'css3lightbox_add_ons_feed', $cache, 1 );
			}
		} else {
			$cache = '<div class="error"><p>' . __( 'There was an error retrieving the WPMarketplace addon list from the server. Please try again later.', 'wpmarketplace' ) . '
                                   <br>Visit instead the WPMaarketplace Addon Website <a href="http://www.wpmarketplace.net" class="button-primary" title="WPMarkketplace Add ons" target="_blank"> Get Add-Ons  </a></div>';
		}
	}
	return $cache;
}