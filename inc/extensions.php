<?php
/**
 * Custom Post Type UI Extensions.
 * @package    CPTUI
 * @subpackage Extensions
 * @author     WebDevStudios
 * @since      1.3.4
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register our tabs for the Extensions screen.
 *
 * @since 1.3.4
 * @internal
 *
 * @param array  $tabs         Array of tabs to display.
 * @param string $current_page Current page being shown.
 *
 * @return array Amended array of tabs to show.
 */
function cptui_extensions_tabs( $tabs = array(), $current_page = '' ) {

	if ( 'extensions' == $current_page ) {
		$classes    = array( 'nav-tab' );

		$tabs['page_title'] = get_admin_page_title();
		$tabs['tabs']       = array();
		// Start out with our basic "Add new" tab.
		$tabs['tabs']['cptui'] = array(
			'text'          => __( 'CPTUI Extensions', 'custom-post-type-ui' ),
			'classes'       => $classes,
			'url'           => '#',
			'aria-selected' => 'false',
		);

		$action = cptui_get_current_action();
		if ( empty( $action ) ) {
			$tabs['tabs']['cptui']['classes'][]     = 'nav-tab-active';
			$tabs['tabs']['cptui']['aria-selected'] = 'true';
		}

		if ( ! empty( $action ) ) {
			$classes[] = 'nav-tab-active';
		}

		$tabs['tabs']['pluginize'] = array(
			'text'          => __( 'Pluginize Plugins', 'custom-post-type-ui' ),
			'classes'       => $classes,
			'url'           => '#',
			'aria-selected' => ( ! empty( $action ) ) ? 'true' : 'false',
		);
		// esc_url( add_query_arg( array( 'action' => 'edit' ), cptui_admin_url( 'admin.php?page=cptui_manage_' . $current_page ) ) )
	}

	return $tabs;
}

add_filter( 'cptui_get_tabs', 'cptui_extensions_tabs', 10, 2 );

function cptui_extensions() {
	?>
	<div class="wrap">
		<?php
		/**
		 * Fires right inside the wrap div for the extensions screen.
		 *
		 * @since 1.3.4
		 */
		do_action( 'cptui_inside_extensions_wrap' );
		?>

		<?php cptui_settings_tab_menu( 'extensions' );

		/**
		* Fires below the output for the tab menu on the extensions screen.
		*
		* @since 1.3.4
		*/
		do_action( 'cptui_below_extensions_tab_menu' );

		/**
		 * Fires before the listing of extension data.
		 *
		 * @since 1.3.4
		 */
		do_action( 'cptui_before_extensions_listing' );

		/**
		 * Fires after the listing of extension data.
		 *
		 * @since 1.3.4
		 */
		do_action( 'cptui_after_extensions_listing' );
		?>

	</div>

	<?php
}
