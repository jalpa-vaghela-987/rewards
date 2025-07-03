<?php
/**
 * Admin theme page
 *
 * @package Esotera
 */

// Theme particulars
require_once( get_template_directory() . "/admin/defaults.php" );
require_once( get_template_directory() . "/admin/options.php" );
require_once( get_template_directory() . "/includes/tgmpa.php" );

// Custom CSS Styles for customizer
require_once( get_template_directory() . "/includes/custom-styles.php" );

// load up theme options
$cryout_theme_settings = apply_filters( 'esotera_theme_structure_array', $esotera_big );
$cryout_theme_options = esotera_get_theme_options();
$cryout_theme_defaults = esotera_get_option_defaults();

// Get the theme options and make sure defaults are used if no values are set
//if ( ! function_exists( 'esotera_get_theme_options' ) ):
function esotera_get_theme_options() {
	$options = wp_parse_args(
		get_option( 'esotera_settings', array() ),
		esotera_get_option_defaults()
	);
	$options = cryout_maybe_migrate_options( $options );
	return apply_filters( 'esotera_theme_options_array', $options );
} // esotera_get_theme_options()
//endif;

//if ( ! function_exists( 'esotera_get_theme_structure' ) ):
function esotera_get_theme_structure() {
	global $esotera_big;
	return apply_filters( 'esotera_theme_structure_array', $esotera_big );
} // esotera_get_theme_structure()
//endif;

// backwards compatibility filter for some values that changed format
// this needs to be applied to the options array using WordPress' 'option_{$option}' filter
/* not currently used in Esotera
function esotera_options_back_compat( $options ){
	return $options;
} //
add_filter( 'option_esotera_settings', 'esotera_options_back_compat' ); */

// Hooks/Filters
add_action( 'admin_menu', 'esotera_add_page_fn' );

// Add admin scripts
function esotera_admin_scripts( $hook ) {
	global $esotera_page;
	if( $esotera_page != $hook ) {
        	return;
	}

	wp_enqueue_style( 'wp-jquery-ui-dialog' );
	wp_enqueue_style( 'esotera-admin-style', esc_url( get_template_directory_uri() . '/admin/css/admin.css' ), NULL, _CRYOUT_THEME_VERSION );
	wp_enqueue_script( 'esotera-admin-js', esc_url( get_template_directory_uri() . '/admin/js/admin.js' ), array('jquery-ui-dialog'), _CRYOUT_THEME_VERSION );
	$js_admin_options = array(
		'reset_confirmation' => esc_html( __( 'Reset Esotera Settings to Defaults?', 'esotera' ) ),
	);
	wp_localize_script( 'esotera-admin-js', 'cryout_admin_settings', $js_admin_options );
}

// Create admin subpages
function esotera_add_page_fn() {
	global $esotera_page;
	$esotera_page = add_theme_page( __( 'Esotera Theme', 'esotera' ), __( 'Esotera Theme', 'esotera' ), 'edit_theme_options', 'about-esotera-theme', 'esotera_page_fn' );
	add_action( 'admin_enqueue_scripts', 'esotera_admin_scripts' );
} // esotera_add_page_fn()

// Display the admin options page

function esotera_page_fn() {

	if (!current_user_can('edit_theme_options'))  {
		wp_die( __( 'Sorry, but you do not have sufficient permissions to access this page.', 'esotera') );
	}

?>

<div class="wrap" id="main-page"><!-- Admin wrap page -->
	<div id="lefty">
	<?php
	// Reset settings to defaults if the reset button has been pressed
	if ( isset( $_POST['cryout_reset_defaults'] ) ) {
		delete_option( 'esotera_settings' ); ?>
		<div class="updated fade">
			<p><?php _e('Esotera settings have been reset successfully.', 'esotera') ?></p>
		</div> <?php
	} ?>

		<div id="admin_header">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/admin/images/logo-about-top.png' ) ?>" />
			<span class="version">
				<?php echo wp_kses_post( apply_filters( 'cryout_admin_version', sprintf( __( 'Esotera Theme v%1$s by %2$s', 'esotera' ),
					_CRYOUT_THEME_VERSION,
					'<a href="https://www.cryoutcreations.eu" target="_blank">Cryout Creations</a>'
				) ) ); ?><br>
				<?php do_action( 'cryout_admin_version' ); ?>
			</span>
		</div>

		<div id="admin_links">
			<a href="https://www.cryoutcreations.eu/wordpress-themes/esotera" target="_blank"><?php _e( 'Esotera Homepage', 'esotera' ) ?></a>
			<a href="https://www.cryoutcreations.eu/forums/f/wordpress/esotera" target="_blank"><?php _e( 'Theme Support', 'esotera' ) ?></a>
			<a class="blue-button" href="https://www.cryoutcreations.eu/wordpress-themes/esotera#cryout-comparison-section" target="_blank"><?php _e( 'Upgrade to PLUS', 'esotera' ) ?></a>
		</div>

		<div id="description">
			<div id="description-inside">
			<?php
				$theme = wp_get_theme();
				echo wp_kses_post( apply_filters( 'cryout_theme_description', esc_html( $theme->get( 'Description' ) ) ) );
			?>
			</div>
		</div>

		<div id="customizer-container">
			<a class="button" href="customize.php" id="customizer"> <?php _e( 'Customize', 'esotera' ); ?> </a>
			<form action="" method="post" id="defaults" id="defaults">
				<input type="hidden" name="cryout_reset_defaults" value="true" />
				<input type="submit" class="button" id="cryout_reset_defaults" value="<?php _e( 'Reset to Defaults', 'esotera' ); ?>" />
			</form>
		</div>

	</div><!--lefty -->


	<div id="righty">
		<div id="cryout-donate" class="postbox donate">

			<h3 class="hndle"><?php _e( 'Upgrade to Plus', 'esotera' ); ?></h3>
			<div class="inside">
				<p><?php _e('Find out what features you\'re missing out on and how the Plus version of Esotera can improve your site.', 'esotera'); ?></p>
				<img src="<?php echo esc_url( get_template_directory_uri() . '/admin/images/features.png' ) ?>" />
				<a class="button" href="https://www.cryoutcreations.eu/wordpress-themes/esotera" target="_blank" style="display: block;"><?php _e( 'Upgrade to Plus', 'esotera' ); ?></a>

			</div><!-- inside -->

		</div><!-- donate -->

	</div><!--  righty -->
</div><!--  wrap -->

<?php
} // esotera_page_fn()
