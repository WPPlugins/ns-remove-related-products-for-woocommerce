<?
/*
Plugin Name: NS Remove Related Products for WooCommerce
Plugin URI: http://nsthemes.com
Description: Remove Related Products from your shop page
Version: 2.0.0
Author: NsThemes
Author URI: http://nsthemes.com
License: GNU General Public License v2.0
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! defined( 'REMOVE_RELATED_NS_PLUGIN_DIR' ) )
    define( 'REMOVE_RELATED_NS_PLUGIN_DIR', untrailingslashit( dirname( __FILE__ ) ) );

if ( ! defined( 'REMOVE_RELATED_NS_PLUGIN_URL' ) )
    define( 'REMOVE_RELATED_NS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/* *** include css admin *** */
function ns_remove_related_css_admin( $hook ) {
	wp_enqueue_style('ns-style-remove-related-admin', REMOVE_RELATED_NS_PLUGIN_URL . '/css/style.css');
}
add_action( 'admin_enqueue_scripts', 'ns_remove_related_css_admin' );

/* *** include js admin *** */
function ns_remove_related_js( $hook ) {
	wp_enqueue_script('ns-script-remove-related', REMOVE_RELATED_NS_PLUGIN_URL . '/js/custom.js', array('jquery'));
	wp_localize_script( 'ns-script-remove-related', 'nsdismissremoverelated', array( 'ajax_url' => admin_url( 'admin-ajax.php' )));
}
add_action( 'admin_enqueue_scripts', 'ns_remove_related_js' );

/* *** include css *** */
function ns_remove_related_css( $hook ) {
	wp_enqueue_style('ns-style-remove-related-css', REMOVE_RELATED_NS_PLUGIN_URL . '/css/style_remove.css');
}
add_action( 'wp_enqueue_scripts', 'ns_remove_related_css' );


function ns_remove_related_products( $args ) {
	return array();
}
add_filter('woocommerce_related_products_args','ns_remove_related_products', 10); 

function ns_remove_related_notice() {
	settings_fields('woocommerce_remove_related_free_options');
	$ns_notice_dismissed = '';
	if (get_option('ns_remove_related') == 'yes' ) { $ns_notice_dismissed = 'ns-notice-dismissed'; }
   ?>
   <div id="ns-remove-related-notice" class="notice notice-success is-dismissible <? echo $ns_notice_dismissed; ?>">
       <p><a href="http://www.nsthemes.com/product/remove-related-products-for-woocommerce/?utm_source=Remove%20Related%20Product%20Bannerone&utm_medium=Bannerone%20dashboard&utm_campaign=Remove%20Related%20Product%20Bannerone%20premium"><img src="<?php echo REMOVE_RELATED_NS_PLUGIN_URL; ?>/img/bannerooone.png" style="width: 100%; height: auto;"></a></p>
	   <button class="ns-notice-dismiss" type="button">Dismiss this notice</button>
   </div>
   <?php
}
add_action( 'admin_notices', 'ns_remove_related_notice' );

add_action( 'wp_ajax_ns_dismiss_remove_related_ajax', 'ns_dismiss_remove_related_ajax' );
add_action( 'wp_ajax_nopriv_ns_dismiss_remove_related_ajax', 'ns_dismiss_remove_related_ajax' );

function ns_dismiss_remove_related_ajax() {
	update_option( 'ns_remove_related', 'yes' );
    die();
}

function ns_remove_related_free_options_group() {
    register_setting('woocommerce_remove_related_free_options', 'ns_remove_related');
}
 
add_action ('admin_init', 'ns_remove_related_free_options_group');

?>